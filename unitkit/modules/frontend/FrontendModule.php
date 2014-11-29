<?php

class FrontendModule extends CWebModule
{
    public $albumPhotoUrlDest;

    public function init()
    {
        $this->setImport(array(
            'frontend.models.*',
            'frontend.components.*'
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