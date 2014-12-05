<?php
/**
 * This class manages the page
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseCmsPageFilter extends CFilter
{
    /**
     * Array of rules
     *
     * @var array
     */
	private $_rules = array();

	/**
	 * Set rules
	 *
	 * @param array $rules Array of rules
	 */
	public function setRules($rules)
	{
		$this->_rules = array_merge(
			array(
				'slug' => isset($_REQUEST['u_cms_page_name']) ? $_REQUEST['u_cms_page_name'] : ''
			),
			$rules
		);
	}

	/**
	 * Get rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		if (empty($this->_rules)) {
			$this->setRules(array());
		}

		return $this->_rules;
	}

	/**
	 * Get common prefix key
	 *
	 * @return string
	 */
	public static function getPrefixKey()
	{
        return 'cms_page_prefix_key';
	}

	/**
	 * Get common prefix. The common prefix is used in all cms pages.
	 *
	 * @return string
	 */
	public static function getPrefix()
	{
	    $prefixKey = Yii::app()->cmsCache->get(self::getPrefixKey());
	    if ($prefixKey === false) {
	        $prefixKey = uniqid(mt_rand(), true);
	        Yii::app()->cmsCache->set(self::getPrefixKey(), $prefixKey);
	    }

	    return $prefixKey;
	}

	/**
	 * Remove common prefix. The common prefix is used in all cms pages.
	 * If prefix is remove, all cms page cache will be reset
	 */
	public static function removePrefix()
	{
	    Yii::app()->cmsCache->delete(self::getPrefixKey());
	}

	/**
	 * Get prefix page key
	 *
	 * @param string $slug Slug
	 * @return string
	 */
	public static function getPrefixPageKey($slug)
	{
        return 'cms_page_prefix_page_key_'.$slug;
	}

	/**
	 * Get prefix page. The prefix page is use in all pages.
	 *
	 * @param string $slug Slug
	 * @return string
	 */
	public static function getPrefixPage($slug)
	{
	   $prefixKey = Yii::app()->cmsCache->get(self::getPrefixPageKey($slug));
	   if ($prefixKey === false) {
	       $prefixKey = uniqid(mt_rand(), true);
	       Yii::app()->cmsCache->set(self::getPrefixPageKey($slug), $prefixKey);
	   }

	   return $prefixKey;
	}

	/**
	 * Remove prefix page. If prefix page is reset, the page cache will be reset in each languages.
	 *
	 * @param string $slug Slug
	 */
	public static function removePrefixPage($slug)
	{
	    Yii::app()->cmsCache->delete(self::getPrefixPageKey($slug));
	}

	/**
	 * Get cache key used to get page models
	 *
	 * @param string $slug slug
	 * @param string $language language ID
	 * @return string
	 */
	public static function getPageCacheKey($slug, $language)
	{
	    return 'cms_page_'.self::getPrefix().'_'.self::getPrefixPage($slug).'_'.$language.'_'.$slug;
	}

	/**
	 * Get cache key used to get page containers
	 *
	 * @param string $slug slug
	 * @param string $language language ID
	 * @return string
	 */
	public static function getPageContainersCacheKey($slug, $language)
	{
	    return 'cms_page_containers_'.self::getPrefix().'_'.self::getPrefixPage($slug).'_'.$language.'_'.$slug;
	}

	/**
	 * Parse html content to find widget
	 *
	 * @param string $html
	 * @param CController $controller
	 * @return mixed
	 */
	protected function _parseContent($html, &$controller)
	{
	    $list = array();
	    preg_match_all("#\<cms_widget id=\"(.*)\">(.*)</cms_widget>#msU", $html, $list, PREG_SET_ORDER);
	    $find = array();
	    $replace = array();

	    foreach ($list as $function) {
	        $model = UCmsWidget::model()->findByPk($function[1]);
	        if($model !== null) {
	            $arg = CJSON::decode($model->arg);
	            if($arg === null) {
	                $arg = array();
	            }
    	        $find[] = '<cms_widget id="'.$function[1].'">'.$function[2].'</cms_widget>';

    	        $replace[] = $controller->widget($model->path, $arg, true);
	        }
	    }
	    return str_replace($find, $replace, $html);
	}

	/**
	 * @see CFilter::preFilter()
	 */
    protected function preFilter($filterChain)
    {
    	$rules = $this->getRules();

    	if (empty($rules['actions']) || in_array($filterChain->action->id, $rules['actions'])) {
    		if (empty($rules['slug'])) {
                throw new CHttpException(404);
    		}

            $cache = Yii::app()->cmsCache->get(self::getPageCacheKey($rules['slug'], Yii::app()->language));

    		if (false === $cache) {
    		    $cache = array();
    		    $models = array();

                $models['UCmsPage'] = UCmsPage::model()
	    			->with(array(
	    				'uCmsLayout' => array('select' => 'id, path, view'),
		    			'uCmsPageI18ns' => array(
	    					'joinType' => 'INNER JOIN',
	    					'on' => 'uCmsPageI18ns.i18n_id = :i18nId',
	    					'condition' => 'uCmsPageI18ns.slug = :slug',
							'params' => array(':i18nId' => Yii::app()->language, ':slug' => $rules['slug']),
	    				)
	    			))
	    			->find(array(
	    			    'select' => 'id, u_cms_layout_id, cache_duration',
	    			    'condition' => 'activated = :activated',
	    			    'params' => array(':activated' => 1)
	    			));

                if ($models['UCmsPage'] !== null) {
                    $models['UCmsPageContent'] = UCmsPageContent::model()
                        ->with('uCmsPageContentI18n')
                        ->findAllByAttributes(
                            array('u_cms_page_id' => $models['UCmsPage']->id),
                            array('order' => '`index` ASC')
                        );

                    if (! empty($models['UCmsPageContent'])) {
                        foreach ($models['UCmsPageContent'] as &$UCmsPageContent) {
                            if (! empty($UCmsPageContent->uCmsPageContentI18n)) {
                                $cache['containers'][$UCmsPageContent->index] = $this->_parseContent(
                                    $UCmsPageContent->uCmsPageContentI18n->content, $filterChain->controller
                                );
                            }
                        }
                    }

                    $cache['page']['layout'] = array(
                    	'path' => $models['UCmsPage']->uCmsLayout->path,
                        'view' => $models['UCmsPage']->uCmsLayout->view,
                    );
                    $cache['page']['html_title'] = $models['UCmsPage']->uCmsPageI18ns[0]->html_title;
                    $cache['page']['html_description'] = $models['UCmsPage']->uCmsPageI18ns[0]->html_description;
                    $cache['page']['html_keywords'] = $models['UCmsPage']->uCmsPageI18ns[0]->html_keywords;

    	    		if($models['UCmsPage']->cache_duration > 0) {
    	    			Yii::app()->cmsCache->set(
    	    			    self::getPageCacheKey($rules['slug'], Yii::app()->language),
    	    			    $cache,
    	    			    $models['UCmsPage']->cache_duration
                        );
    	    		}

    	    		unset($models);
                }
    		}

    		if (! empty($cache)) {
    			// layout
    			$filterChain->controller->layout = $cache['page']['layout']['path'];
    			$filterChain->controller->cmsView = $cache['page']['layout']['view'];

    			// head
    			$filterChain->controller->pageTitle = $cache['page']['html_title'];
    			Yii::app()->clientScript->registerMetaTag($cache['page']['html_description'], 'description');
    			Yii::app()->clientScript->registerMetaTag($cache['page']['html_keywords'], 'keywords');

                if (! empty($cache['containers'])) {
        			foreach ($cache['containers'] as $index => $container) {
        				$filterChain->controller->cmsPageContents[$index] = $container;
        			}
                }

                return true;
    		}
    		else {
    			throw new CHttpException(404);
    		}
    	}
    }
}