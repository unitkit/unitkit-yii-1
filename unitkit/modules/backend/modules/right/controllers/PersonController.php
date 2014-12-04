<?php

/**
 * Controller of person
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonController extends UAutoController
{
    protected $_model = 'UPerson';

    /**
     * Get array of crud components
     *
     * @return multitype
     */
    protected function _advancedComboBox()
    {
        return array(
            'UI18nI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UI18nI18n',
                'select' => array(
                    'id' => 'u_i18n_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(
                        ':i18nId' => $_GET['language']
                    ),
                    'order' => 'name ASC',
                    'limit' => 10
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0
            )
        );
    }

    /**
     * Load models
     *
     * @param mixed $pk the primary key of the model
     * @return mixed array of models
     */
    protected function _loadEditModels($pk = null)
    {
        // array of models
        $models = array();

        $models['UPerson'] = ($pk !== null) ? UPerson::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models['UPerson'] === null) {
            if ($pk !== null)
                throw new CHttpException(403);
            $models['UPerson'] = new UPerson('insert');
        } else
            $models['UPerson']->setScenario('update');

        $models['UPerson']->password = '';

        if (Yii::app()->user->checkAccess('administrate:backend/right')) {
            $models['UGroup'] = new UGroup('search');
            $models['UGroup']->unsetAttributes();
            foreach ($models['UGroup']->search(Yii::app()->language)->getData() as $UGroup)
                $models['UGroups'][$UGroup->id] = $UGroup;

            if (! empty($models['UGroups'])) {
                // get all person/group relations
                $models['UPersonGroups'] = array();

                if ($pk !== null) {
                    $models['UPersonGroup'] = new UPersonGroup();
                    $models['UPersonGroup']->unsetAttributes();
                    foreach ($models['UPersonGroup']->findAll(array(
                        'condition' => 'u_person_id = :uPersonId',
                        'params' => array(
                            ':uPersonId' => $pk['id']
                        )
                    )) as $uPersonGroup) {
                        $models['UPersonGroups'][$uPersonGroup->u_group_id] = $uPersonGroup;
                        $models['UPersonGroups'][$uPersonGroup->u_group_id]->setScenario('update');
                    }
                }

                foreach ($models['UGroups'] as $uGroup)
                    if (! isset($models['UPersonGroups'][$uGroup->id]))
                        $models['UPersonGroups'][$uGroup->id] = new UPersonGroup('insert');
            }
        }

        return $models;
    }

    /**
     * Save models
     *
     * @param mixed $models array of models
     * @param mixed $postData array of datas (datas to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveEditModels(&$models, &$postData)
    {
        // initialize the status
        $isSaved = false;

        // begin a transaction
        $transaction = $models['UPerson']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postData['UPerson']))
                $models['UPerson']->attributes = $postData['UPerson'];

            if (isset($models['UPersonGroups'])) {
                foreach ($models['UPersonGroups'] as $uGroupId => &$UPersonGroup) {
                    if (isset($postData['UPersonGroups'][$uGroupId])) {
                        // get current scenario
                        $scenario = $UPersonGroup->getScenario();
                        // set and validate attributes
                        if ($scenario == 'insert' && $postData['UPersonGroups'][$uGroupId] == 1) {
                            $UPersonGroup->u_group_id = $uGroupId;
                            $UPersonGroup->validate();
                        } elseif ($scenario == 'update' && $postData['UPersonGroups'][$uGroupId] == 0) {
                            $UPersonGroup->u_group_id = null;
                            $UPersonGroup->setScenario('delete');
                        }
                    }
                }
            }

            // validate attributes
            $models['UPerson']->validate();

            // save the model
            if ($models['UPerson']->save()) {
                if (isset($models['UPersonGroups'])) {
                    foreach ($models['UPersonGroups'] as $uGroupId => &$UPersonGroup) {
                        // get current scenario
                        $scenario = $UPersonGroup->getScenario();
                        // update informations
                        if ($scenario == 'insert' && $UPersonGroup->u_group_id !== null) {
                            $UPersonGroup->u_person_id = $models['UPerson']->id;
                            if (! $UPersonGroup->save())
                                throw new Exception();
                        } elseif ($scenario == 'delete') {
                            // u_group_id is temporary filled in order to remove record (this attribute belong to the PK)
                            $UPersonGroup->u_group_id = $uGroupId;
                            $UPersonGroup->delete();
                            $UPersonGroup->u_group_id = null;
                        }
                    }
                }

                // commit
                $transaction->commit();

                // flush rights in cache
                Yii::app()->rights->deleteCachePersonDynKey($models['UPerson']->id);

                // update the status
                $isSaved = true;

                $models['UPerson']->password = '';
            } else {
                throw new Exception(500);
            }
        } catch (Exception $e) {
            // roll back
            $transaction->rollback();
        }
        return $isSaved;
    }
}