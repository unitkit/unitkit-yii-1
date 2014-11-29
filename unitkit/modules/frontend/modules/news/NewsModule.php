<?php

/**
 * News module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'news.models.*',
            'news.components.*'
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