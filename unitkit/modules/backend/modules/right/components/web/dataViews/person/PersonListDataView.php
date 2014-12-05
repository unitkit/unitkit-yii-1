<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonListDataView extends UListDataView
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
        $this->id = 'uPersonPersonMain';

        // title
        $this->title = Unitkit::t('backend', 'right_person_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uPerson.email',
            'uPerson.first_name',
            'uPerson.last_name',
            'uPerson.activated',
            'uPerson.validated',
            'uI18nI18ns.name',
            'uPerson.created_at'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
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
            new UItemField(array(
                'model' => $model,
                'attribute' => 'validated',
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
            new UItemField(array(
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uI18nI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->default_language) ? UI18nI18n::model()->findByPk(array(
                        'u_i18n_id' => $model->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVCreatedAtStartGridSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVCreatedAtEndGridSearch'
                )
            )))
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
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
            new UItemField(array(
                'model' => $model,
                'attribute' => 'validated',
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
            new UItemField(array(
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uI18nI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->default_language) ? UI18nI18n::model()->findByPk(array(
                        'u_i18n_id' => $model->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVCreatedAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'updated_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVUpdatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uPersonVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new PersonListRowDataView($d, array(
                'id' => $d->id
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}