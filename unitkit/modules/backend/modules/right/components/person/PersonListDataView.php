<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonListDataView extends BListDataView
{

    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$datas, &$relatedDatas, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = 'bPersonPersonMain';

        // title
        $this->title = B::t('backend', 'right_person_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bPerson.email',
            'bPerson.first_name',
            'bPerson.last_name',
            'bPerson.activated',
            'bPerson.validated',
            'bI18nI18ns.name',
            'bPerson.created_at'
        // 'bPerson.updated_at',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
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
            new BItemField(array(
                'model' => $model,
                'attribute' => 'validated',
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
            new BItemField(array(
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bI18nI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $model->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BDateRangeItemField($model, 'created_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVCreatedAtStartGridSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVCreatedAtEndGridSearch'
                )
            )))
        // new BDateRangeItemField(
        // $model,
        // 'updated_at',
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_start',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bPersonVUpdatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bPersonVUpdatedAtEndGridSearch'
        // )
        // ))
        // ),
                );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'validated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bI18nI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $model->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BDateRangeItemField($model, 'created_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVCreatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVCreatedAtEndAdvSearch'
                )
            ))),
            new BDateRangeItemField($model, 'updated_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVUpdatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bPersonVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new PersonListRowDataView($data, array(
                'id' => $data->id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}