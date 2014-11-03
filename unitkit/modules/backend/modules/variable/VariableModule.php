<?php
/**
 * Variable module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'variable.models.*',
            'variable.components.*'
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