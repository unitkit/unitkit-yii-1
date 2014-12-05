<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nListDataView extends UListDataView
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
        $this->id = 'uSiteI18nSiteI18nMain';

        // component title
        $this->title = Unitkit::t('backend', 'i18n_site_i18n_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uI18nI18ns.name',
            'uSiteI18n.activated'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uI18nI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->i18n_id) ? UI18nI18n::model()->findByPk(array(
                        'u_i18n_id' => $model->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'i18n_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uI18nI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->i18n_id) ? UI18nI18n::model()->findByPk(array(
                        'u_i18n_id' => $model->i18n_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                ),
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'datas' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
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