<?php

/**
 * Controller of message
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageController extends BAutoController
{
    protected $_model = 'BMessage';
    protected $_modelI18n = 'BMessageI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BMessageGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BMessageGroupI18n',
                'select' => array(
                    'id' => 'b_message_group_id',
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
        $relatedData['i18nIds'] = BSiteI18n::model()->getI18nIds();
        // set the current language at first
        $tmp = array(
            'curI18nId' => array(
                Yii::app()->language => $relatedData['i18nIds'][Yii::app()->language]
            )
        );
        unset($relatedData['i18nIds'][Yii::app()->language]);
        $relatedData['i18nIds'] = $tmp['curI18nId'] + $relatedData['i18nIds'];
        unset($tmp);

        $model = new BMessage('search');
        $model->unsetAttributes();

        // set filter
        if (isset($_GET['BMessageSearch'])) {
            $model->attributes = $_GET['BMessageSearch'];
        }

        // search
        $dataProvider = $model->search(Yii::app()->language);
        $dataProvider->getSort()->route = $this->id . '/list';

        // set pagination parameters
        $pagination = $dataProvider->getPagination();
        $pagination->route = $this->id . '/list';
        $pagination->pageSize = BInterfaceSetting::model()->getSettings($this->id . ':' . $this->module->id, Yii::app()->user->id)->page_size;
        $pagination->itemCount = $dataProvider->totalItemCount;

        // load models
        $models = $this->_loadTranslationModels($dataProvider->getData(), $relatedData['i18nIds']);

        // data to update
        $postData = array();
        if (isset($_POST['bMessages'])) {
            $postData['bMessages'] = $_POST['bMessages'];
        }
        if (isset($_POST['bMessageI18ns'])) {
            $postData['bMessageI18ns'] = $_POST['bMessageI18ns'];
        }

        // update models
        $isSaved = ! empty($_POST) ? $this->_saveTranslationModels($models, $postData) : false;

        // set related data
        $relatedData['BMessageGroupI18n[name]'] = BHtml::listDatasCombobox('BMessageGroupI18n', array(
            'b_message_group_id',
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

        $this->pageTitle = B::t('backend', 'message_message_list_title');

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
            $models[$d->id]['BMessage'] = $d;
            $models[$d->id]['BMessage']->setScenario('update');

            foreach ($i18nIds as $i18nId) {
                foreach ($d->{'bMessageI18n_' . $i18nId} as $bMessageI18n)
                    $models[$d->id]['bMessageI18ns'][$bMessageI18n->i18n_id] = $bMessageI18n;
            }

            foreach ($i18nIds as $i18nId) {
                if (! isset($models[$d->id]['bMessageI18ns'][$i18nId])) {
                    $models[$d->id]['bMessageI18ns'][$i18nId] = new BMessageI18n('insert');
                    $models[$d->id]['bMessageI18ns'][$i18nId]->i18n_id = $i18nId;
                    $models[$d->id]['bMessageI18ns'][$i18nId]->b_message_id = $d->id;
                } else
                    $models[$d->id]['bMessageI18ns'][$i18nId]->setScenario('translate');
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
        $relatedData['i18nIds'] = BSiteI18n::model()->getI18nIds();
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

        $this->pageTitle = B::t('backend', 'message_message_create_title');

        if (Yii::app()->request->isAjaxRequest) {
            if ($isSaved) {
                // set primary key
                $pk = array(
                    'id' => $models['BMessage']->id
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
        $relatedData['i18nIds'] = BSiteI18n::model()->getI18nIds();
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

        $this->pageTitle = B::t('backend', 'message_message_update_title');

        // update the primary key
        if ($isSaved) {
            $pk['id'] = $models['BMessage']->id;
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

        $models['BMessage'] = ($pk !== null) ? BMessage::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models['BMessage'] === null) {
            if ($pk !== null) {
                throw new CHttpException(403);
            }
            $models['BMessage'] = new BMessage('insert');
        } else {
            $models['BMessage']->setScenario('update');
        }

        $tmp = array();
        foreach ($i18nIds as $i18nId)
            $tmp[] = $i18nId;

        if ($pk !== null) {
            foreach (BMessageI18n::model()->findAllByAttributes(array(
                'b_message_id' => $pk['id'],
                'i18n_id' => $tmp
            )) as $modelI18n) {
                $models['bMessageI18ns'][$modelI18n->i18n_id] = $modelI18n;
            }
        }

        foreach ($i18nIds as $i18nId) {
            if (! isset($models['bMessageI18ns'][$i18nId])) {
                $models['bMessageI18ns'][$i18nId] = null;
            }

            if ($models['bMessageI18ns'][$i18nId] === null) {
                $models['bMessageI18ns'][$i18nId] = new BMessageI18n('preInsert');
            } else {
                $models['bMessageI18ns'][$i18nId]->setScenario('update');
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
        $transaction = $models['BMessage']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postData['BMessage']))
                $models['BMessage']->attributes = $postData['BMessage'];
            if (isset($postData['bMessageI18ns'])) {
                foreach ($models['bMessageI18ns'] as $i18nId => &$modelI18n) {
                    if (isset($postData['bMessageI18ns'][$i18nId]['translation']) && $postData['bMessageI18ns'][$i18nId]['translation'] != '') {
                        $modelI18n->attributes = $postData['bMessageI18ns'][$i18nId];
                        $modelI18n->i18n_id = $i18nId;
                        $modelI18n->validate();
                    }
                }
            }

            // validate attributes
            $models['BMessage']->validate();

            // save the model
            if ($models['BMessage']->save()) {
                foreach ($models['bMessageI18ns'] as $i18nId => &$modelI18n) {
                    $modelI18n->setScenario('insert');
                    $modelI18n->b_message_id = $models['BMessage']->id;
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
        $transaction = BMessage::model()->dbConnection->beginTransaction();
        try {
            // validate models
            foreach ($models as $id => &$model) {
                if (isset($postData['bMessages'][$id])) {
                    $model['BMessage']->attributes = $postData['bMessages'][$id];
                    $model['BMessage']->validate();
                }

                foreach ($model['bMessageI18ns'] as $i18nId => &$BMessageI18n) {
                    if (isset($postData['bMessageI18ns'][$id][$i18nId])) {
                        $BMessageI18n->attributes = $postData['bMessageI18ns'][$id][$i18nId];
                        $BMessageI18n->validate();
                    }
                }
            }

            // save models
            foreach ($models as $id => &$model) {
                if ($model['BMessage']->save()) {
                    foreach ($model['bMessageI18ns'] as $i18nId => &$BMessageI18n) {
                        if ($BMessageI18n->translation != '') {
                            if ($BMessageI18n->save())
                                $isSaved = true;
                            else {
                                $isSaved = false;
                                throw new Exception();
                            }
                        } elseif ($BMessageI18n->scenario == 'translate') {
                            $BMessageI18n->delete();
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