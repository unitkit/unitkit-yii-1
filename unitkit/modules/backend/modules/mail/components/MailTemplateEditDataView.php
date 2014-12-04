<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateEditDataView extends UEditDataView
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
        $this->id = 'uMailTemplateMailTemplateEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'mail_mail_template_create_title');
        $this->updateTitle = Unitkit::t('backend', 'mail_mail_template_update_title');

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
        $this->isNewRecord = $data['UMailTemplate']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'u_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl($controller->id . '/advComboBox/', array(
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
                'model' => $data['UMailTemplate'],
                'attribute' => 'sql_request',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UMailTemplate']->getAttributeLabel('sql_request')
                )
            )),
            new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'sql_param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UMailTemplate']->getAttributeLabel('sql_param')
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

        if (! $data['UMailTemplate']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'created_at',
                'value' => $data['UMailTemplate']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UMailTemplate'],
                'attribute' => 'updated_at',
                'value' => $data['UMailTemplate']->updated_at
            ));
        }
    }
}