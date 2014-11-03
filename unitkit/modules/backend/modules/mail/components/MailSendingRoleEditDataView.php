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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bMailSendingRoleMailSendingRoleEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_sending_role_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_sending_role_update_title');

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
        $this->isNewRecord = $datas['BMailSendingRole']->isNewRecord;

        $this->action = $this->controller->createUrl($this->controller->id . '/' . ($this->isNewRecord ? 'create' : 'update'), array_merge($this->pk, array(
            'BMailSendingRole[b_mail_template_id]' => $datas['BMailSendingRole']->b_mail_template_id
        )));

        // refresh page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BMailSendingRole'],
                'attribute' => 'b_mail_send_role_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BMailSendRoleI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BMailSendingRole']->b_mail_send_role_id) ? BMailSendRoleI18n::model()->findByPk(array(
                        'b_mail_send_role_id' => $datas['BMailSendingRole']->b_mail_send_role_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BMailSendingRole'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BPerson[fullName]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BMailSendingRole']->b_person_id) ? BPerson::model()->findByPk($datas['BMailSendingRole']->b_person_id)->fullName : '',
                    'data-addAction' => $this->controller->createUrl('/bRight/person/create')
                )
            ))
        );
    }
}