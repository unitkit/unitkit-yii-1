<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateEditRowDataView extends BEditRowItemDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
    {
        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'b_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BMailTemplate']->b_mail_template_group_id) ? BMailTemplateGroupI18n::model()->findByPk(array(
                        'b_mail_template_group_id' => $data['BMailTemplate']->b_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'html_mode',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMailTemplate']->getAttributeLabel('html_mode')
                )
            )),
            new BItemField(array(
                'model' => $data['BMailTemplateI18n'],
                'attribute' => 'object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMailTemplateI18n']->getAttributeLabel('object')
                )
            )),
            new BItemField(array(
                'model' => $data['BMailTemplateI18n'],
                'attribute' => 'message',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'placeholder' => $data['BMailTemplateI18n']->getAttributeLabel('message')
                )
            ))
        );
    }
}