<?php

/**
 * @see CController
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
abstract class BBaseAutoController extends BBaseController
{

    /**
     * Default action
     *
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * Model class name
     *
     * @var string
     */
    protected $_model;

    /**
     * Model I18
     *
     * @var string
     */
    protected $_modelI18n;

    /**
     * Link between models
     *
     * @var string
     */
    protected $_linkModels;

    /**
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('list', 'advCombobox', 'settings', 'export'),
                'roles' => $this->getDefaultRoles('consult')
            ),
            array(
                'allow',
                'actions' => array('create', 'advCombobox', 'upload'),
                'roles' => $this->getDefaultRoles('create')
            ),
            array(
                'allow',
                'actions' => array('update', 'translate', 'editRow', 'advCombobox', 'refreshRow', 'upload'),
                'roles' => $this->getDefaultRoles('update')
            ),
            array(
                'allow',
                'actions' => array('deleteRows'),
                'roles' => $this->getDefaultRoles('delete')
            ),
            array('deny')
        );
    }

    /**
     * Get the link between models
     */
    public function getLinkModels()
    {
        if ($this->_linkModels !== null) {
            return $this->_linkModels;
        }

        if ($this->_modelI18n !== null) {
            $modelI18n = $this->_modelI18n;
            $relations = $modelI18n::model()->relations();
            foreach ($relations as $relation) {
                if ($relation[0] === CActiveRecord::BELONGS_TO && $relation[1] === $this->_model) {
                    $this->_linkModels = $relation[2];
                    break;
                }
            }
        }

        return $this->_linkModels;
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
     * Get array of crud components
     *
     * @return array
     */
    public function getCrudComponents()
    {
        $componentPrefix = str_replace('Controller', '', get_called_class());

        return array(
            'editDataView' => $componentPrefix . 'EditDataView',
            'editRowDataView' => $componentPrefix . 'EditRowDataView',
            'listDataView' => $componentPrefix . 'ListDataView',
            'listRowDataView' => $componentPrefix . 'ListRowDataView',
            'settingsDataView' => $componentPrefix . 'SettingsDataView',
            'translateDataView' => $componentPrefix . 'TranslateDataView'
        );
    }

    /**
     * Get parameters used from advanced comboBox action
     *
     * @return array
     */
    protected function _advancedComboBox()
    {
        return array(
			/*'Model[name]' => array(
				'search' => $_GET['search'],
				'model' => 'Model name',
				'select' => array(
                    'id' => 'id',
                    'text' => 'name'
                ),
				'criteria' => array(
                ),
				'cache' => isset($_GET['cache']) ? 10 : 0
			),*/
		);
    }

    /**
     * Defined the parameters used from uploader action
     *
     * @return array
     */
    protected function _uploader()
    {
        return array(
			/*'Model[name]' => array(
				'model' => 'Model name',
				'field' => 'field name',
				'uploader' => Yii::app()->uploader
			),*/
		);
    }

    /**
     * Get parameters used from uploader action
     *
     * @param string $key Uploader key
     * @return mixed
     */
    public function getUploader($key = null)
    {
        if($key !== null) {
            return $this->_uploader()[$key];
        } else {
            return $this->_uploader();
        }
    }

    /**
     * List related model (Action)
     */
    public function actionAdvComboBox()
    {
        if (isset($_GET['name'])) {
            $data = $this->_advancedComboBox();
            if (! empty($data[$_GET['name']])) {
                echo CJSON::encode(BHtml::listDataAdvCombobox($data[$_GET['name']]['model'], $data[$_GET['name']]['select'], $data[$_GET['name']]['search'], $data[$_GET['name']]['criteria'], $data[$_GET['name']]['cache']));
            }
        }
        Yii::app()->end();
    }

    /**
     * Upload file (Action)
     */
    public function actionUpload()
    {
        if (isset($_POST['upload'])) {
            $uploader = $this->getUploader($_POST['upload']);
            if (! empty($uploader)) {
                $info = $uploader['uploader']->saveTmpFile($uploader['model'], $uploader['field'],
                    ! empty($_POST['overview']) ? json_decode(html_entity_decode($_POST['overview']), true) : array()
                );

                if (false !== $info) {
                    echo CJSON::encode(array(
                        'key' => $info['key'],
                        'name' => $info['name'],
                        'overview' => $info['overview']
                    ));
                }
                Yii::app()->end();
            }
        } elseif (isset($_GET['overview'], $_GET['key'])) {
            $uploader = $this->getUploader($_GET['overview']);
            if (! empty($uploader)) {
                $uploader['uploader']->loadTempOverview($_GET['key']);
            }
        }
    }

    /**
     * Csv export (action)
     */
    public function actionExport()
    {
        // get model
        $model = new $this->_model('search');
        $model->unsetAttributes();

        // set filter
        if (isset($_GET[$this->_model])) {
            $model->attributes = $_GET[$this->_model];
        }

        $dataProvider = $model->search(Yii::app()->language);
        $dataProvider->setPagination(false);

        // generate csv export
        $export = new BActiveRecordExportCsv($this->_model, $dataProvider->getData());
        $export->download();
    }

    /**
     * Settings (Action)
     */
    public function actionSettings()
    {
        // data to update
        $postData = array();
        if (isset($_POST['BInterfaceSetting'])) {
            $postData['BInterfaceSetting'] = $_POST['BInterfaceSetting'];
        }

        // load / save data
        $data = $this->_loadSettingsModels();
        $isSaved = ! empty($postData) ? $this->_saveSettingsModels($data, $postData) : false;

        // related data
        $relatedData = array();

        $this->dynamicRender('settings/settings', array(
            'dataView' => new $this->crudComponents['settingsDataView']($data, $relatedData, $isSaved)
        ), array(
            'isSaved' => $isSaved
        ));
    }

    /**
     * List all models (Action)
     */
    public function actionList()
    {
        // get model
        $model = new $this->_model('search');
        $model->unsetAttributes();

        // set filter
        if (isset($_GET[$this->_model])) {
            $model->attributes = $_GET[$this->_model];
        }

        // search
        $dataProvider = $model->search(Yii::app()->language);
        // sort
        $sort = $dataProvider->getSort();
        // route
        $sort->route = $this->id . '/list';

        // pagination parameters
        $pagination = $dataProvider->getPagination();
        $pagination->route = $this->id . '/list';
        $pagination->pageSize = BInterfaceSetting::model()->getSettings($this->id . ':' . $this->module->id, Yii::app()->user->id)->page_size;
        $pagination->itemCount = $dataProvider->totalItemCount;

        // data
        $data = $dataProvider->getData();

        // related data
        $relatedData = $this->_loadRelatedData();

        // template
        $template = isset($_REQUEST['partial']) ? 'list/_table' : 'list/main';

        $jsonParams = array();
        if (Yii::app()->request->isAjaxRequest) {
            // filters
            $filtersData = array();
            if (isset($_GET[$this->_model])) {
                $filtersData[$this->_model] = $_GET[$this->_model];
            }
            if (isset($_GET[$sort->sortVar])) {
                $filtersData[$sort->sortVar] = $_GET[$sort->sortVar];
            }

            $jsonParams = array(
                'filters' => http_build_query($filtersData)
            );
        }

        $this->dynamicRender(
            $template,
            array(
                'dataView' => new $this->crudComponents['listDataView'](
                    $data, $relatedData, $model, $sort, $pagination, $this
                )
            ),
            $jsonParams
        );
    }

    /**
     * Translate the models (Action)
     */
    public function actionTranslate()
    {
        if ($this->_modelI18n === null) {
            throw new CHttpException(404);
        }

        // related data
        $relatedData = array();

        // list of i18n ID
        $relatedData['i18nIds'] = BSiteI18n::model()->getI18nIds();
        $relatedData['i18nIds'] = array(
            Yii::app()->language => $relatedData['i18nIds'][Yii::app()->language]
        ) + $relatedData['i18nIds'];

        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // primary key
        $pk = array();
        if (is_string($pkId)) {
            $pk[$pkId] = $_GET[$pkId];
        } else {
            foreach ($pkId as $v) {
                $pk[$v] = $_GET[$v];
            }
        }

        // data
        $data = $this->_loadTranslationModels($relatedData['i18nIds'], $pk);

        // data to update
        $postData = $_POST;

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveTranslationModels($data, $postData) : false;

        $data = array(
            Yii::app()->language => $data[Yii::app()->language]
        ) + $data;

        $this->dynamicRender(
            'translate/translate',
            array(
                'dataView' => new $this->crudComponents['translateDataView'](
                    $data, $relatedData, $pk, $isSaved, $this
                )
            )
        );
    }

    /**
     * Delete list of rows (Action)
     */
    public function actionDeleteRows()
    {
        $return = array('success' => false);

        if (Yii::app()->request->isPostRequest && isset($_POST['rows']) && is_array($_POST['rows'])) {
            $model = $this->_model;
            if (! empty($model::$upload)) {
                foreach ($_POST['rows'] as $tmp) {
                    parse_str($tmp, $pk);
                    $record = $model::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk);
                    foreach ($model::$upload as $column => $data) {
                        if($record->$column !== '') {
                            $uploader = $this->getUploader(BHtml::resolveName($model, $column));
                            $record->uploadOperations[$column]['action'] = BUploader::ACTION_DELETE;
                            $record->uploadOperations[$column]['value'] = $record->$column;
                            $uploader['uploader']->updateFile($record, $column, $data['pathDest']);
                        }
                    }
                    $record->delete();
                }
            } else {
                foreach ($_POST['rows'] as $tmp) {
                    parse_str($tmp, $pk);
                    $model::model()->deleteByPk(count($pk) == 1 ? reset($pk) : $pk);
                }
            }
            unset($model);

            $this->_afterDeleteModels();

            $return['success'] = true;
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    /**
     * This method is called when models are deleted
     */
    protected function _afterDeleteModels()
    {}

    /**
     * Refresh a row (Action)
     */
    public function actionRefreshRow()
    {
        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // primary key
        $pk = array();
        if (is_string($pkId)) {
            $pk[$pkId] = $_GET[$pkId];
        } else {
            foreach ($pkId as $v) {
                $pk[$v] = $_GET[$v];
            }
        }

        // refresh the row
        echo CJSON::encode(array(
            'html' => $this->_refreshRow($pk)
        ));
        Yii::app()->end();
    }

    /**
     * Insert models (Action)
     */
    public function actionCreate()
    {
        // data to update
        $postData = $_POST;

        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // data
        $data = $this->_loadEditModels();

        // related data
        $relatedData = $this->_loadRelatedData();

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        $pk = array();
        if ($isSaved) {
            // set primary key
            $pk = array();
            if (is_string($pkId)) {
                $pk[$pkId] = $data[$this->_model]->$pkId;
            } else {
                foreach ($pkId as $v) {
                    $pk[$v] = $data[$this->_model]->$v;
                }
            }
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new $this->crudComponents['editDataView'](
                    $data, $this->_loadRelatedData(), $pk, $isSaved, $this
                )
            )
        );
    }

    /**
     * Update models (Action)
     */
    public function actionUpdate()
    {
        // data to update
        $postData = $_POST;

        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // primary key
        $pk = array();
        if (is_string($pkId)) {
            $pk[$pkId] = $_GET[$pkId];
        } else {
            foreach ($pkId as $v) {
                $pk[$v] = $_GET[$v];
            }
        }

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = $this->_loadRelatedData();

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        // update the primary key
        if ($isSaved) {
            if (is_string($pkId)) {
                $pk[$pkId] = $data[$this->_model]->$pkId;
            } else {
                foreach ($pkId as $v) {
                    $pk[$v] = $data[$this->_model]->$v;
                }
            }
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new $this->crudComponents['editDataView'](
                    $data, $relatedData, $pk, $isSaved, $this
                )
            )
        );
    }

    /**
     * Edit a row (Action)
     *
     * @throws Exception
     */
    public function actionEditRow()
    {
        // data to update
        $postData = $_POST;

        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // primary key
        $pk = array();
        if (is_string($pkId)) {
            $pk[$pkId] = $_GET[$pkId];
        } else {
            foreach ($pkId as $v) {
                $pk[$v] = $_GET[$v];
            }
        }

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = $this->_loadRelatedData();

        // save models
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        if (! $isSaved) {
            // render view
            $html = $this->bRenderPartial(
                'list/_tbodyRowEdit',
                array(
                    'dataView' => new $this->crudComponents['editRowDataView'](
                        $data, $relatedData, $pk, $isSaved
                    )
                ),
                true
            );
        } else {
            // update the primary key
            if (is_string($pkId)) {
                $pk[$pkId] = $data[$this->_model]->$pkId;
            } else {
                foreach ($pkId as $v) {
                    $pk[$v] = $data[$this->_model]->$v;
                }
            }

            // refresh the row
            $html = $this->_refreshRow($pk);
        }

        echo CJSON::encode(array(
            'html' => $html,
            'refreshRow' => $isSaved
        ));
        Yii::app()->end();
    }

    /**
     * Refresh a row
     *
     * @param mixed $pk the primary key of the model to be refreshed
     * @return string html
     * @throws CHttpException
     */
    protected function _refreshRow($pk)
    {
        // get the model
        $model = new $this->_model('search');
        $model->unsetAttributes();

        $pkId = $model->tableSchema->primaryKey;

        // set filter
        if (is_string($pkId)) {
            $model->$pkId = $pk[$pkId];
        } else {
            foreach ($pkId as $v) {
                $model->$v = $pk[$v];
            }
        }

        // get data
        $data = $model->search(Yii::app()->language)->getData();
        if (! isset($data[0])) {
            throw new CHttpException(500);
        }

        // data view
        $dataView = new $this->crudComponents['listRowDataView']($data[0], $pk);

        // render view
        return $this->bRenderPartial('list/_tbodyRow', array(
            'dataView' => $dataView
        ), true);
    }

    /**
     * Load related data used in data view
     *
     * @return array
     */
    protected function _loadRelatedData()
    {
        return array();
    }

    /**
     * Load models
     *
     * @param mixed $pk the primary key of the model
     * @return array Array of models
     * @throws CHttpException
     */
    protected function _loadEditModels($pk = null)
    {
        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // array of models
        $models = array();

        $models[$this->_model] = ($pk !== null) ? $model::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models[$this->_model] === null) {
            if ($pk !== null) {
                throw new CHttpException(403);
            }
            $models[$this->_model] = new $this->_model('insert');
        } else {
            $models[$this->_model]->setScenario('update');
        }

        if ($this->_modelI18n !== null) {
            // model I18n
            $modelI18n = $this->_modelI18n;

            $models[$this->_modelI18n] = ($pk !== null) ? $modelI18n::model()->findByPk(array(
                $this->linkModels => $pk[$pkId],
                'i18n_id' => Yii::app()->language
            )) : null;

            if ($models[$this->_modelI18n] === null) {
                $models[$this->_modelI18n] = new $this->_modelI18n('preInsert');
            } else {
                $models[$this->_modelI18n]->setScenario('update');
            }
        }

        return $models;
    }

    /**
     * Load the translations of the model
     *
     * @param mixed $i18nIds list of i18n ID
     * @param mixed $pk the primary key of the model
     * @return mixed array of models
     */
    protected function _loadTranslationModels($i18nIds, $pk)
    {
        // model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // curent model
        $modelI18n = $this->_modelI18n;

        // array of models
        $models = array();

        foreach ($modelI18n::model()->findAllByAttributes(array(
            $this->linkModels => $pk[$pkId]
        )) as $d) {
            $models[$d->i18n_id] = $d;
        }

        foreach ($i18nIds as $i18nId) {
            if (! isset($models[$i18nId])) {
                $models[$i18nId] = new $modelI18n('insert');
                $models[$i18nId]->i18n_id = $i18nId;
                $models[$i18nId]->{$this->linkModels} = $pk[$pkId];
            } else {
                $models[$i18nId]->setScenario('update');
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
     * @throws CException
     */
    protected function _saveEditModels(&$models, &$postData)
    {
        $isSaved = false;
        $isNewRecord[$this->_model] = $models[$this->_model]->isNewRecord;

        // model
        $modelName = $this->_model;

        // begin a transaction
        $transaction = $models[$this->_model]->dbConnection->beginTransaction();
        try {
            // save old files path
            $oldFilesPath = array();
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    $oldFilesPath[$this->_model][$column] = $models[$this->_model]->$column;
                }
            }

            // set attributes
            if (isset($postData[$this->_model])) {
                $models[$this->_model]->attributes = $postData[$this->_model];
            }
            if (isset($postData[$this->_modelI18n])) {
                $models[$this->_modelI18n]->attributes = $postData[$this->_modelI18n];
                $models[$this->_modelI18n]->i18n_id = Yii::app()->language;
            }
            // set files attributes and fetch array of operations
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    $uploader = $this->getUploader(BHtml::resolveName($modelName, $column));
                    $uploader['uploader']->setAttribute($models[$this->_model], $column, $oldFilesPath[$this->_model][$column]);
                }
            }

            $modelIsSaved = false;
            // validate attributes
            if ($this->_modelI18n !== null) {
                $modelIsSaved = ($models[$this->_modelI18n]->validate() & $models[$this->_model]->validate()) && $models[$this->_model]->save(false);
            } else {
                $modelIsSaved = $models[$this->_model]->save();
            }

            // save the model
            if ($modelIsSaved) {
                if ($this->_modelI18n !== null) {
                    $models[$this->_modelI18n]->{$this->linkModels} = $models[$this->_model]->id;
                    // save the i18n model
                    if (! $models[$this->_modelI18n]->save()) {
                        throw new Exception();
                    }
                }

                // commit
                $transaction->commit();

                // execute files operations
                if (! empty($modelName::$upload)) {
                    foreach ($modelName::$upload as $column => $data) {
                        $uploader = $this->getUploader(BHtml::resolveName($modelName, $column));
                        $uploader['uploader']->updateFile($models[$this->_model], $column, $data['pathDest']);
                    }
                }

                // update the status
                $isSaved = true;

                $this->_afterSaveEditModels($models);
            } else {
                throw new CException();
            }
        } catch (CException $e) {
            $models[$this->_model]->isNewRecord = $isNewRecord[$this->_model];

            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    $uploader = $this->getUploader(BHtml::resolveName($modelName, $column));
                    $uploader['uploader']->restoreAttribute($models[$this->_model], $column);
                }
            }

            // roll back
            if ($transaction->active) {
                $transaction->rollback();
            } else {
                throw $e;
            }
        }
        return $isSaved;
    }

    /**
     * This method is called when edit models are saved
     *
     * @param array $models the list of models
     */
    protected function _afterSaveEditModels(&$models)
    {}

    /**
     * Save the translations
     *
     * @param array $models the list of models to be translated
     * @param mixed $postData array of data (data to update)
     * @return bool true on success and false in the other cases
     * @throws Exception
     */
    protected function _saveTranslationModels(&$models, &$postData)
    {
        // status
        $isSaved = false;

        // begin a transaction
        $transaction = $models[Yii::app()->language]->dbConnection->beginTransaction();

        try {
            // validate models
            foreach ($models as $i18nId => $data) {
                if (isset($postData[$this->_modelI18n][$i18nId])) {
                    $models[$i18nId]->attributes = $postData[$this->_modelI18n][$i18nId];
                }
                $models[$i18nId]->validate();
            }

            // save models
            foreach ($models as $i18nId => $model) {
                if ($model->save()) {
                    $isSaved = true;
                } else {
                    $isSaved = false;
                    throw new Exception();
                }
            }

            // commit
            if ($isSaved) {
                $transaction->commit();
                $this->_afterSaveTranslationModels($models);
            }
        } catch (Exception $e) {
            // roll back
            if ($transaction->active) {
                $transaction->rollback();
            } else {
                throw $e;
            }
        }
        return $isSaved;
    }

    /**
     * This method is called when edit models are saved
     *
     * @param array $models the list of models
     */
    protected function _afterSaveTranslationModels(&$models)
    {}

    /**
     * Save settings
     *
     * @param mixed $models models to update
     * @param mixed $postData array of data (data to update)
     * @return bool true on success and false in the other cases
     * @throws Exception
     */
    protected function _saveSettingsModels(&$models, &$postData)
    {
        // initialize the status
        $isSaved = false;

        $transaction = $models['BInterfaceSetting']->dbConnection->beginTransaction();
        try {
            // set attributes
            if (isset($postData['BInterfaceSetting']))
                $models['BInterfaceSetting']->attributes = $postData['BInterfaceSetting'];

                // validate models
            $models['BInterfaceSetting']->validate();

            if ($models['BInterfaceSetting']->save()) {
                // commit changes
                $transaction->commit();
                // refresh cache
                $models['BInterfaceSetting']->refreshSettings($models['BInterfaceSetting']->interface_id, $models['BInterfaceSetting']->b_person_id);
                // update status
                $isSaved = true;
                $this->_afterSaveSettingsModels();
            } else
                throw new Exception();
        } catch (Exception $e) {
            // roll back
            if ($transaction->active)
                $transaction->rollback();
            else
                throw $e;
        }

        return $isSaved;
    }

    /**
     * This method is called when edit models are saved
     */
    protected function _afterSaveSettingsModels()
    {}

    /**
     * Load model of settings
     *
     * @return array Array of models
     */
    protected function _loadSettingsModels()
    {
        $models['BInterfaceSetting'] = BInterfaceSetting::model()->getSettings($this->id . ':' . $this->module->id, Yii::app()->user->id);
        if ($models['BInterfaceSetting']->interface_id === null && $models['BInterfaceSetting']->b_person_id === null) {
            $models['BInterfaceSetting']->setScenario('insert');
            $models['BInterfaceSetting']->interface_id = $this->id . ':' . $this->module->id;
            $models['BInterfaceSetting']->b_person_id = Yii::app()->user->id;
        } else
            $models['BInterfaceSetting']->setScenario('update');

        return $models;
    }
}