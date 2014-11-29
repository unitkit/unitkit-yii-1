<?php

/**
 * Site module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'site.models.*',
            'site.components.*'
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else {
            return false;
        }
    }
}