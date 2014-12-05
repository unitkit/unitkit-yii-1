<?php

/**
 * This class manages the URLs of Yii Web applications.
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UUrlManager extends UBaseUrlManager
{
    /**
     * Application name
     *
     * @var string
     */
    protected $_appName;

    /**
     * Get url rules of modules
     *
     * @return array
     */
    protected function getModulesUrlRules()
    {
        $rules = array();
        foreach(Yii::app()->modules[Yii::app()->params['baseModuleApplication']]['modules'] as $module) {
            $path = Yii::app()->basePath.'/modules/frontend/modules/'.$module.'/components/UModule'.ucfirst($module).'UrlRules.php';
            if (is_file($path)) {
                include $path;
                $moduleUrlRules = 'UModule' . ucfirst($module) . 'UrlRules';
                $obj = new $moduleUrlRules();
                $rules += $obj->getRules();
            }
        }
        return $rules;
    }

    /**
     * Get rules
     *
     * @return string
     */
    protected function getRules()
    {
        // languages
        $i18nIds = USiteI18n::model()->getI18nIds(false, true);

        $language = implode('|', $i18nIds);

        // rules
        return $this->getModulesUrlRules() + array(
            '<language:(' . $language . ')>/<module:\w+>/<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>/<controller>/<action>',
            '<language:(' . $language . ')>/<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<controller>/<action>',
            '<language:(' . $language . ')>/<module:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>'
        );
    }
}