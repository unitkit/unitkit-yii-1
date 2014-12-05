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
            'right.components.web.dataViews.*',
            'right.components.web.dataViews.group.*',
            'right.components.web.dataViews.person.*',
            'right.components.web.dataViews.role.*'
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