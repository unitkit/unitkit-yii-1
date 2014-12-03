<?php
class AlbumPhotoUploader extends BUploader
{
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
        	    $miniFile = $this->pathTmp . '/sm_' . $fileName;
        	    if (! file_exists($miniFile)) {
        	        $thumb = Yii::app()->phpThumb->create($this->pathTmp . '/' . $fileName);
        	        $thumb->resize(300, 300);
        	        $thumb->save($miniFile);
        	    }
        	    header('Content-Type: ' . CFileHelper::getMimeType($miniFile));
        	    echo file_get_contents($miniFile);
        	    break;
        }
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
        $pathOrigin = $path.'/origin';
        $pathSM = $path.'/sm';
        $pathLG = $path.'/lg';

        if (! file_exists($pathOrigin)) {
            mkdir($pathOrigin   , 0755, true);
        }
        if (! file_exists($pathSM)) {
            mkdir($pathSM, 0755, true);
        }
        if (! file_exists($pathLG)) {
            mkdir($pathLG, 0755, true);
        }

        switch ($model->uploadOperations[$attribute]['action']) {
        	case self::ACTION_INSERT:
        	    if (@rename($this->pathTmp.'/'. $model->uploadOperations[$attribute]['fromValue'], $pathOrigin . '/' . $model->uploadOperations[$attribute]['value'])) {
        	        @unlink($this->pathTmp.'/sm_'. $model->uploadOperations[$attribute]['fromValue']);

        	        $thumbSM = Yii::app()->phpThumb->create($pathOrigin.'/'. $model->uploadOperations[$attribute]['value']);
        	        $thumbSM->resize(300, 300);
        	        $thumbSM->save($pathSM.'/'.$model->uploadOperations[$attribute]['value']);

        	        $thumbLG = Yii::app()->phpThumb->create($pathOrigin.'/'.$model->uploadOperations[$attribute]['value']);
        	        $thumbLG->resize(800, 600);
        	        $thumbLG->save($pathLG.'/'.$model->uploadOperations[$attribute]['value']);

        	        if ($model->uploadOperations[$attribute]['oldValue'] != '') {
        	            @unlink($pathOrigin.'/'.$model->uploadOperations[$attribute]['oldValue']);
        	            @unlink($pathSM.'/'.$model->uploadOperations[$attribute]['oldValue']);
        	            @unlink($pathLG.'/'.$model->uploadOperations[$attribute]['oldValue']);
        	        }
        	        return true;
        	    }
        	    break;
        	case self::ACTION_DELETE:
        	    return @unlink($pathOrigin.'/'.$model->uploadOperations[$attribute]['value']) &&
        	       @unlink($pathSM.'/'.$model->uploadOperations[$attribute]['value']) &&
        	       @unlink($pathLG.'/'.$model->uploadOperations[$attribute]['value']);
        	    break;
        	default:
                return @rename($pathOrigin.'/'.$model->uploadOperations[$attribute]['oldValue'], $pathOrigin.'/'.$model->uploadOperations[$attribute]['value']) &&
                    @rename($pathSM.'/'.$model->uploadOperations[$attribute]['oldValue'], $pathSM.'/'.$model->uploadOperations[$attribute]['value']) &&
                    @rename($pathLG.'/'.$model->uploadOperations[$attribute]['oldValue'], $pathLG.'/'.$model->uploadOperations[$attribute]['value']);
        	    break;
        }
        return false;
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
        	        $html .= BHtml::image($uploadVar[$attribute]['urlDest'] . '/sm/' . $model->$attribute, '', $overviewOptions['html_options']);
        	    }
        	    break;
        	default:
        	    $html .= '';
        }
        $html .= '</div>';

        return $html;
    }
}