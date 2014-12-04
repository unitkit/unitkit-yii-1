<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoController extends UAutoController
{
    protected $_model = 'UCmsAlbumPhoto';
    protected $_modelI18n = 'UCmsAlbumPhotoI18n';

    /**
     * @see CController::filters()
     */
    public function filters()
    {
        $filters = parent::filters();
        $filters[] = 'album - upload';
        return $filters;
    }

    public function filterAlbum($filterChain)
    {
        if (empty($_GET['album'])) {
            throw new CHttpException(404);
        } else {
            $model = UCmsAlbum::model()->findByPk($_GET['album'], array('select' => '1'));
            if($model === null) {
                throw new CHttpException(404);
            } else {
                $filterChain->run();
            }
        }
    }

    /**
     * @see BBaseAutoController::uploader()
     */
    protected function _uploader()
    {
        return array(
            'UCmsAlbumPhoto[file_path]' => array(
                'model' => 'UCmsAlbumPhoto',
                'field' => 'file_path',
                'uploader' => Yii::app()->getModule('backend')->getModule('cms')->albumPhotoUploader
            ),
        );
    }

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UCmsAlbumI18n[title]' => array(
                'search' => $_GET['search'],
                'model' => 'UCmsAlbumI18n',
                'select' => array(
                    'id' => 'u_cms_album_id',
                    'text' => 'title'
                ),
                'criteria' => array(
                  'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                  'order' => 'title ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            ),
        );
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
        $model->u_cms_album_id = $_GET['album'];

        // search
        $dataProvider = $model->search(Yii::app()->language);
        // sort
        $sort = $dataProvider->getSort();
        // route
        $sort->route = $this->id . '/list';

        // pagination parameters
        $pagination = $dataProvider->getPagination();
        $pagination->route = $this->id . '/list';
        $pagination->pageSize = UInterfaceSetting::model()->getSettings($this->id . ':' . $this->module->id, Yii::app()->user->id)->page_size;
        $pagination->itemCount = $dataProvider->totalItemCount;

        // datas
        $datas = $dataProvider->getData();

        // related datas
        $relatedDatas = $this->_loadRelatedData();

        // template
        $template = isset($_REQUEST['partial']) ? 'list/_table' : 'list/main';

        $jsonParams = array();
        if (Yii::app()->request->isAjaxRequest) {
            // filters
            $filtersDatas = array();
            if (isset($_GET[$this->_model])) {
                $filtersDatas[$this->_model] = $_GET[$this->_model];
            }
            if (isset($_GET[$sort->sortVar])) {
                $filtersDatas[$sort->sortVar] = $_GET[$sort->sortVar];
            }

            $jsonParams = array(
                'filters' => http_build_query($filtersDatas)
            );
        }

        $this->dynamicRender(
            $template,
            array(
                'dataView' => new $this->crudComponents['listDataView'](
                    $datas, $relatedDatas, $model, $sort, $pagination, $this
                )
            ),
            $jsonParams
        );
    }

    /**
     * Load related datas used in data view
     *
     * @return array
     */
    protected function _loadRelatedData()
    {
        return array(
            'UCmsAlbumI18n' => UCmsAlbumI18n::model()->findByPk(array(
                'u_cms_album_id' => $_GET['album'], 'i18n_id' => Yii::app()->language
            ))
        );
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

            if($models[$this->_model]->scenario === 'insert') {
                $models[$this->_model]->u_cms_album_id = $_GET['album'];
            }

            // set attributes
            if (isset($postData[$this->_model])) {
                $models[$this->_model]->attributes = $postData[$this->_model];
            }

            $oldModels[$this->_modelI18n] = clone $models[$this->_modelI18n];
            if (isset($postData[$this->_modelI18n])) {
                $models[$this->_modelI18n]->attributes = $postData[$this->_modelI18n];
                $models[$this->_modelI18n]->i18n_id = Yii::app()->language;
            }
            // set files attributes and fetch array of operations
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    $uploader = $this->getUploader(UHtml::resolveName($modelName, $column));
                    $uploader['uploader']->setAttribute($models[$this->_model], $column, $oldFilesPath[$this->_model][$column]);
                }
                if (isset($models[$this->_model]->uploadOperations['file_path']['postModelAttribute'])) {
                    if (isset($models[$this->_model]->uploadOperations['file_path']['value']) ||
                        $oldModels[$this->_modelI18n]->title !== $models[$this->_modelI18n]->title) {
                        $extension = isset($models[$this->_model]->uploadOperations['file_path']['extension'])
                            ? $models[$this->_model]->uploadOperations['file_path']['extension']
                            : pathinfo($models[$this->_model]->uploadOperations['file_path']['postModelAttribute'])['extension'];

                        $models[$this->_model]->uploadOperations['file_path']['value'] = UHtml::slugify($models[$this->_modelI18n]->title) .
                            '_'.uniqid() . '.' . $extension;
                        $models[$this->_model]->file_path = $models[$this->_model]->uploadOperations['file_path']['value'];
                    }
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
                        $uploader = $this->getUploader(UHtml::resolveName($modelName, $column));
                        $uploader['uploader']->updateFile($models[$this->_model], $column, $data['pathDest']);
                    }
                }

                // update the status
                $isSaved = true;

                $this->_afterSaveEditModels($models);
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    Yii::app()->uploader->restoreAttribute($models[$this->_model], $column);
                }
            }

            // roll back
            if ($transaction->active)
                $transaction->rollback();
            else
                throw $e;
        }
        return $isSaved;
    }
}