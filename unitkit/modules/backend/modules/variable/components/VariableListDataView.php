<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableListDataView extends UListDataView
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
        $this->id = 'uVariableVariableMain';

        // component title
        $this->title = Unitkit::t('backend', 'variable_variable_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uVariableGroupI18ns.name',
            'uVariable.param',
            'uVariable.val',
            'uVariableI18ns.description'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_variable_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uVariableGroupI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UVariableGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_variable_group_id) ? UVariableGroupI18n::model()->findByPk(array(
                        'u_variable_group_id' => $model->u_variable_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'val',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_variable_i18ns_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_variable_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uVariableGroupI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UVariableGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_variable_group_id) ? UVariableGroupI18n::model()->findByPk(array(
                        'u_variable_group_id' => $model->u_variable_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'val',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_variable_i18ns_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uVariableVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uVariableVCreatedAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'updated_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uVariableVUpdatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uVariableVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new VariableListRowDataView($d, array(
                'id' => $d->id
            ));
        }

            // pagination
        $this->pagination = $pagination;
    }
}