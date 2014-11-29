<?php
/**
 * Controller of db schema
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UrlManagerController extends BController
{

    /**
     * @see BController::init()
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @see CController::filters()
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('flush'), 'roles' => $this->defaultRoles['update']),
            array('deny')
        );
    }

    /**
     * Flush cache of db schema (action)
     */
    public function actionFlush()
    {
        $this->pageTitle = Yii::app()->name . ' - ' . B::t('backend', 'url_manager_refresh_title');

        Yii::app()->urlManager->clearAllCache();

        $this->dynamicRender('/flush/main', array(
            'title' => B::t('backend', 'url_manager_refresh_title'),
            'content' => B::t('backend', 'url_is_refreshed')
        ));
    }
}