<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateListDataView extends BListDataView
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
        $this->id = 'bMailTemplateMailTemplateMain';

        // component title
        $this->title = B::t('backend', 'mail_mail_template_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bMailTemplateGroupI18ns.name',
            'bMailTemplate.html_mode',
        // 'bMailTemplate.sql_request',
        // 'bMailTemplate.sql_param',
            'bMailTemplateI18ns.object',
            'bMailTemplateI18ns.message'
        // 'bMailTemplate.created_at',
        // 'bMailTemplate.updated_at',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bMailTemplateGroupI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_mail_template_group_id) ? BMailTemplateGroupI18n::model()->findByPk(array(
                        'b_mail_template_group_id' => $model->b_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'datas' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'attribute' => 'html_mode',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            // new BItemField(array(
            // 'model' => $model,
            // 'attribute' => 'sql_request',
            // 'type' => 'activeTextField',
            // 'htmlOptions' => array(
            // 'class' => 'form-control input-sm',
            // 'placeholder' => B::t('unitkit', 'input_search'),
            // 'id' => false
            // )
            // )),
            // new BItemField(array(
            // 'model' => $model,
            // 'attribute' => 'sql_param',
            // 'type' => 'activeTextField',
            // 'htmlOptions' => array(
            // 'class' => 'form-control input-sm',
            // 'placeholder' => B::t('unitkit', 'input_search'),
            // 'id' => false
            // )
            // )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_i18ns_object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_i18ns_message',
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
        // 'id' => 'bMailTemplateVCreatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_created_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bMailTemplateVCreatedAtEndGridSearch'
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
        // 'id' => 'bMailTemplateVUpdatedAtStartGridSearch'
        // )
        // )),
        // new BItemField(array(
        // 'model' => $model,
        // 'attribute' => 'v_updated_at_end',
        // 'type' => 'activeTextField',
        // 'htmlOptions' => array(
        // 'class' => 'form-control input-sm date-picker date-range',
        // 'placeholder' => B::t('unitkit', 'input_search'),
        // 'id' => 'bMailTemplateVUpdatedAtEndGridSearch'
        // )
        // ))
        // ),
                );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bMailTemplateGroupI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_mail_template_group_id) ? BMailTemplateGroupI18n::model()->findByPk(array(
                        'b_mail_template_group_id' => $model->b_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'datas' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'attribute' => 'html_mode',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'sql_request',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'sql_param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_i18ns_object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_mail_template_i18ns_message',
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
                    'id' => 'bMailTemplateVCreatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateVCreatedAtEndAdvSearch'
                )
            ))),
            new BDateRangeItemField($model, 'updated_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateVUpdatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bMailTemplateVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new MailTemplateListRowDataView($data, array(
                'id' => $data->id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}