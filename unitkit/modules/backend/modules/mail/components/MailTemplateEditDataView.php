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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     * @param CController $controller
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved, &$controller)
    {
        $this->id = 'bMailTemplateMailTemplateEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_template_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_template_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($datas as $data)
            if ($this->hasErrors = $data->hasErrors())
                break;

        // new record status
        $this->isNewRecord = $datas['BMailTemplate']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'b_mail_template_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl($controller->id . '/advCombobox/', array(
                        'name' => 'BMailTemplateGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BMailTemplate']->b_mail_template_group_id) ? BMailTemplateGroupI18n::model()->findByPk(array(
                        'b_mail_template_group_id' => $datas['BMailTemplate']->b_mail_template_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'html_mode',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BMailTemplate']->getAttributeLabel('html_mode')
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'sql_request',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BMailTemplate']->getAttributeLabel('sql_request')
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'sql_param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BMailTemplate']->getAttributeLabel('sql_param')
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplateI18n'],
                'attribute' => 'object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BMailTemplateI18n']->getAttributeLabel('object')
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailTemplateI18n'],
                'attribute' => 'message',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'placeholder' => $datas['BMailTemplateI18n']->getAttributeLabel('message')
                )
            ))
        );

        if (! $datas['BMailTemplate']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'created_at',
                'value' => $datas['BMailTemplate']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BMailTemplate'],
                'attribute' => 'updated_at',
                'value' => $datas['BMailTemplate']->updated_at
            ));
        }
    }
}