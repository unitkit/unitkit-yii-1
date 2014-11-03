<?php

/**
 * Controller of group role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupRoleController extends BController
{
    /**
     * Default action
     *
     * @var string
     */
    public $defaultAction = 'edit';

    /**
     * @see BController::init()
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = B::t('backend', 'right_group_role_edit_title');
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
                    'edit'
                ),
                'roles' => array(
                    'administrate:backend/right'
                )
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * Edit model (Action)
     */
    public function actionEdit()
    {
        // datas to update
        $postDatas = array();
        if (isset($_POST['BGroupRoles']))
            $postDatas['BGroupRoles'] = $_POST['BGroupRoles'];

            // get models
        $models = $this->loadModelEdit();

        // related datas
        $relatedDatas = array();

        // update | $isSaved can be null or boolean
        $isSaved = isset($postDatas['BGroupRoles']) ? $this->saveModels($models, $postDatas) : null;

        // render function
        $renderFunction = Yii::app()->request->isAjaxRequest ? 'renderPartial' : 'render';

        // render view
        $html = $this->$renderFunction('edit/main', array(
            'relatedDatas' => $relatedDatas,
            'models' => $models,
            'isSaved' => $isSaved
        ), true);

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array_merge(array(
                'html' => $html,
                'title' => $this->pageTitle
            ), isset($_REQUEST['renderScript']) ? Yii::app()->clientScript->renderDynamicScripts() : array()));
            Yii::app()->end();
        } else
            echo $html;
    }

    /**
     * Load models
     */
    protected function loadModelEdit()
    {
        $models = array();
        $models['BGroup'] = new BGroup();
        $models['BGroup']->unsetAttributes();
        $models['BGroups'] = $models['BGroup']->search(Yii::app()->language)->model->findAll(array(
            'select' => 'id'
        ));

        $models['BRole'] = new BRole();
        $models['BRole']->unsetAttributes();
        $models['BRoles'] = $models['BRole']->search(Yii::app()->language)->model->findAll(array(
            'select' => 'id',
            'order' => 'id ASC'
        ));

        $models['BGroupRole'] = new BGroupRole();
        $models['BGroupRole']->unsetAttributes();

        $models['BGroupRoles'] = array();
        foreach ($models['BGroupRole']->findAll() as $BGroupRole) {
            $models['BGroupRoles'][$BGroupRole->b_group_id][$BGroupRole->b_role_id] = $BGroupRole;
            $models['BGroupRoles'][$BGroupRole->b_group_id][$BGroupRole->b_role_id]->setScenario('update');
        }

        foreach ($models['BGroups'] as $BGroup)
            foreach ($models['BRoles'] as $BRole)
                if (! isset($models['BGroupRoles'][$BGroup->id][$BRole->id]))
                    $models['BGroupRoles'][$BGroup->id][$BRole->id] = new BGroupRole('insert');

        return $models;
    }

    /**
     * Save models
     *
     * @param $models array of models
     * @param $postDatas array of post datas
     * @throws Exception
     * @return boolean
     */
    protected function saveModels(&$models, &$postDatas)
    {
        // is saved
        $isSaved = false;

        // begin transaction
        $transaction = $models['BRole']->dbConnection->beginTransaction();
        try {
            foreach ($models['BGroupRoles'] as $groupId => &$BGroupRoles) {
                foreach ($BGroupRoles as $roleId => &$BGroupRole) {
                    if (isset($postDatas['BGroupRoles'][$groupId][$roleId])) {
                        // get current scenario
                        $scenario = $BGroupRole->getScenario();

                        // if the input is checked
                        if ($scenario == 'insert' && $postDatas['BGroupRoles'][$groupId][$roleId] == 1) {
                            $BGroupRole->b_group_id = $groupId;
                            $BGroupRole->b_role_id = $roleId;
                            if (! $BGroupRole->save())
                                throw new Exception();
                        } elseif ($scenario == 'update' && $postDatas['BGroupRoles'][$groupId][$roleId] == 0) {
                            if (! $BGroupRole->delete())
                                throw new Exception();
                            $BGroupRole->b_group_id = null;
                            $BGroupRole->b_role_id = null;
                        }
                    }
                }
            }
            // commit
            $transaction->commit();

            // delete cache
            Yii::app()->rights->deleteCacheRightsDynKey();

            // update status
            $isSaved = true;
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $isSaved;
    }
}