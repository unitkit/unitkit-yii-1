<?php

/**
 * Controller of role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RoleController extends BAutoController
{
    protected $_model = 'BRole';
    protected $_modelI18n = 'BRoleI18n';

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