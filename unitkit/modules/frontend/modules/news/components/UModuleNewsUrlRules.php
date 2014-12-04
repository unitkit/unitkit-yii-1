<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UModuleNewsUrlRules extends UBaseModuleUrlRules
{
    /**
     * @see UBaseModuleUrlRules::getRules()
     */
    public function getRules() {
        // languages
        $i18nIds = USiteI18n::model()->getI18nIds(false, true);
        $language = '';
        foreach ($i18nIds as $i18nId) {
            $language .= '"'.$i18nId . '",';
        }
        $language = substr($language, 0, -1);

        // pages
        $cmsPages = UCmsPageI18n::model()->findAll(array(
            'condition' => 'i18n_id IN ('.$language.') AND u_cms_page_id = :u_cms_page_id',
            'params' => array(':u_cms_page_id' => Unitkit::v('frontend', 'u_cms_page_id:news'))
        ));

        $rules = array();
        foreach($cmsPages as $cmsPage) {
            $rules['<language:('.$cmsPage->i18n_id.')>/<u_cms_page_name:('.$cmsPage->slug.')>'] = Yii::app()->params['baseModuleApplication']. '/news/news';
            $rules['<language:('.$cmsPage->i18n_id.')>/<u_cms_page_name:('.$cmsPage->slug.')>/*'] = Yii::app()->params['baseModuleApplication']. '/news/news/index';
        }
        return $rules;
    }
}