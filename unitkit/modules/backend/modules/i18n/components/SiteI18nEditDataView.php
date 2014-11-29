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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bSiteI18nSiteI18nEdit';

        // component title
        $this->createTitle = B::t('backend', 'i18n_site_i18n_create_title');
        $this->updateTitle = B::t('backend', 'i18n_site_i18n_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($datas as $data)
            if ($this->hasErrors = $data->hasErrors())
                break;

            // new record status
        $this->isNewRecord = $datas['BSiteI18n']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BSiteI18n'],
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BSiteI18n']->i18n_id) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $datas['BSiteI18n']->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BSiteI18n'],
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