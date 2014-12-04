<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UModuleCmsUrlRules extends UBaseModuleUrlRules
{
    /**
     * @see UBaseModuleUrlRules::getRules()
     */
    public function getRules() {
        // languages
        $i18nIds = USiteI18n::model()->getI18nIds(false, true);
        $language = implode('|', $i18nIds);

        return array(
            '<language:(' . $language . ')>' => Yii::app()->params['baseModuleApplication']. '/cms/cms/index/u_cms_page_name/home',
            '<language:(' . $language . ')>/<cms>' => Yii::app()->params['baseModuleApplication']. '/cms/cms/index/u_cms_page_name/<cms>'
        );
    }
}