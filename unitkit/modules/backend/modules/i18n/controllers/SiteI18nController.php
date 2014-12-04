<?php

/**
 * Controller of site I18n
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nController extends UAutoController
{
    protected $_model = 'USiteI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UI18nI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UI18nI18n',
                'select' => array(
                    'id' => 'u_i18n_id',
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
        $model = USiteI18n::model();
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
        $models['USiteI18n']->getI18nIds(true /* refresh */, true);
        $models['USiteI18n']->getI18nIds(true /* refresh */, false);
        $models['USiteI18n']->getI18nIds(true /* refresh */, null);
    }
}