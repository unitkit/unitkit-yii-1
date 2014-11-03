<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleListDataView extends BListDataView
{

    /**
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$datas, &$relatedDatas, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = 'bMailSendingRoleMailSendingRoleMain';

        // title
        $this->title = B::t('backend', 'mail_mail_sending_role_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_mail_send_role_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bMailSendRoleI18nNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BMailSendRoleI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_mail_send_role_id) ? BMailSendRoleI18n::model()->findByPk(array(
                        'b_mail_send_role_id' => $model->b_mail_send_role_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bPersonFirstNameGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BPerson[first_name]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_person_id) ? BPerson::model()->findByPk($model->b_person_id)->first_name : ''
                )
            ))
        );

        // rows
        foreach ($datas as $data)
            $this->rows[] = new MailSendingRoleListRowDataView($data, array(
                'b_person_id' => $data->b_person_id,
                'b_mail_template_id' => $data->b_mail_template_id,
                'b_mail_send_role_id' => $data->b_mail_send_role_id
            ));

            // pagination
        $this->pagination = $pagination;
    }
}