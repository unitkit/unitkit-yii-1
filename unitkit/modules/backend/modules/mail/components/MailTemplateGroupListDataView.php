<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateGroupListDataView extends BListDataView
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
        $this->id = 'bMailTemplateGroupMailTemplateGroupMain';

        // component title
        $this->title = B::t('backend', 'mail_mail_template_group_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bMailTemplateGroupI18ns.name'
        // 'bMailTemplateGroup.created_at',
        // 'bMailTemplateGroup.updated_at',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_group_i18ns_name',
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
        // 'id' => 'bMailTemplateGroupVCreatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bMailTemplateGroupVCreatedAtEndGridSearch'
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
        // 'id' => 'bMailTemplateGroupVUpdatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bMailTemplateGroupVUpdatedAtEndGridSearch'
        // )
        // ))
        // ),
                );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_group_i18ns_name',
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
                    'id' => 'bMailTemplateGroupVCreatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateGroupVCreatedAtEndAdvSearch'
                )
            ))),
            new BDateRangeItemField($model, 'updated_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateGroupVUpdatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateGroupVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new MailTemplateGroupListRowDataView($data, array(
                'id' => $data->id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}