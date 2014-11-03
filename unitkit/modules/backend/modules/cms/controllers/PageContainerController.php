<?php

/**
 * Controller of page container
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerController extends BAutoController
{
    protected $_model = 'BCmsPage';
    protected $_modelI18n = 'BCmsPageI18n';

    /**
     * (non-PHPdoc)
     *
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
     * (non-PHPdoc)
     *
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedConbobox()
    {
        return array(
            'BCmsLayoutI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsLayoutI18n',
                'select' => array(
                    'id' => 'b_cms_layout_id',
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
            'BCmsWidget[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsWidgetI18n',
                'select' => array(
                    'id' => 'b_cms_widget_id',
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
            $layout = BCmsLayout::model()->findByPk($_GET['layout_id'], array('select' => 'max_container'));

            if($layout !== null) {
                $pageId = null;
                if (isset($_GET['pageId'])) {
                    $pageId = $_GET['pageId'];
                }
                $datas = $this->_loadCmsPageContentModels($pageId, $layout->max_container);
                echo CJSON::encode(array(
                    'html' => $this->bRenderPartial(
                        'edit/_containerTable',
                        array('dataView' => new PageContainerEditContainersArrayDataView($datas)),
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
            'html' => '<div class="alert alert-danger" role="alert">'.B::t('backend', 'cache_refresh_error').'</div>'
        );

        if (Yii::app()->request->isPostRequest) {
            BCmsPageFilter::removePrefix();
            $return['success'] = true;
            $return['html'] = '<div class="alert alert-success" role="alert">'.B::t('backend', 'cache_refresh_success').'</div>';
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    public function actionRefreshPageCache()
    {
        $return = array(
            'success' => false,
            'html' => '<span class="label label-danger">'.B::t('backend', 'cache_refresh_error').'</span>'
        );

        if (Yii::app()->request->isPostRequest && isset($_POST['page_slug'])) {
            BCmsPageFilter::removePrefixPage($_POST['page_slug']);
            $return['success'] = true;
            $return['html'] = '<span class="label label-success">'.B::t('backend', 'cache_refresh_success').'</span>';
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    protected function _loadCmsPageContentModels($pageId, $maxContainer)
    {
        $pageContents = array();
        if ($pageId !== null) {
            $pageContents = BCmsPageContent::model()
                    ->with('bCmsPageContentI18n')
                    ->findAllByAttributes(array('b_cms_page_id' => $pageId));
        }

        $models = array();
        $models['BCmsPageContents'] = array();
        foreach($pageContents as $pageContent) {
            $models['BCmsPageContents'][$pageContent->index] = $pageContent;
            $models['BCmsPageContents'][$pageContent->index]->setScenario('update');
        }

        for($i = 1; $i <= $maxContainer; ++$i) {
            if( ! isset($models['BCmsPageContents'][$i])) {
                $models['BCmsPageContents'][$i] = new BCmsPageContent('insert');
                $models['BCmsPageContents'][$i]->b_cms_page_id = $pageId;
                $models['BCmsPageContents'][$i]->index = $i;
            }
            if( empty($models['BCmsPageContents'][$i]->bCmsPageContentI18n)) {
                $models['BCmsPageContents'][$i]->bCmsPageContentI18n = new bCmsPageContentI18n('preInsert');
                $models['BCmsPageContents'][$i]->bCmsPageContentI18n->i18n_id = Yii::app()->language;
            }
        }


        foreach($models['BCmsPageContents'] as $i => &$BCmsPageContent)
        {
            if($i < 1 || $i > $maxContainer) {
                $models['BCmsPageContents'][$i]->delete();
                unset($models['BCmsPageContents'][$i]);
            }
        }

        ksort($models['BCmsPageContents']);

        return $models;
    }

    /**
     * Load models
     *
     * @param mixed $pk the primary key of the model
     * @return mixed array of models
     */
    protected function _loadEditModels($pk = null)
    {
        // current model
        $model = $this->_model;
        $pkId = $model::model()->tableSchema->primaryKey;

        // array of models
        $models = array();

        $models[$this->_model] = ($pk !== null) ? $model::model()->with('bCmsLayout')->findByPk(count($pk) == 1 ? reset($pk) : $pk) : null;
        if ($models[$this->_model] === null) {
            if ($pk !== null) {
                throw new CHttpException(403);
            }
            $models[$this->_model] = new $this->_model('insert');
        } else {
            $models = array_merge($models, $this->_loadCmsPageContentModels($models[$this->_model]->id, $models[$this->_model]->bCmsLayout->max_container));
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
     * @param mixed $postDatas array of datas (datas to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveEditModels(&$models, &$postDatas)
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

            $cmsLayoutId = $models[$this->_model]->b_cms_layout_id;

            // set attributes
            if (isset($postDatas[$this->_model])) {
                $models[$this->_model]->attributes = $postDatas[$this->_model];
            }
            if (isset($postDatas[$this->_modelI18n])) {
                $models[$this->_modelI18n]->attributes = $postDatas[$this->_modelI18n];
                $models[$this->_modelI18n]->i18n_id = Yii::app()->language;
            }

            if (isset($postDatas['BCmsPageContentsI18n'])) {
                if ($cmsLayoutId != $models[$this->_model]->b_cms_layout_id) {
                    $layout = BCmsLayout::model()->findByPk(
                        $models[$this->_model]->b_cms_layout_id,
                        array('select' => 'max_container')
                    );
                    if ($layout !== null) {
                        $models = array_merge($models, $this->_loadCmsPageContentModels(null, $layout->max_container));
                    }
                }

                foreach($models['BCmsPageContents'] as $i => &$BCmsPageContent) {
                    if (isset($postDatas['BCmsPageContentsI18n'][$i])) {
                        $BCmsPageContent->bCmsPageContentI18n->content = $postDatas['BCmsPageContentsI18n'][$i]['content'];
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
            $validModel['BCmsPageContents'] = null;

            // validate attributes
            if ($this->_modelI18n !== null) {
                $validModel[$this->_modelI18n] = $models[$this->_modelI18n]->validate();
            }
            $validModel[$this->_model] = $models[$this->_model]->validate();

            if (isset($models['BCmsPageContents'])) {
                foreach($models['BCmsPageContents'] as $i => &$BCmsPageContent) {
                    if (! $BCmsPageContent->bCmsPageContentI18n->validate()) {
                        $validModel['BCmsPageContents'] = false;
                    } elseif($BCmsPageContent->bCmsPageContentI18n->scenario == 'preInsert') {
                        $BCmsPageContent->bCmsPageContentI18n->scenario = 'insert';
                    }
                }
            }


            // save the model
            if ($validModel[$this->_model] && $models[$this->_model]->save(false) && (! isset($models['BCmsPageContents']) || $validModel['BCmsPageContents'] === null) &&
                ($this->_modelI18n === null || $validModel[$this->_modelI18n])) {

                if ($this->_modelI18n !== null) {
                    $models[$this->_modelI18n]->{$this->linkModels} = $models[$this->_model]->id;

                    // save the i18n model
                    if (! $models[$this->_modelI18n]->save()) {
                        throw new Exception();
                    }
                }

                if (isset($models['BCmsPageContents'])) {
                    foreach($models['BCmsPageContents'] as $i => &$BCmsPageContent) {
                        $BCmsPageContent->b_cms_page_id = $models[$this->_model]->id;
                        if ($BCmsPageContent->save()) {
                            $BCmsPageContent->bCmsPageContentI18n->b_cms_page_content_id = $BCmsPageContent->id;
                            if (! $BCmsPageContent->bCmsPageContentI18n->save()) {
                                throw new Exception();
                            }
                        } else {
                            throw new Exception();
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
                throw new Exception();
            }

        } catch (Exception $e) {
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
     * (non-PHPdoc)
     *
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        BCmsPageFilter::removePrefixPage($models[$this->_modelI18n]->slug);
    }

    /**
     * Save the translations
     *
     * @param array $models the list of models to be translated
     * @param mixed $postDatas array of datas (datas to update)
     * @return bool true on success and false in the other cases
     */
    protected function _saveTranslationModels(&$models, &$postDatas)
    {
        // status
        $isSaved = false;

        // begin a transaction
        $transaction = $models[Yii::app()->language][$this->_modelI18n]->dbConnection->beginTransaction();

        try {
            // validate models
            foreach ($models as $i18nId => $data) {
                if (isset($postDatas[$this->_modelI18n][$i18nId])) {
                    $models[$i18nId][$this->_modelI18n]->attributes = $postDatas[$this->_modelI18n][$i18nId];
                }
                $models[$i18nId][$this->_modelI18n]->validate();

                if (isset($postDatas['BCmsPageContentI18n'][$i18nId])) {
                    foreach($postDatas['BCmsPageContentI18n'][$i18nId] as $index => $attributes) {
                        $models[$i18nId]['BCmsPageContentI18ns'][$index]->attributes = $attributes;
                        $models[$i18nId]['BCmsPageContentI18ns'][$index]->validate();
                    }
                }
            }

            // save models
            foreach ($models as $i18nId => $data) {
                if ($data[$this->_modelI18n]->save()) {
                    $isSaved = true;
                } else {
                    $isSaved = false;
                    throw new Exception();
                }
                if (isset($models[$i18nId]['BCmsPageContentI18ns'])) {
                    foreach($models[$i18nId]['BCmsPageContentI18ns'] as $bCmsPageContentI18n) {
                        if($bCmsPageContentI18n->save()) {
                            $isSaved = true;
                        } else {
                            $isSaved = false;
                            throw new Exception();
                        }
                    }
                }
            }

            // commit
            if ($isSaved) {
                $transaction->commit();
                $this->_afterSaveTranslationModels();
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
            $models[$d->i18n_id][$this->_modelI18n] = $d;
        }

        $bCmsPageContents = array();
        foreach (BCmsPageContent::model()
            ->with('bCmsPageContentI18ns')
            ->findAllByAttributes(array(
                'b_cms_page_id' => $pk['id']
        )) as $d) {
            $bCmsPageContents[$d->id] = $d->index;
            foreach($d->bCmsPageContentI18ns as $bCmsPageContentI18n) {
                $models[$bCmsPageContentI18n->i18n_id]['BCmsPageContentI18ns'][$d->index] = $bCmsPageContentI18n;
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

            if (isset($models[$i18nId]['BCmsPageContentI18ns'])) {
                foreach ($models[$i18nId]['BCmsPageContentI18ns'] as &$BCmsPageContentI18n) {
                    $BCmsPageContentI18n->setScenario('update');
                }
            }

            foreach ($bCmsPageContents as $bCmsPageContentId => $index) {
                if ( ! isset($models[$i18nId]['BCmsPageContentI18ns'][$index])) {
                    $models[$i18nId]['BCmsPageContentI18ns'][$index] = new BCmsPageContentI18n('preInsert');
                    $models[$i18nId]['BCmsPageContentI18ns'][$index]->b_cms_page_content_id = $bCmsPageContentId;
                    $models[$i18nId]['BCmsPageContentI18ns'][$index]->i18n_id = $i18nId;
                }
            }
        }

        return $models;
    }
}