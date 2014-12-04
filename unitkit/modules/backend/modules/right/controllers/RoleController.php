<?php

/**
 * Controller of role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RoleController extends UAutoController
{
    protected $_model = 'URole';
    protected $_modelI18n = 'URoleI18n';

    /**
     * (non-PHPdoc)
     *
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