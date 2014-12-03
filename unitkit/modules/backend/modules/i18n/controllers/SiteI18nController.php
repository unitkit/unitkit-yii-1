<?php

/**
 * Controller of site I18n
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nController extends BAutoController
{
    protected $_model = 'BSiteI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BI18nI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BI18nI18n',
                'select' => array(
                    'id' => 'b_i18n_id',
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
     * @see BBaseAutoController::afterDeleteModels()
     */
    protected function _afterDeleteModels()
    {
        // refresh cache
        $model = BSiteI18n::model();
        $model->getI18nIds(true /* refresh */, true);
        $model->getI18nIds(true /* refresh */, false);
        $model->getI18nIds(true /* refresh */, null);
    }

    /**
     * @see BBaseAutoController::afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        // refresh cache
        $models['BSiteI18n']->getI18nIds(true /* refresh */, true);
        $models['BSiteI18n']->getI18nIds(true /* refresh */, false);
        $models['BSiteI18n']->getI18nIds(true /* refresh */, null);
    }
}