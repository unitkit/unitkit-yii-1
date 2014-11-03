<?php

/**
 * Controller of image
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageController extends BAutoController
{
    protected $_model = 'BCmsImage';
    protected $_modelI18n = 'BCmsImageI18n';

    public function init()
    {
        parent::init();

        if (isset($_GET['CKEditorFuncNum'])) {
            $this->layout = '//../modules/backend/views/layouts/simpleHeaderTitle';
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see BBaseAutoController::uploader()
     */
    protected function _uploader()
    {
        return array(
            'BCmsImage[file_path]' => array(
                'model' => 'BCmsImage',
                'field' => 'file_path',
                'uploader' => Yii::app()->getModule('backend')->getModule('cms')->albumPhotoUploader
            ),
        );
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
            if (isset($postDatas[$this->_model])) {
                $models[$this->_model]->attributes = $postDatas[$this->_model];
            }

            $oldModels[$this->_modelI18n] = clone $models[$this->_modelI18n];
            if (isset($postDatas[$this->_modelI18n])) {
                $models[$this->_modelI18n]->attributes = $postDatas[$this->_modelI18n];
                $models[$this->_modelI18n]->i18n_id = Yii::app()->language;
            }
            // set files attributes and fetch array of operations
            if (! empty($modelName::$upload)) {
                foreach ($modelName::$upload as $column => $data) {
                    $uploader = $this->getUploader(BHtml::resolveName($modelName, $column));
                    $uploader['uploader']->setAttribute($models[$this->_model], $column, $oldFilesPath[$this->_model][$column]);
                }
                if (isset($models[$this->_model]->uploadOperations['file_path']['postModelAttribute'])) {
                    if (isset($models[$this->_model]->uploadOperations['file_path']['value']) ||
                        $oldModels[$this->_modelI18n]->title !== $models[$this->_modelI18n]->title) {
                        $extension = isset($models[$this->_model]->uploadOperations['file_path']['extension'])
                            ? $models[$this->_model]->uploadOperations['file_path']['extension']
                            : pathinfo($models[$this->_model]->uploadOperations['file_path']['postModelAttribute'])['extension'];

                        $models[$this->_model]->uploadOperations['file_path']['value'] = BHtml::slugify($models[$this->_modelI18n]->title) .
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
                        $uploader = $this->getUploader(BHtml::resolveName($modelName, $column));
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