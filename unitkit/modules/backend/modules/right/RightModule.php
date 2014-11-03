<?php
/**
 * Right module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RightModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'right.models.*',
            'right.components.*',
            'right.components.group.*',
            'right.components.person.*',
            'right.components.role.*'
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