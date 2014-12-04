<?php
/**
 * Controller of db schema
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class DbSchemaController extends UController
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
        $this->pageTitle = Yii::app()->name . ' - ' . Unitkit::t('backend', 'db_shema_refresh_title');

        // Load all tables of the application in the schema
        Yii::app()->db->schema->getTables();
        // clear the cache of all loaded tables
        Yii::app()->db->schema->refresh();

        $this->dynamicRender('/flush/main', array(
            'title' => Unitkit::t('backend', 'db_shema_refresh_title'),
            'content' => Unitkit::t('backend', 'db_schema_is_refreshed')
        ));
    }
}