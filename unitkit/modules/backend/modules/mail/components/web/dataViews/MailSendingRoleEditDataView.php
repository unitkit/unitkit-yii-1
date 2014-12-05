<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleEditDataView extends UEditDataView
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
        $this->id = 'uMailSendingRoleMailSendingRoleEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'mail_mail_sending_role_create_title');
        $this->updateTitle = Unitkit::t('backend', 'mail_mail_sending_role_update_title');

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
        $this->isNewRecord = $data['UMailSendingRole']->isNewRecord;

        $this->action = $this->controller->createUrl($this->controller->id . '/' . ($this->isNewRecord ? 'create' : 'update'), array_merge($this->pk, array(
            'UMailSendingRole[u_mail_template_id]' => $data['UMailSendingRole']->u_mail_template_id
        )));

        // refresh page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UMailSendingRole'],
                'attribute' => 'u_mail_send_role_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UMailSendRoleI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UMailSendingRole']->u_mail_send_role_id) ? UMailSendRoleI18n::model()->findByPk(array(
                        'u_mail_send_role_id' => $data['UMailSendingRole']->u_mail_send_role_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $data['UMailSendingRole'],
                'attribute' => 'u_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[fullName]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UMailSendingRole']->u_person_id) ? UPerson::model()->findByPk($data['UMailSendingRole']->u_person_id)->fullName : '',
                    'data-addAction' => $this->controller->createUrl('/bRight/person/create')
                )
            ))
        );
    }
}