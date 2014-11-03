<?php

/**
 * I18n module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class I18nModule extends CWebModule
{

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'i18n.models.*',
            'i18n.components.*'
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }
}