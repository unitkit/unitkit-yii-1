<?php

/**
 * Controller of dashboard
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class DefaultController extends UController
{
    /**
     * @see BController::init()
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = Yii::app()->name;
    }

    /**
     * @see CController::filters()
     */
    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    /**
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index',
                ),
                'roles' => array(Unitkit::v('backend', 'u_role_id:navigate'))
            ),
            array(
                'deny'
            )
        );
    }

    public function actionIndex()
    {
        $this->dynamicRender('index', array());
    }
}