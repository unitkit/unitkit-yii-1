<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nListDataView extends BListDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$data, &$relatedData, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = 'bSiteI18nSiteI18nMain';

        // component title
        $this->title = B::t('backend', 'i18n_site_i18n_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bI18nI18ns.name',
            'bSiteI18n.activated'
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bI18nI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->i18n_id) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $model->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'data' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bI18nI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->i18n_id) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $model->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                ),
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'datas' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
        );

        // rows
        foreach ($data as $d)
            $this->rows[] = new SiteI18nListRowDataView($d, array(
                'i18n_id' => $d->i18n_id,
                'activated' => $d->activated
            ));

        // pagination
        $this->pagination = $pagination;
    }
}