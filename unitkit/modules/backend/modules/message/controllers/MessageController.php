<?php

/**
 * Controller of message
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageController extends UAutoController
{
    protected $_model = 'UMessage';
    protected $_modelI18n = 'UMessageI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UMessageGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UMessageGroupI18n',
                'select' => array(
                    'id' => 'u_message_group_id',
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
     * List all models (Action)
     */
    public function actionList()
    {
        // related data
        $relatedData = array();

        // get list of i18n ID
        $relatedData['i18nIds'] = USiteI18n::model()->getI18nIds();
        // set the current language at first
        $tmp = array(
            'curI18nId' => array(
                Yii::app()->language => $relatedData['i18nIds'][Yii::app()->language]
            )
        );
        unset($relatedData['i18nIds'][Yii::app()->language]);
        $relatedData['i18nIds'] = $tmp['curI18nId'] + $relatedData['i18nIds'];
        unset($tmp);

        $model = new UMessage('search');
        $model->unsetAttributes();

        // set filter
        if (isset($_GET['UMessageSearch'])) {
            $model->attributes = $_GET['UMessageSearch'];
        }

        // search
        $dataProvider = $model->search(Yii::app()->language);
        $dataProvider->getSort()->route = $this->id . '/list';

        // set pagination parameters
        $pagination = $dataProvider->getPagination();
        $pagination->route = $this->id . '/list';
        $pagination->pageSize = UInterfaceSetting::model()->getSettings($this->id . ':' . $this->module->id, Yii::app()->user->id)->page_size;
        $pagination->itemCount = $dataProvider->totalItemCount;

        // load models
        $models = $this->_loadTranslationModels($dataProvider->getData(), $relatedData['i18nIds']);

        // data to update
        $postData = array();
        if (isset($_POST['uMessages'])) {
            $postData['uMessages'] = $_POST['uMessages'];
        }
        if (isset($_POST['uMessageI18ns'])) {
            $postData['uMessageI18ns'] = $_POST['uMessageI18ns'];
        }

        // update models
        $isSaved = ! empty($_POST) ? $this->_saveTranslationModels($models, $postData) : false;

        // set related data
        $relatedData['UMessageGroupI18n[name]'] = UHtml::listDataComboBox('UMessageGroupI18n', array(
            'u_message_group_id',
            'name'
        ), array(
            'condition' => 'i18n_id = :i18nId',
            'params' => array(
                ':i18nId' => Yii::app()->language
            )
        ));

        // set view
        $view = 'list/main';
        if (isset($_REQUEST['partial'])) {
            $view = 'list/_table';
        }

        $this->pageTitle = Unitkit::t('backend', 'message_message_list_title');

        $this->dynamicRender($view, array(
            'pagination' => $pagination,
            'models' => $models,
            'sort' => $dataProvider->getSort(),
            'model' => $model,
            'relatedData' => $relatedData,
            'isSaved' => $isSaved
        ));
    }

    /**
     * Load the translations of the model
     *
     * @param mixed $i18nIds list of i18n ID
     * @return mixed array of models
     */
    protected function _loadTranslationModels($data, $i18nIds)
    {
        $models = array();

        foreach ($data as $d) {
            $models[$d->id]['UMessage'] = $d;
            $models[$d->id]['UMessage']->setScenario('update');

            foreach ($i18nIds as $i18nId) {
                foreach ($d->{'uMessageI18n_' . $i18nId} as $uMessageI18n)
                    $models[$d->id]['uMessageI18ns'][$uMessageI18n->i18n_id] = $uMessageI18n;
            }

            foreach ($i18nIds as $i18nId) {
                if (! isset($models[$d->id]['uMessageI18ns'][$i18nId])) {
                    $models[$d->id]['uMessageI18ns'][$i18nId] = new UMessageI18n('insert');
                    $models[$d->id]['uMessageI18ns'][$i18nId]->i18n_id = $i18nId;
                    $models[$d->id]['uMessageI18ns'][$i18nId]->u_message_id = $d->id;
                } else
                    $models[$d->id]['uMessageI18ns'][$i18nId]->setScenario('translate');
            }
        }
        return $models;
    }

    /**
     * @see BBaseAutoController::afterDeleteModels()
     */
    public function _afterDeleteModels()
    {
        // refresh cache
        Yii::app()->messages->refreshCache();
    }

    /**
     * Insert models (Action)
     */
    public function actionCreate()
    {
        // set related data
        $relatedData = array();

        // get list of i18n ID
        $relatedData['i18nIds'] = USiteI18n::model()->getI18nIds();
        // set the current language at first
        $tmp = array(
            'curI18nId' => array(
                Yii::app()->language => $relatedData['i18nIds'][Yii::app()->language]
            )
        );
        unset($relatedData['i18nIds'][Yii::app()->language]);
        $relatedData['i18nIds'] = $tmp['curI18nId'] + $relatedData['i18nIds'];
        unset($tmp);

        // data to update
        $postData = $_POST;

        // get models
        $models = $this->loadAdvancedEditModels(null, $relatedData['i18nIds']);

        // save models
        $isSaved = Yii::app()->request->isPostRequest && ! empty($_POST) ? $this->_saveEditModels($models, $postData) : false;

        $this->pageTitle = Unitkit::t('backend', 'message_message_create_title');

        if (Yii::app()->request->isAjaxRequest) {
            if ($isSaved) {
                // set primary key
                $pk = array(
                    'id' => $models['UMessage']->id
                );

                $html = $this->renderPartial('edit/edit', array(
                    'tpl' => '_update',
                    'models' => $models,
                    'relatedData' => $relatedData,
                    'isSaved' => $isSaved,
                    'pk' => $pk
                ), true);
            } else {
                $html = $this->renderPartial('edit/edit', array(
                    'tpl' => '_create',
                    'models' => $models,
                    'relatedData' => $relatedData,
                    'isSaved' => $isSaved,
                    'pk' => null
                ), true);
            }

            echo json_encode(array(
                'html' => $html,
                'title' => $this->pageTitle,
                'isSaved' => $isSaved
            ));
            Yii::app()->end();
        } else {
            $this->render('edit/edit', array(
                'tpl' => '_create',
                'models' => $models,
                'relatedData' => $relatedData,
                'isSaved' => $isSaved,
                'pk' => null
            ));
        }
    }

    /**
     * Update models (Action)
     */
    public function actionUpdate()
    {
        // set related data
        $relatedData = array();

        // get list of i18n ID
        $relatedData['i18nIds'] = USiteI18n::model()->getI18nIds();
        // set the current language at first
        $tmp = array(
            'curI18nId' => array(
                Yii::app()->language => $relatedData['i18nIds'][Yii::app()->language]
            )
        );
        unset($relatedData['i18nIds'][Yii::app()->language]);
        $relatedData['i18nIds'] = $tmp['curI18nId'] + $relatedData['i18nIds'];
        unset($tmp);

        // set primary key
        $pk = array();
        $pk['id'] = $_GET['id'];

        // data to update
        $postData = $_POST;

        // get models
        $models = $this->loadAdvancedEditModels($pk, $relatedData['i18nIds']);

        // save models
        $isSaved = Yii::app()->request->isPostRequest && ! empty($_POST) ? $this->_saveEditModels($models, $postData) : false;

        $this->pageTitle = Unitkit::t('backend', 'message_message_update_title');

        // update the primary key
        if ($isSaved) {
            $pk['id'] = $models['UMessage']->id;
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'tpl' => '_update',
                'models' => $models,
                'relatedData' => $relatedData,
                'isSaved' => $isSaved,
                'pk' => $pk
            ),
            array('is_saved' => $isSaved)
        );
    }

    /**
     * Load models
     *
     * @param mixed $pk the primary key of the model
     * @param mided $i18nIds array of i18n ID
     * @return mixed array of models
     */
    protected function loadAdvancedEditModels($pk = null, $i18nIds)
    {
        // array of models
        $models = array();

        $models['UMessage'] = ($pk !== null) ? UMessage::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models['UMessage'] === null) {
            if ($pk !== null) {
                throw new CHttpException(403);
            }
            $models['UMessage'] = new UMessage('insert');
        } else {
            $models['UMessage']->setScenario('update');
        }

        $tmp = array();
        foreach ($i18nIds as $i18nId)
            $tmp[] = $i18nId;

        if ($pk !== null) {
            foreach (UMessageI18n::model()->findAllByAttributes(array(
                'u_message_id' => $pk['id'],
                'i18n_id' => $tmp
            )) as $modelI18n) {
                $models['uMessageI18ns'][$modelI18n->i18n_id] = $modelI18n;
            }
        }

        foreach ($i18nIds as $i18nId) {
            if (! isset($models['uMessageI18ns'][$i18nId])) {
                $models['uMessageI18ns'][$i18nId] = null;
            }

            if ($models['uMessageI18ns'][$i18nId] === null) {
                $models['uMessageI18ns'][$i18nId] = new UMessageI18n('preInsert');
            } else {
                $models['uMessageI18ns'][$i18nId]->setScenario('update');
            }
        }

        return $models;
    }

    /**
     * Save models
     *
     * @param mixed $models array of models
     * @param mixed $postData array of data (data to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveEditModels(&$models, &$postData)
    {
        // initialize the status
        $isSaved = false;

        // begin a transaction
        $transaction = $models['UMessage']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postData['UMessage']))
                $models['UMessage']->attributes = $postData['UMessage'];
            if (isset($postData['uMessageI18ns'])) {
                foreach ($models['uMessageI18ns'] as $i18nId => &$modelI18n) {
                    if (isset($postData['uMessageI18ns'][$i18nId]['translation']) && $postData['uMessageI18ns'][$i18nId]['translation'] != '') {
                        $modelI18n->attributes = $postData['uMessageI18ns'][$i18nId];
                        $modelI18n->i18n_id = $i18nId;
                        $modelI18n->validate();
                    }
                }
            }

            // validate attributes
            $models['UMessage']->validate();

            // save the model
            if ($models['UMessage']->save()) {
                foreach ($models['uMessageI18ns'] as $i18nId => &$modelI18n) {
                    $modelI18n->setScenario('insert');
                    $modelI18n->u_message_id = $models['UMessage']->id;
                    if ($modelI18n->translation != '' && ! $modelI18n->save())
                        throw new Exception();
                }
                // commit
                $transaction->commit();
                // refresh cache
                Yii::app()->messages->refreshCache();
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
     * Save the translations
     *
     * @param mixed $models the list of models to be translated
     * @param mixed $postData array of data (data to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveTranslationModels(&$models, &$postData)
    {
        // status
        $isSaved = false;

        // begin a transaction
        $transaction = UMessage::model()->dbConnection->beginTransaction();
        try {
            // validate models
            foreach ($models as $id => &$model) {
                if (isset($postData['uMessages'][$id])) {
                    $model['UMessage']->attributes = $postData['uMessages'][$id];
                    $model['UMessage']->validate();
                }

                foreach ($model['uMessageI18ns'] as $i18nId => &$UMessageI18n) {
                    if (isset($postData['uMessageI18ns'][$id][$i18nId])) {
                        $UMessageI18n->attributes = $postData['uMessageI18ns'][$id][$i18nId];
                        $UMessageI18n->validate();
                    }
                }
            }

            // save models
            foreach ($models as $id => &$model) {
                if ($model['UMessage']->save()) {
                    foreach ($model['uMessageI18ns'] as $i18nId => &$UMessageI18n) {
                        if ($UMessageI18n->translation != '') {
                            if ($UMessageI18n->save())
                                $isSaved = true;
                            else {
                                $isSaved = false;
                                throw new Exception();
                            }
                        } elseif ($UMessageI18n->scenario == 'translate') {
                            $UMessageI18n->delete();
                        }
                    }
                } else {
                    $isSaved = false;
                    throw new Exception();
                }
            }

            // commit
            if ($isSaved) {
                $transaction->commit();
                // refresh cache
                Yii::app()->messages->refreshCache();
            }
        } catch (Exception $e) {
            if ($transaction->active)
                $transaction->rollback();
        }
        return $isSaved;
    }
}