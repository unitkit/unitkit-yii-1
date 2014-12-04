<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateListDataView extends UListDataView
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
        $this->id = 'uMailTemplateMailTemplateMain';

        // component title
        $this->title = Unitkit::t('backend', 'mail_mail_template_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uMailTemplateGroupI18ns.name',
            'uMailTemplate.html_mode',
            'uMailTemplateI18ns.object',
            'uMailTemplateI18ns.message'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uMailTemplateGroupI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_mail_template_group_id) ? UMailTemplateGroupI18n::model()->findByPk(array(
                        'u_mail_template_group_id' => $model->u_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'attribute' => 'html_mode',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_mail_template_i18ns_object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_mail_template_i18ns_message',
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
                'attribute' => 'u_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uMailTemplateGroupI18nNameAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_mail_template_group_id) ? UMailTemplateGroupI18n::model()->findByPk(array(
                        'u_mail_template_group_id' => $model->u_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'attribute' => 'html_mode',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'sql_request',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'sql_param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_mail_template_i18ns_object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_mail_template_i18ns_message',
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
                    'id' => 'uMailTemplateVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateVCreatedAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'updated_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateVUpdatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new MailTemplateListRowDataView($d, array(
                'id' => $d->id
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}