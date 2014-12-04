<?php

/**
 * Controller of page container
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerController extends UAutoController
{
    protected $_model = 'UCmsPage';
    protected $_modelI18n = 'UCmsPageI18n';

    /**
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('list', 'advCombobox', 'settings', 'export'),
                'roles' => $this->defaultRoles['consult']
            ),
            array(
                'allow',
                'actions' => array('create', 'advCombobox', 'upload', 'listContainer',
                    'refreshAllPagesCache', 'refreshPageCache'),
                'roles' => $this->defaultRoles['create']
            ),
            array(
                'allow',
                'actions' => array('update', 'translate', 'editRow', 'advCombobox', 'refreshRow', 'upload', 'listContainer',
                    'refreshAllPagesCache', 'refreshPageCache'),
                'roles' => $this->defaultRoles['update']
            ),
            array(
                'allow',
                'actions' => array('deleteRows'),
                'roles' => $this->defaultRoles['delete']
            ),
            array('deny')
        );
    }

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UCmsLayoutI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UCmsLayoutI18n',
                'select' => array(
                    'id' => 'u_cms_layout_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                  'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                  'order' => 'name ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            ),
            'BCmsContainerType[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsContainerTypeI18n',
                'select' => array(
                    'id' => 'b_cms_container_type_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                    'order' => 'name ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            ),
            'BCmsEdito[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsEditoI18n',
                'select' => array(
                    'id' => 'b_cms_edito_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                    'order' => 'name ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            ),
            'UCmsWidget[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UCmsWidgetI18n',
                'select' => array(
                    'id' => 'u_cms_widget_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                    'order' => 'name ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            )
        );
    }

    public function actionListContainer()
    {
        if (isset($_GET['layout_id'])) {
            $layout = UCmsLayout::model()->findByPk($_GET['layout_id'], array('select' => 'max_container'));

            if($layout !== null) {
                $pageId = null;
                if (isset($_GET['pageId'])) {
                    $pageId = $_GET['pageId'];
                }
                $data = $this->_loadCmsPageContentModels($pageId, $layout->max_container);
                echo CJSON::encode(array(
                    'html' => $this->bRenderPartial(
                        'edit/_containerTable',
                        array('dataView' => new PageContainerEditContainersArrayDataView($data)),
                        true
                    )
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionRefreshAllPagesCache()
    {
        $return = array(
            'success' => false,
            'html' => '<div class="alert alert-danger" role="alert">'.Unitkit::t('backend', 'cache_refresh_error').'</div>'
        );

        if (Yii::app()->request->isPostRequest) {
            UCmsPageFilter::removePrefix();
            $return['success'] = true;
            $return['html'] = '<div class="alert alert-success" role="alert">'.Unitkit::t('backend', 'cache_refresh_success').'</div>';
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    public function actionRefreshPageCache()
    {
        $return = array(
            'success' => false,
            'html' => '<span class="label label-danger">'.Unitkit::t('backend', 'cache_refresh_error').'</span>'
        );

        if (Yii::app()->request->isPostRequest && isset($_POST['page_slug'])) {
            UCmsPageFilter::removePrefixPage($_POST['page_slug']);
            $return['success'] = true;
            $return['html'] = '<span class="label label-success">'.Unitkit::t('backend', 'cache_refresh_success').'</span>';
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    protected function _loadCmsPageContentModels($pageId, $maxContainer)
    {
        $pageContents = array();
        if ($pageId !== null) {
            $pageContents = UCmsPageContent::model()
                    ->with('uCmsPageContentI18n')
                    ->findAllByAttributes(array('u_cms_page_id' => $pageId));
        }

        $models = array();
        $models['UCmsPageContents'] = array();
        foreach($pageContents as $pageContent) {
            $models['UCmsPageContents'][$pageContent->index] = $pageContent;
            $models['UCmsPageContents'][$pageContent->index]->setScenario('update');
        }

        for($i = 1; $i <= $maxContainer; ++$i) {
            if( ! isset($models['UCmsPageContents'][$i])) {
                $models['UCmsPageContents'][$i] = new UCmsPageContent('insert');
                $models['UCmsPageContents'][$i]->u_cms_page_id = $pageId;
                $models['UCmsPageContents'][$i]->index = $i;
            }
            if( empty($models['UCmsPageContents'][$i]->uCmsPageContentI18n)) {
                $models['UCmsPageContents'][$i]->uCmsPageContentI18n = new uCmsPageContentI18n('preInsert');
                $models['UCmsPageContents'][$i]->uCmsPageContentI18n->i18n_id = Yii::app()->language;
            }
        }

        foreach($models['UCmsPageContents'] as $i => &$UCmsPageContent) {
            if($i < 1 || $i > $maxContainer) {
                $models['UCmsPageContents'][$i]->delete();
                unset($models['UCmsPageContents'][$i]);
            }
        }

        ksort($models['UCmsPageContents']);

        return $models;
    }

    /**
     * Load models
     *
     * @param mixed $pk the primary key of the model
     * @return mixed array of models
     * @throws CHttpException
     */
    protected function _loadEditModels($pk = null)
    {
        // current model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // array of models
        $models = array();

        $models[$this->_model] = ($pk !== null) ? $model::model()->with('uCmsLayout')->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models[$this->_model] === null) {
            if ($pk !== null) {
                throw new CHttpException(403);
            }
            $models[$this->_model] = new $this->_model('insert');
        } else {
            $models = array_merge($models, $this->_loadCmsPageContentModels($models[$this->_model]->id, $models[$this->_model]->uCmsLayout->max_container));
            $models[$this->_model]->setScenario('update');
        }

        if ($this->_modelI18n !== null) {
            // model I18n
            $modelI18n = $this->_modelI18n;

            $models[$this->_modelI18n] = ($pk !== null) ? $modelI18n::model()->findByPk(array(
                $this->linkModels => $pk[$pkId],
                'i18n_id' => Yii::app()->language
            )) : null;
            if ($models[$this->_modelI18n] === null)
                $models[$this->_modelI18n] = new $this->_modelI18n('preInsert');
            else
                $models[$this->_modelI18n]->setScenario('update');
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

            $cmsLayoutId = $models[$this->_model]->u_cms_layout_id;

            // set attributes
            if (isset($postData[$this->_model])) {
                $models[$this->_model]->attributes = $postData[$this->_model];
            }
            if (isset($postData[$this->_modelI18n])) {
                $models[$this->_modelI18n]->attributes = $postData[$this->_modelI18n];
                $models[$this->_modelI18n]->i18n_id = Yii::app()->language;
            }

            if (isset($postData['UCmsPageContentsI18n'])) {
                if ($cmsLayoutId != $models[$this->_model]->u_cms_layout_id) {
                    $layout = UCmsLayout::model()->findByPk(
                        $models[$this->_model]->u_cms_layout_id,
                        array('select' => 'max_container')
                    );
                    if ($layout !== null) {
                        $models = array_merge($models, $this->_loadCmsPageContentModels($models[$this->_model]->id, $layout->max_container));
                    }
                }

                foreach($models['UCmsPageContents'] as $i => &$UCmsPageContent) {
                    if (isset($postData['UCmsPageContentsI18n'][$i])) {
                        $UCmsPageContent->uCmsPageContentI18n->content = $postData['UCmsPageContentsI18n'][$i]['content'];
                    }
                }
            }

            // set files attributes and fetch array of operations
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    Yii::app()->uploader->setAttribute($models[$this->_model], $column, $oldFilesPath[$this->_model][$column]);
                }
            }

            $validModel[$this->_modelI18n] = false;
            $validModel[$this->_model] = false;
            $validModel['UCmsPageContents'] = null;

            // validate attributes
            if ($this->_modelI18n !== null) {
                $validModel[$this->_modelI18n] = $models[$this->_modelI18n]->validate();
            }
            $validModel[$this->_model] = $models[$this->_model]->validate();


            if (isset($models['UCmsPageContents'])) {
                foreach($models['UCmsPageContents'] as $i => &$UCmsPageContent) {
                    if (! $UCmsPageContent->uCmsPageContentI18n->validate()) {
                        $validModel['UCmsPageContents'] = false;
                    } elseif($UCmsPageContent->uCmsPageContentI18n->scenario == 'preInsert') {
                        $UCmsPageContent->uCmsPageContentI18n->scenario = 'insert';
                    }
                }
            }

            // save the model
            if ($validModel[$this->_model] && $models[$this->_model]->save(false) && (! isset($models['UCmsPageContents']) || $validModel['UCmsPageContents'] === null) &&
                ($this->_modelI18n === null || $validModel[$this->_modelI18n])) {

                if ($this->_modelI18n !== null) {
                    $models[$this->_modelI18n]->{$this->linkModels} = $models[$this->_model]->id;

                    // save the i18n model
                    if (! $models[$this->_modelI18n]->save()) {
                        throw new CException();
                    }
                }

                if (isset($models['UCmsPageContents'])) {
                    foreach($models['UCmsPageContents'] as $i => &$UCmsPageContent) {
                        $UCmsPageContent->u_cms_page_id = $models[$this->_model]->id;
                        if ($UCmsPageContent->save()) {
                            $UCmsPageContent->uCmsPageContentI18n->u_cms_page_content_id = $UCmsPageContent->id;
                            if (! $UCmsPageContent->uCmsPageContentI18n->save()) {
                                throw new CException();
                            }
                        } else {
                            throw new CException();
                        }
                    }
                }
                // commit
                $transaction->commit();

                // execute files operations
                if (! empty($modelName::$upload)) {
                    foreach ($modelName::$upload as $column => $data) {
                        Yii::app()->uploader->updateFile($models[$this->_model], $column, $data['pathDest']);
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
                    Yii::app()->uploader->restoreAttribute($models[$this->_model], $column);
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
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        UCmsPageFilter::removePrefixPage($models[$this->_modelI18n]->slug);
        Yii::app()->urlManager->clearAllCache();
    }

    /**
     * @see BBaseAutoController::_afterSaveTranslationModels()
     */
    protected function _afterSaveTranslationModels(&$models)
    {
        foreach($models as $model) {
            UCmsPageFilter::removePrefixPage($model[$this->_modelI18n]->slug);
        }
        Yii::app()->urlManager->clearAllCache();
    }

    /**
     * Save the translations
     *
     * @param array $models the list of models to be translated
     * @param mixed $postData array of data (data to update)
     * @return bool true on success and false in the other cases
     * @throws CException
     */
    protected function _saveTranslationModels(&$models, &$postData)
    {
        // status
        $isSaved = false;

        // begin a transaction
        $transaction = $models[Yii::app()->language][$this->_modelI18n]->dbConnection->beginTransaction();

        try {
            // validate models
            foreach ($models as $i18nId => $data) {
                if (isset($postData[$this->_modelI18n][$i18nId])) {
                    $models[$i18nId][$this->_modelI18n]->attributes = $postData[$this->_modelI18n][$i18nId];
                }
                $models[$i18nId][$this->_modelI18n]->validate();

                if (isset($postData['UCmsPageContentI18n'][$i18nId])) {
                    foreach($postData['UCmsPageContentI18n'][$i18nId] as $index => $attributes) {
                        $models[$i18nId]['UCmsPageContentI18ns'][$index]->attributes = $attributes;
                        $models[$i18nId]['UCmsPageContentI18ns'][$index]->validate();
                    }
                }
            }

            // save models
            foreach ($models as $i18nId => $data) {
                if ($data[$this->_modelI18n]->save()) {
                    $isSaved = true;
                } else {
                    $isSaved = false;
                    throw new CException();
                }
                if (isset($models[$i18nId]['UCmsPageContentI18ns'])) {
                    foreach($models[$i18nId]['UCmsPageContentI18ns'] as $uCmsPageContentI18n) {
                        if($uCmsPageContentI18n->save()) {
                            $isSaved = true;
                        } else {
                            $isSaved = false;
                            throw new CException();
                        }
                    }
                }
            }

            // commit
            if ($isSaved) {
                $transaction->commit();
                $this->_afterSaveTranslationModels($models);
            }
        } catch (CException $e) {
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

        // current model
        $modelI18n = $this->_modelI18n;

        // array of models
        $models = array();

        foreach ($modelI18n::model()->findAllByAttributes(array(
            $this->linkModels => $pk[$pkId]
        )) as $d) {
            $models[$d->i18n_id][$this->_modelI18n] = $d;
        }

        $uCmsPageContents = array();
        foreach (UCmsPageContent::model()
            ->with('uCmsPageContentI18ns')
            ->findAllByAttributes(array(
                'u_cms_page_id' => $pk['id']
        )) as $d) {
            $uCmsPageContents[$d->id] = $d->index;
            foreach($d->uCmsPageContentI18ns as $uCmsPageContentI18n) {
                $models[$uCmsPageContentI18n->i18n_id]['UCmsPageContentI18ns'][$d->index] = $uCmsPageContentI18n;
            }
        }

        foreach ($i18nIds as $i18nId) {
            if (! isset($models[$i18nId])) {
                $models[$i18nId] = array();
                $models[$i18nId][$this->_modelI18n] = new $modelI18n('insert');
                $models[$i18nId][$this->_modelI18n]->i18n_id = $i18nId;
                $models[$i18nId][$this->_modelI18n]->{$this->linkModels} = $pk[$pkId];
            } else {
                $models[$i18nId][$this->_modelI18n]->setScenario('update');
            }

            if (isset($models[$i18nId]['UCmsPageContentI18ns'])) {
                foreach ($models[$i18nId]['UCmsPageContentI18ns'] as &$UCmsPageContentI18n) {
                    $UCmsPageContentI18n->setScenario('update');
                }
            }

            foreach ($uCmsPageContents as $uCmsPageContentId => $index) {
                if ( ! isset($models[$i18nId]['UCmsPageContentI18ns'][$index])) {
                    $models[$i18nId]['UCmsPageContentI18ns'][$index] = new UCmsPageContentI18n('preInsert');
                    $models[$i18nId]['UCmsPageContentI18ns'][$index]->u_cms_page_content_id = $uCmsPageContentId;
                    $models[$i18nId]['UCmsPageContentI18ns'][$index]->i18n_id = $i18nId;
                }
            }
        }

        return $models;
    }
}