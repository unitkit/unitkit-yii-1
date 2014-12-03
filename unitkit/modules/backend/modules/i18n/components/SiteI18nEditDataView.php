<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nEditDataView extends BEditDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        $this->id = 'bSiteI18nSiteI18nEdit';

        // component title
        $this->createTitle = B::t('backend', 'i18n_site_i18n_create_title');
        $this->updateTitle = B::t('backend', 'i18n_site_i18n_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($data as $d) {
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

            // new record status
        $this->isNewRecord = $data['BSiteI18n']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BSiteI18n'],
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BSiteI18n']->i18n_id) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $data['BSiteI18n']->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BSiteI18n'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm'
                )
            )),
        );
    }
}