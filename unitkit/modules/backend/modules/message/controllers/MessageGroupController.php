<?php

/**
 * Controller of message group
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageGroupController extends UAutoController
{
    protected $_model = 'UMessageGroup';
    protected $_modelI18n = 'UMessageGroupI18n';

    /**
     * @see BBaseAutoController::afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        // refresh cache
        Yii::app()->messages->refreshCache();
    }

    /**
     * @see BBaseAutoController::afterDeleteModels()
     */
    protected function _afterDeleteModels()
    {
        // refresh cache
        Yii::app()->messages->refreshCache();
    }
}