<?php

/**
 * This class manages the URLs of Yii Web applications.
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BUrlManager extends BBaseUrlManager
{
    /**
     * Module name
     *
     * @var string
     */
    protected $_moduleName;

    /**
     * Get module name
     *
     * @return string
     */
    protected function getModuleName()
    {
        if ($this->_moduleName === null)
            $this->_moduleName = basename(dirname(__DIR__));

        return $this->_moduleName;
    }

    /**
     * Get rules
     *
     * @return string
     */
    protected function getRules()
    {
        $i18nIds = BSiteI18n::model()->getI18nIds();

        $language = '';
        foreach ($i18nIds as $i18nId)
            $language .= $i18nId . '|';
        $language = substr($language, 0, - 1);

        $moduleName = $this->getModuleName();

        return array(
            '<language:(' . $language . ')>/' => $moduleName . '/auth/auth/login',
            '<language:(' . $language . ')>/<controller:\w+>/<action:page>/*' => $moduleName . '/<controller>/<action>',
            '<language:(' . $language . ')>/<module:\w+>/<controller:\w+>/<action:\w+>/*' => $moduleName . '/<module>/<controller>/<action>',
            '<language:(' . $language . ')>/<controller:\w+>/<action:\w+>/*' => $moduleName . '/<controller>/<action>',
            '<language:(' . $language . ')>/<module:\w+>/*' => $moduleName . '/<module>',
            '<module:\w+>/<controller:\w+>/<action:\w+>/*' => $moduleName . '/<module>/<controller>/<action>',
            '<controller:\w+>/<action:\w+>/*' => $moduleName . '/<controller>/<action>',
            '<module:\w+>/*' => $moduleName . '/<module>'
        );
    }
}