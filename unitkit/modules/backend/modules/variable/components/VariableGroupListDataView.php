<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupListDataView extends BListDataView
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
        $this->id = 'bVariableGroupVariableGroupMain';

        // component title
        $this->title = B::t('backend', 'variable_variable_group_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bVariableGroupI18ns.name',
            'bVariableGroup.code'
        // 'bVariableGroup.created_at',
        // 'bVariableGroup.updated_at',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_variable_group_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
        // new BDateRangeItemField(
        // $model,
        // 'created_at',
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_start',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bVariableGroupVCreatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bVariableGroupVCreatedAtEndGridSearch'
        // )
        // ))
        // ),
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
        // 'id' => 'bVariableGroupVUpdatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bVariableGroupVUpdatedAtEndGridSearch'
        // )
        // ))
        // ),
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_variable_group_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BDateRangeItemField($model, 'created_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bVariableGroupVCreatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bVariableGroupVCreatedAtEndAdvSearch'
                )
            ))),
            new BDateRangeItemField($model, 'updated_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bVariableGroupVUpdatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bVariableGroupVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new VariableGroupListRowDataView($data, array(
                'id' => $data->id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}