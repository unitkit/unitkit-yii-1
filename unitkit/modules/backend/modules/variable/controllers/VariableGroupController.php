<?php

/**
 * Controller of variable group
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupController extends UAutoController
{
    protected $_model = 'UVariableGroup';
    protected $_modelI18n = 'UVariableGroupI18n';

    /**
     * @see BBaseAutoController::afterDeleteModels()
     */
    public function _afterDeleteModels()
    {
        // refresh cache
        Yii::app()->variables->refreshCacheDynKey();
    }

    /**
     * @see BBaseAutoController::afterSaveEditModels()
     */
    public function _afterSaveEditModels(&$models)
    {
        // refresh cache
        Yii::app()->variables->refreshCacheDynKey();
    }
}