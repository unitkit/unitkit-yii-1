<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupListDataView extends BListDataView
{

    /**
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
        $this->id = 'bGroupGroupMain';

        // component title
        $this->title = B::t('backend', 'right_person_group_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bGroupI18ns.name'
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_group_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
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
        // 'id' => 'bGroupVUpdatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bGroupVUpdatedAtEndGridSearch'
        // )
        // ))
        // ),
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
        // 'id' => 'bGroupVCreatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bGroupVCreatedAtEndGridSearch'
        // )
        // ))
        // ),
                );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_group_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
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
        // 'id' => 'bGroupVUpdatedAtStartAdvSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bGroupVUpdatedAtEndAdvSearch'
        // )
        // ))
        // ),
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
        // 'id' => 'bGroupVCreatedAtStartAdvSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bGroupVCreatedAtEndAdvSearch'
        // )
        // ))
        // ),
                );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new GroupListRowDataView($data, array(
                'id' => $data->id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}