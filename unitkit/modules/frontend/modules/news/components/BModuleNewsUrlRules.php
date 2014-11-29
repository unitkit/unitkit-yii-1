<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BModuleNewsUrlRules extends BBaseModuleUrlRules
{
    /**
     * @see BBaseModuleUrlRules::getRules()
     */
    public function getRules() {
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
            'params' => array(':b_cms_page_id' => B::v('frontend', 'b_cms_page_id:news'))
        ));

        $rules = array();
        foreach($cmsPages as $cmsPage) {
            $rules['<language:('.$cmsPage->i18n_id.')>/<b_cms_page_name:('.$cmsPage->slug.')>'] = Yii::app()->params['baseModuleApplication']. '/news/news';
            $rules['<language:('.$cmsPage->i18n_id.')>/<b_cms_page_name:('.$cmsPage->slug.')>/*'] = Yii::app()->params['baseModuleApplication']. '/news/news/index';
        }
        return $rules;
    }
}