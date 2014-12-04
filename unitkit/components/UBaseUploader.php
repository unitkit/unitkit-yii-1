<?php

/**
 * This class is used to create an uploader component
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseUploader extends CComponent
{
    const PREFIX_KEY_CACHE = 'buploader:';

    // overview mode
    const OVERVIEW_IMAGE = 1;

    /**
     * Insert action
     */
    const ACTION_INSERT = 'insert';

    /**
     * Delete action
     */
    const ACTION_DELETE = 'delete';

    /**
     * Temporary directory
     *
     * @var string
     */
    public $pathTmp;

    public function init()
    {}

    /**
     * Get the size of the attribute
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @return string
     */
    public function getDataSize(&$model, $attribute)
    {
        return $model::$upload[$attribute]['max'] . ' B';
    }

    /**
     * Get the legend of the attribute
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @return string
     */
    public function getLegend(&$model, $attribute)
    {
        return Unitkit::t('unitkit', 'uploader_max_size') . ': ' .
            round($model::$upload[$attribute]['max'] / 1048576, 1) . ' MB | ' .
            implode(', ', $model::$upload[$attribute]['types']);
    }

    /**
     * Get the allowed types of attribute
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @return string
     */
    public function getDataTypes(&$model, $attribute)
    {
        $types = '';
        foreach ($model::$upload[$attribute]['types'] as $type) {
            $types .= '*.' . $type . '; ';
        }
        $types = substr($types, 0, - 2);

        return $types;
    }

    /**
     * Get the overview of the temporary file
     *
     * @param string $key upload key
     */
    public function loadTempOverview($key)
    {
        // get informations about upload
        $data = Yii::app()->cache->get(self::PREFIX_KEY_CACHE . $key);
        // control session ID
        if (false !== $data && $data['id'] === UTools::sha512(Yii::app()->session->sessionID)) {
            $this->loadTempOverviewSelector($data['overview']['type'], basename($data['file']));
        }
    }

    /**
     * Execute the overview method of the temporary file
     *
     * @param int $type
     * @param string $fileName
     */
    public function loadTempOverviewSelector($type, $fileName)
    {
        switch ($type) {
            case self::OVERVIEW_IMAGE:
                header('Content-Type: ' . CFileHelper::getMimeType($this->pathTmp . '/' . $fileName));
                echo file_get_contents($this->pathTmp . '/' . $fileName);
                break;
        }
    }

    /**
     * Save a temporary file
     *
     * @param string $modelName name of model
     * @param string $attributeName name of attribute
     * @param mixed $overview array('type' => , ..)
     * @param int $cache duration of temporary data
     * @return mixed
     */
    public function saveTmpFile($modelName, $attributeName, $overview = array(), $cache = 86400 /* 24h */)
    {
        $overview = array_merge(array(
            'type' => ''
        ), $overview);

        $model = new $modelName('upload');
        $model->$attributeName = CUploadedFile::getInstance($model, $attributeName);
        $model->validate(array(
            $attributeName
        ));

        // validate the format
        if ($model->validate(array($attributeName))) {
            // generate a key
            $tmpKey = UTools::sha256(uniqid(mt_rand(), true) . ':' . Yii::app()->session->sessionID);
            // generate a file name
            $nameFile = mb_strtolower(sha1(uniqid(mt_rand(), true)) . '.' . $model->$attributeName->getExtensionName(), 'UTF-8');
            // data
            $data = array(
                'file' => $nameFile,
                'id' => UTools::sha512(Yii::app()->session->sessionID),
                'overview' => $overview
            );

            // save the temporary datas
            if (Yii::app()->cache->set(self::PREFIX_KEY_CACHE . $tmpKey, $data, $cache)) {
                // save the temporary file
                $model->$attributeName->saveAs($this->pathTmp . '/' . $nameFile);
                // overview
                $html = $this->tmpFileOverviewSelector($tmpKey, $overview, $model, $attributeName);

                return array(
                    'key' => $tmpKey,
                    'name' => '',
                    'overview' => $html
                );
            }
        }

        return false;
    }

    /**
     * Generate overview of temporary file
     *
     * @param string $tmpKey temporary key
     * @param CModel $overview overview option
     * @param mixed $model instance of model
     * @param string $attribute name of attribute
     * @return string
     */
    public function tmpFileOverviewSelector($tmpKey, $overview, $model, $attribute)
    {
        $html = '';
        switch ($overview['type']) {
            case self::OVERVIEW_IMAGE:
                $url = Yii::app()->controller->createAbsoluteUrl($overview['route'], array(
                    'overview' => UHtml::activeName($model, $attribute),
                    'key' => $tmpKey
                ));
                $html = UHtml::image($url, '', $overview['html_options']);
                break;
        }

        return $html;
    }

    /**
     * Get the html of the overview
     *
     * @param CModel $model instance of model
     * @param string $attribute name of attribute
     * @param mixed $overviewOptions array of options array('type' => , 'route' => , 'html_options' => array())
     * @return string
     */
    public function htmlOverview(&$model, $attribute, $overviewOptions = array())
    {
        $overviewOptions = array_merge(array(
            'type' => '',
            'html_options' => array()
        ), $overviewOptions);

        $command = array();
        if ($model->$attribute != '') {
            $command = $this->_transformFileValue($model->$attribute);
        }

        $html = '<div class="upload-file-progress-overview">';
        switch ($overviewOptions['type']) {
            case self::OVERVIEW_IMAGE:
                if (! empty($command) && $command['action'] === self::ACTION_INSERT) {
                    $html .= $this->tmpFileOverviewSelector($command['key'], $overviewOptions, $model, $attribute);
                } else {
                    $uploadVar = $model::$upload;
                    $html .= UHtml::image($uploadVar[$attribute]['urlDest'] . '/' . $model->$attribute, '', $overviewOptions['html_options']);
                }
                break;
            default:
                $html .= '';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Transform file value to command
     * File value must be like "FILE_NAME?(insert,delete)"
     *
     * @param string $fileValue
     * @return array
     */
    protected function _transformFileValue($fileValue)
    {
        $command = array();

        // explode string "FILE_NAME?(insert,delete)"
        $dataOp = explode('?', $fileValue);
        if (count($dataOp) == 2) {
            $command['action'] = $dataOp[1];
            $command['key'] = $dataOp[0];
        }

        return $command;
    }

    /**
     * Get the html of the uploader component
     *
     * @param CModel $model instance of model
     * @param string $attribute name of attribute
     * @param string $uploaderUrl uploader url
     * @param mixed $overviewOptions array of options array('type' => , 'route' => , 'html_options' => array())
     * @return string
     */
    public function htmlUploader(&$model, $attribute, $uploaderUrl, $overviewOptions = array())
    {
        $overviewOptions = array_merge(array(
            'type' => '',
            'html_options' => array()
        ), $overviewOptions);

        $html = '
		<div class="upload-file">
			<a href="#" class="btn btn-default btn-upload" ' . 'data-model="' . UHtml::activeName($model, $attribute) . '" ' . 'data-action="' . $uploaderUrl . '" ' . 'data-size="' . $this->getDataSize($model, $attribute) . '" ' . 'data-type="' . $this->getDataTypes($model, $attribute) . '" ' . 'data-sessKey="' . Yii::app()->session['sess_key'] . '" ' . 'data-overview="' . htmlentities(json_encode($overviewOptions)) . '" ' . '>
				<span class="glyphicon glyphicon-upload"></span>
				<span>' . Unitkit::t('unitkit', 'btn_upload') . '</span>
			</a>
			<i class="label label-info">' . $this->getLegend($model, $attribute) . '</i>
			<div class="upload-file-flash-btn"></div>
			<div class="upload-file-progress-container">';

        if (! empty($model->$attribute)) {
            $hiddenValue = $model->$attribute;
            $command = ($hiddenValue != '') ? $this->_transformFileValue($hiddenValue) : array();

            if (! empty($command) && $command['action'] === self::ACTION_INSERT &&
                    isset($model->uploadOperations[$attribute]['postModelAttribute'])) {
                $oldModel = clone $model;
                $oldModel->$attribute = $model->uploadOperations[$attribute]['oldValue'];

                $html .= '
					<div class="upload-file-progress original" style="display:none;">
						<div class="upload-file-progress-details">
							<div class="upload-file-progress-details-action">
								<a href="#" class="remove"><span class="glyphicon glyphicon-trash"></span></a>
							</div>
							<div class="upload-file-progress-details-file"></div>
						</div>' .
						$this->htmlOverview($oldModel, $attribute, $overviewOptions) . UHtml::activeHiddenField($oldModel, $attribute, array(
                            'class' => 'upload-file-input',
                            'id' => false
                        )) . '
					</div>';
            }

            $cssClass = '';
            if (! empty($command) && $command['action'] === self::ACTION_INSERT &&
                    isset($model->uploadOperations[$attribute]['postModelAttribute'])) {
                $cssClass = 'insert';
            } else {
                $cssClass = 'original';
            }

            $html .= '
				<div class="upload-file-progress ' . $cssClass . '" style="' . (! empty($command) && $command['action'] === self::ACTION_DELETE ? 'display:none;' : '') . '">
					<div class="upload-file-progress-details">
						<div class="upload-file-progress-details-action">
							<a href="#" class="remove"><span class="glyphicon glyphicon-trash"></span></a>
						</div>
						<div class="upload-file-progress-details-file"></div>
					</div>
					' . $this->htmlOverview($model, $attribute, $overviewOptions) . UHtml::activeHiddenField($model, $attribute, array(
                'class' => 'upload-file-input',
                'id' => false,
                'value' => $hiddenValue
            )) . '
				</div>';
        }

        $html .= '
			</div>
		</div>';

        return $html;
    }

    /**
     * Update a file
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @param string $path
     * @return bool
     */
    public function updateFile(&$model, $attribute, $path)
    {
        if (! file_exists ($path)) {
            mkdir($path, 0755, true);
        }

        switch ($model->uploadOperations[$attribute]['action']) {
            case self::ACTION_INSERT:
                if (@rename($this->pathTmp . '/' . $model->uploadOperations[$attribute]['fromValue'], $path . '/' . $model->uploadOperations[$attribute]['value'])) {
                    if ($model->uploadOperations[$attribute]['oldValue'] != '') {
                        return @unlink($path . '/' . $model->uploadOperations[$attribute]['oldValue']);
                    }
                    return true;
                }
                break;
            case self::ACTION_DELETE:
                return @unlink($path . '/' . $model->uploadOperations[$attribute]['value']);
                break;
        }
        return false;
    }

    /**
     * Restore the attribute value
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     */
    public function restoreAttribute(&$model, $attribute)
    {
        switch ($model->uploadOperations[$attribute]['action']) {
            case self::ACTION_INSERT:
                $model->$attribute = $model->uploadOperations[$attribute]['postModelAttribute'];
                break;
            case self::ACTION_DELETE:
                $model->$attribute = $model->uploadOperations[$attribute]['value'] . '?' . self::ACTION_DELETE;
                break;
        }
    }

    /**
     * Update an attribute file in insert mode
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @param string $oldValue
     * @param array $command Command
     * @param string $modelValue Model value
     *
     * @throws Exception
     */
    protected function _setAttributeModeInsert(&$model, &$attribute, &$oldValue, &$command, &$modelValue)
    {
        // get temporary file informations
        $data = Yii::app()->cache->get(self::PREFIX_KEY_CACHE . $command['key']);
        // control session ID
        if (false !== $data && $data['id'] === UTools::sha512(Yii::app()->session->sessionID)) {
            // file to copy
            $fileToCopy = basename($data['file']);
            // get upload file informations
            $stat = stat($this->pathTmp . '/' . $fileToCopy);
            $info = pathinfo($fileToCopy);

            // validate size & extension
            if ($stat['size'] <= $model::$upload[$attribute]['max'] && isset($info['extension']) && in_array(mb_strtolower($info['extension']), $model::$upload[$attribute]['types'])) {
                $model->$attribute = $fileToCopy;
                $model->uploadOperations[$attribute] = array(
                    'action' => self::ACTION_INSERT,
                    'postModelAttribute' => $modelValue,
                    'oldValue' => $oldValue,
                    'fromValue' => $fileToCopy,
                    'value' => $fileToCopy,
                    'extension' => $info['extension'],
                );
            } else {
                throw new Exception();
            }
        }
    }

    /**
     * Update an attribute file in delete mode
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @param string $oldValue
     * @param array $command Command
     * @param string $modelValue Model value
     *
     * @throws Exception
     */
    protected function _setAttributeModeDelete(&$model, &$attribute, &$oldValue, &$command, &$modelValue)
    {
        $model->$attribute = '';
        $model->uploadOperations[$attribute] = array(
            'action' => self::ACTION_DELETE,
            'postModelAttribute' => $modelValue,
            'oldValue' => $oldValue,
            'value' => basename($command['key'])
        );
    }

    /**
     * Update an attribute file
     *
     * @param CModel $model instance of CModel
     * @param string $attribute name of attribute
     * @param string $oldValue
     * @return mixed array of operations
     */
    public function setAttribute(&$model, $attribute, $oldValue)
    {
        $modelValue = $model->$attribute;
        if ($modelValue != '') {
            $command = $this->_transformFileValue($modelValue);
            if (! empty($command)) {
                if ($command['action'] === self::ACTION_INSERT) { // insert file
                    $this->_setAttributeModeInsert($model, $attribute, $oldValue, $command, $modelValue);
                } elseif ($command['action']=== self::ACTION_DELETE && $oldValue === basename($command['key'])) { // delete file
                    $this->_setAttributeModeDelete($model, $attribute, $oldValue, $command, $modelValue);
                }
            } else {
                $model->uploadOperations[$attribute] = array(
                    'action' => '',
                    'postModelAttribute' => $modelValue,
                    'oldValue' => $oldValue
                );
            }
        } else {
            $model->$attribute = '';
            $model->uploadOperations[$attribute] = array(
                'action' => '',
                'postModelAttribute' => $modelValue,
                'oldValue' => $oldValue
            );
        }
    }
}