<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateEditRowDataView extends UEditRowItemDataView
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
            new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'u_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UMailTemplate']->u_mail_template_group_id) ? UMailTemplateGroupI18n::model()->findByPk(array(
                        'u_mail_template_group_id' => $data['UMailTemplate']->u_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'html_mode',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UMailTemplate']->getAttributeLabel('html_mode')
                )
            )),
            new UItemField(array(
                'model' => $data['UMailTemplateI18n'],
                'attribute' => 'object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UMailTemplateI18n']->getAttributeLabel('object')
                )
            )),
            new UItemField(array(
                'model' => $data['UMailTemplateI18n'],
                'attribute' => 'message',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'placeholder' => $data['UMailTemplateI18n']->getAttributeLabel('message')
                )
            ))
        );
    }
}