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
     * Get rules
     *
     * @return string
     */
    protected function getRules()
    {
        $i18nIds = USiteI18n::model()->getI18nIds();
        $language = implode('|', $i18nIds);

        return array(
            '<language:(' . $language . ')>/' => Yii::app()->params['baseModuleApplication'] . '/auth/auth/login',
            '<language:(' . $language . ')>/<controller:\w+>/<action:page>/*' => Yii::app()->params['baseModuleApplication'] . '/<controller>/<action>',
            '<language:(' . $language . ')>/<module:\w+>/<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>/<controller>/<action>',
            '<language:(' . $language . ')>/<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<controller>/<action>',
            '<language:(' . $language . ')>/<module:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>',
            '<module:\w+>/<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>/<controller>/<action>',
            '<controller:\w+>/<action:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<controller>/<action>',
            '<module:\w+>/*' => Yii::app()->params['baseModuleApplication'] . '/<module>'
        );
    }
}