<?php

/**
 * Contoller of authentification
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AuthController extends BController
{
    /**
     * Default action
     *
     * @var string
     */
    public $defaultAction = 'login';

    /**
     * Route after log in
     *
     * @var string
     */
    protected $_redirectRoute = 'dashboard/default';

    public function init()
    {
        $this->pageTitle = B::t('backend', 'login_title');
        parent::init();
    }

    /**
     * Login (Action)
     */
    public function actionLogin()
    {
        if (Yii::app()->user->getIsGuest()) {
            // models
            $models = array();
            $models['LoginForm'] = new LoginForm();

            if (Yii::app()->request->isPostRequest && isset($_POST['LoginForm'])) {
                $models['LoginForm']->attributes = $_POST['LoginForm'];
                if ($models['LoginForm']->validate() && $models['LoginForm']->login()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }

            $this->dynamicRender('login', array(
                'models' => $models
            ));
        } else {
            $this->redirect($this->_redirectRoute);
        }
    }

    /**
     * Logout (Action)
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }
}