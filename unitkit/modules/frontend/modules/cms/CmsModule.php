<?php

/**
 * CMS module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class CmsModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'cms.models.*',
            'cms.components.*'
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