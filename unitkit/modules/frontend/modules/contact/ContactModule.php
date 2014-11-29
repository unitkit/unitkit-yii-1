<?php

/**
 * Contact module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ContactModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'contact.models.*',
            'contact.components.*'
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