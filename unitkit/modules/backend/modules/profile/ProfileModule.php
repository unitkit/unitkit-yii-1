<?php

/**
 * Profil module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ProfileModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'profile.models.*',
            'profile.components.*'
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