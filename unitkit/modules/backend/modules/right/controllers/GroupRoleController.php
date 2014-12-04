<?php

/**
 * Controller of group role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupRoleController extends UController
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
        $this->pageTitle = Unitkit::t('backend', 'right_group_role_edit_title');
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
        if (isset($_POST['UGroupRoles']))
            $postDatas['UGroupRoles'] = $_POST['UGroupRoles'];

            // get models
        $models = $this->loadModelEdit();

        // related datas
        $relatedDatas = array();

        // update | $isSaved can be null or boolean
        $isSaved = isset($postDatas['UGroupRoles']) ? $this->saveModels($models, $postDatas) : null;

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
        $models['UGroup'] = new UGroup();
        $models['UGroup']->unsetAttributes();
        $models['UGroups'] = $models['UGroup']->search(Yii::app()->language)->model->findAll(array(
            'select' => 'id'
        ));

        $models['URole'] = new URole();
        $models['URole']->unsetAttributes();
        $models['URoles'] = $models['URole']->search(Yii::app()->language)->model->findAll(array(
            'select' => 'id',
            'order' => 'id ASC'
        ));

        $models['UGroupRole'] = new UGroupRole();
        $models['UGroupRole']->unsetAttributes();

        $models['UGroupRoles'] = array();
        foreach ($models['UGroupRole']->findAll() as $UGroupRole) {
            $models['UGroupRoles'][$UGroupRole->u_group_id][$UGroupRole->u_role_id] = $UGroupRole;
            $models['UGroupRoles'][$UGroupRole->u_group_id][$UGroupRole->u_role_id]->setScenario('update');
        }

        foreach ($models['UGroups'] as $UGroup)
            foreach ($models['URoles'] as $URole)
                if (! isset($models['UGroupRoles'][$UGroup->id][$URole->id]))
                    $models['UGroupRoles'][$UGroup->id][$URole->id] = new UGroupRole('insert');

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
        $transaction = $models['URole']->dbConnection->beginTransaction();
        try {
            foreach ($models['UGroupRoles'] as $groupId => &$UGroupRoles) {
                foreach ($UGroupRoles as $roleId => &$UGroupRole) {
                    if (isset($postDatas['UGroupRoles'][$groupId][$roleId])) {
                        // get current scenario
                        $scenario = $UGroupRole->getScenario();

                        // if the input is checked
                        if ($scenario == 'insert' && $postDatas['UGroupRoles'][$groupId][$roleId] == 1) {
                            $UGroupRole->u_group_id = $groupId;
                            $UGroupRole->u_role_id = $roleId;
                            if (! $UGroupRole->save())
                                throw new Exception();
                        } elseif ($scenario == 'update' && $postDatas['UGroupRoles'][$groupId][$roleId] == 0) {
                            if (! $UGroupRole->delete())
                                throw new Exception();
                            $UGroupRole->u_group_id = null;
                            $UGroupRole->u_role_id = null;
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