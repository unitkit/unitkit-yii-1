<?php

/**
 * Controller of profil
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ProfileController extends UController
{
    /**
     * Default action
     *
     * @var string
     */
    public $defaultAction = 'update';

    /**
     * @see BController::init()
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = Yii::app()->name . ' - ' . Unitkit::t('backend', 'profile_edit_title');
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
                    'update',
                    'advCombobox'
                ),
                'roles' => $this->defaultRoles['update']
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * List related model (Action)
     */
    public function actionAdvCombobox()
    {
        $args = array();
        switch ($_GET['name']) {
            case 'UI18nI18n[name]':
                $args['search'] = $_GET['search'];
                $args['model'] = 'UI18nI18n';
                $args['select'] = array(
                    'id' => 'u_i18n_id',
                    'text' => 'name'
                );
                $args['criteria'] = array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(
                        ':i18nId' => $_GET['language']
                    ),
                    'limit' => 10,
                    'order' => 'name ASC'
                );
                $args['cache'] = 10;
                break;
        }

        if (! empty($args)) {
            echo CJSON::encode(UHtml::listDataAdvCombobox($args['model'], $args['select'], $args['search'], $args['criteria'], $args['cache']));
        }
        Yii::app()->end();
    }

    /**
     * Update models (Action)
     */
    public function actionUpdate()
    {
        // datas to update
        $postDatas = $_POST;

        // related datas
        $relatedDatas = array();

        // get models
        $models = $this->loadEditModels();

        // save models
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postDatas) ? $this->saveEditModels($models, $postDatas) : false;

        // remove password
        $models['PersonProfile']->password = '';
        $models['PersonProfile']->old_password = '';
        $models['PersonProfile']->repeat_password = '';

        // template
        $template = 'edit/main';

        if (isset($_REQUEST['partial'])) // partial request
            $template = 'edit/_form';

        $this->dynamicRender($template, array(
            'models' => $models,
            'relatedDatas' => $relatedDatas,
            'isSaved' => $isSaved
        ));
    }

    /**
     * Save models
     *
     * @param mixed $models array of models
     * @param mixed $postDatas array of datas (datas to update)
     * @param mixed $models array of models
     * @return bool true on success and false in the other cases
     */
    protected function saveEditModels(&$models, &$postDatas)
    {
        // initialize the status
        $isSaved = false;

        // begin a transaction
        $transaction = $models['PersonProfile']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postDatas['PersonProfile']) && isset($models['PersonProfile']->id))
                $models['PersonProfile']->attributes = $postDatas['PersonProfile'];

                // save the model
            if ($models['PersonProfile']->save()) {
                // commit
                $transaction->commit();

                // flush rights in cache
                Yii::app()->rights->deleteCachePersonDynKey($models['PersonProfile']->id);

                // update the status
                $isSaved = true;
            } else
                throw new Exception();
        } catch (Exception $e) {
            // roll back
            if ($transaction->active)
                $transaction->rollback();
        }
        return $isSaved;
    }

    /**
     * Load models
     *
     * @return array of Models
     * @throws CHttpException
     */
    protected function loadEditModels()
    {
        $PersonProfile = new PersonProfile();
        $models['PersonProfile'] = $PersonProfile->findByPk(Yii::app()->user->id);

        if ($models['PersonProfile'] === null) {
            throw new CHttpException(403);
        } else {
            $models['PersonProfile']->setScenario('update');
        }

        return $models;
    }
}