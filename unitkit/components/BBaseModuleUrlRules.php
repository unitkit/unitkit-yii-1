<?php

/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
abstract class BBaseModuleUrlRules
{
    /**
     * Get module rules
     *
     * @return array
     */
    abstract public function getRules();

    /**
     * Build rules of modules using cms page
     *
     * @param $pageId Cms page ID
     * @param $module Module name
     * @param string $defaultController Default controller name
     * @return array
     */
    protected function buildModuleCmsPageRules($pageId, $module, $defaultController = 'default') {
        // languages
        $i18nIds = BSiteI18n::model()->getI18nIds(false, true);
        $language = '';
        foreach ($i18nIds as $i18nId) {
            $language .= '"'.$i18nId . '",';
        }
        $language = substr($language, 0, -1);

        // pages
        $cmsPages = BCmsPageI18n::model()->findAll(array(
            'condition' => 'i18n_id IN ('.$language.') AND b_cms_page_id = :b_cms_page_id',
            'params' => array(':b_cms_page_id' => $pageId)
        ));

        $rules = array();
        foreach($cmsPages as $cmsPage) {
            $rules['<language:('.$cmsPage->i18n_id.')>/<b_cms_page_name:('.$cmsPage->slug.')>'] = Yii::app()->params['baseModuleApplication']. '/'.$module.'/'.$defaultController;
            $rules['<language:('.$cmsPage->i18n_id.')>/<b_cms_page_name:('.$cmsPage->slug.')>/<controller:\w+>/<action:\w+>/*'] = Yii::app()->params['baseModuleApplication']. '/'.$module.'/<controller>/<action>';
        }

        return $rules;
    }
}