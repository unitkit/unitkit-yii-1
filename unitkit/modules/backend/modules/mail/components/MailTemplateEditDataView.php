<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateEditDataView extends BEditDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     * @param CController $controller
     */
    public function __construct($data, $relatedData, $pk, $isSaved, &$controller)
    {
        $this->id = 'bMailTemplateMailTemplateEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_template_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_template_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($data as $d) {
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BMailTemplate']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'b_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl($controller->id . '/advComboBox/', array(
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
                'model' => $data['BMailTemplate'],
                'attribute' => 'sql_request',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMailTemplate']->getAttributeLabel('sql_request')
                )
            )),
            new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'sql_param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMailTemplate']->getAttributeLabel('sql_param')
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

        if (! $data['BMailTemplate']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'created_at',
                'value' => $data['BMailTemplate']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BMailTemplate'],
                'attribute' => 'updated_at',
                'value' => $data['BMailTemplate']->updated_at
            ));
        }
    }
}