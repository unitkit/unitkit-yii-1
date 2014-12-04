<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleListDataView extends UListDataView
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
        $this->id = 'uMailSendingRoleMailSendingRoleMain';

        // title
        $this->title = Unitkit::t('backend', 'mail_mail_sending_role_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_mail_send_role_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uMailSendRoleI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UMailSendRoleI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_mail_send_role_id) ? UMailSendRoleI18n::model()->findByPk(array(
                        'u_mail_send_role_id' => $model->u_mail_send_role_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uPersonFirstNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[first_name]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_person_id) ? UPerson::model()->findByPk($model->u_person_id)->first_name : ''
                )
            ))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new MailSendingRoleListRowDataView($d, array(
                'u_person_id' => $d->u_person_id,
                'u_mail_template_id' => $d->u_mail_template_id,
                'u_mail_send_role_id' => $d->u_mail_send_role_id
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}