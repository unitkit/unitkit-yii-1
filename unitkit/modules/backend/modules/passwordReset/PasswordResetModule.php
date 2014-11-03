<?php
/**
 * Password reset module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PasswordResetModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'passwordReset.models.*',
            'passwordReset.components.*'
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