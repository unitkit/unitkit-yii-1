<?php

/**
 * Controller of person
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonController extends BAutoController
{
    protected $_model = 'BPerson';

    /**
     * Get array of crud components
     *
     * @return multitype
     */
    protected function _advancedConbobox()
    {
        return array(
            'BI18nI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BI18nI18n',
                'select' => array(
                    'id' => 'b_i18n_id',
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

        $models['BPerson'] = ($pk !== null) ? BPerson::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models['BPerson'] === null) {
            if ($pk !== null)
                throw new CHttpException(403);
            $models['BPerson'] = new BPerson('insert');
        } else
            $models['BPerson']->setScenario('update');

        $models['BPerson']->password = '';

        if (Yii::app()->user->checkAccess('administrate:backend/right')) {
            $models['BGroup'] = new BGroup('search');
            $models['BGroup']->unsetAttributes();
            foreach ($models['BGroup']->search(Yii::app()->language)->getData() as $BGroup)
                $models['BGroups'][$BGroup->id] = $BGroup;

            if (! empty($models['BGroups'])) {
                // get all person/group relations
                $models['BPersonGroups'] = array();

                if ($pk !== null) {
                    $models['BPersonGroup'] = new BPersonGroup();
                    $models['BPersonGroup']->unsetAttributes();
                    foreach ($models['BPersonGroup']->findAll(array(
                        'condition' => 'b_person_id = :bPersonId',
                        'params' => array(
                            ':bPersonId' => $pk['id']
                        )
                    )) as $bPersonGroup) {
                        $models['BPersonGroups'][$bPersonGroup->b_group_id] = $bPersonGroup;
                        $models['BPersonGroups'][$bPersonGroup->b_group_id]->setScenario('update');
                    }
                }

                foreach ($models['BGroups'] as $bGroup)
                    if (! isset($models['BPersonGroups'][$bGroup->id]))
                        $models['BPersonGroups'][$bGroup->id] = new BPersonGroup('insert');
            }
        }

        return $models;
    }

    /**
     * Save models
     *
     * @param mixed $models array of models
     * @param mixed $postDatas array of datas (datas to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveEditModels(&$models, &$postDatas)
    {
        // initialize the status
        $isSaved = false;

        // begin a transaction
        $transaction = $models['BPerson']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postDatas['BPerson']))
                $models['BPerson']->attributes = $postDatas['BPerson'];

            if (isset($models['BPersonGroups'])) {
                foreach ($models['BPersonGroups'] as $bGroupId => &$BPersonGroup) {
                    if (isset($postDatas['BPersonGroups'][$bGroupId])) {
                        // get current scenario
                        $scenario = $BPersonGroup->getScenario();
                        // set and validate attributes
                        if ($scenario == 'insert' && $postDatas['BPersonGroups'][$bGroupId] == 1) {
                            $BPersonGroup->b_group_id = $bGroupId;
                            $BPersonGroup->validate();
                        } elseif ($scenario == 'update' && $postDatas['BPersonGroups'][$bGroupId] == 0) {
                            $BPersonGroup->b_group_id = null;
                            $BPersonGroup->setScenario('delete');
                        }
                    }
                }
            }

            // validate attributes
            $models['BPerson']->validate();

            // save the model
            if ($models['BPerson']->save()) {
                if (isset($models['BPersonGroups'])) {
                    foreach ($models['BPersonGroups'] as $bGroupId => &$BPersonGroup) {
                        // get current scenario
                        $scenario = $BPersonGroup->getScenario();
                        // update informations
                        if ($scenario == 'insert' && $BPersonGroup->b_group_id !== null) {
                            $BPersonGroup->b_person_id = $models['BPerson']->id;
                            if (! $BPersonGroup->save())
                                throw new Exception();
                        } elseif ($scenario == 'delete') {
                            // b_group_id is temporary filled in order to remove record (this attribute belong to the PK)
                            $BPersonGroup->b_group_id = $bGroupId;
                            $BPersonGroup->delete();
                            $BPersonGroup->b_group_id = null;
                        }
                    }
                }

                // commit
                $transaction->commit();

                // flush rights in cache
                Yii::app()->rights->deleteCachePersonDynKey($models['BPerson']->id);

                // update the status
                $isSaved = true;

                $models['BPerson']->password = '';
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