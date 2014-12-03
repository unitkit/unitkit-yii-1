<?php

/**
 * Controller of variable
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableController extends BAutoController
{
    protected $_model = 'BVariable';
    protected $_modelI18n = 'BVariableI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BVariableGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BVariableGroupI18n',
                'select' => array(
                    'id' => 'b_variable_group_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(
                        ':i18nId' => $_GET['language']
                    ),
                    'order' => 'name ASC',
                    'limit' => 10
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0
            )
        );
    }

    /**
     * @see BBaseAutoController::_afterDeleteModels()
     */
    public function _afterDeleteModels()
    {
        // refresh cache
        Yii::app()->variables->refreshCacheDynKey();
    }

    /**
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    public function _afterSaveEditModels(&$models)
    {
        // refresh cache
        Yii::app()->variables->refreshCacheDynKey();
    }
}