<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleEditDataView extends BEditDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        $this->id = 'bMailSendingRoleMailSendingRoleEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_sending_role_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_sending_role_update_title');

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
        $this->isNewRecord = $data['BMailSendingRole']->isNewRecord;

        $this->action = $this->controller->createUrl($this->controller->id . '/' . ($this->isNewRecord ? 'create' : 'update'), array_merge($this->pk, array(
            'BMailSendingRole[b_mail_template_id]' => $data['BMailSendingRole']->b_mail_template_id
        )));

        // refresh page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMailSendingRole'],
                'attribute' => 'b_mail_send_role_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BMailSendRoleI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BMailSendingRole']->b_mail_send_role_id) ? BMailSendRoleI18n::model()->findByPk(array(
                        'b_mail_send_role_id' => $data['BMailSendingRole']->b_mail_send_role_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BMailSendingRole'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BPerson[fullName]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BMailSendingRole']->b_person_id) ? BPerson::model()->findByPk($data['BMailSendingRole']->b_person_id)->fullName : '',
                    'data-addAction' => $this->controller->createUrl('/bRight/person/create')
                )
            ))
        );
    }
}