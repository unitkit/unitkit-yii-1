<?php

/**
 * Controller of group
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupController extends UAutoController
{
    protected $_model = 'UGroup';
    protected $_modelI18n = 'UGroupI18n';

    /**
     * @see BBaseAutoController::afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        Yii::app()->rights->deleteCacheRightsDynKey();
    }

    /**
     * @see BBaseAutoController::afterDeleteModels()
     */
    protected function _afterDeleteModels()
    {
        Yii::app()->rights->deleteCacheRightsDynKey();
    }
}