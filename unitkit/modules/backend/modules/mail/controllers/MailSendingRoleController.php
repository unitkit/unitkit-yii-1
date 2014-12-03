<?php

/**
 * Controller of sending role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleController extends BAutoController
{
    protected $_model = 'BMailSendingRole';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BPerson[fullName]' => array(
                'search' => $_GET['search'],
                'model' => 'BPerson',
                'select' => array(
                    'id' => 'id',
                    'text' => 'fullName',
                    'compare' => false
                ),
                'criteria' => array(
                    'select' => 'id, first_name, last_name',
                    'condition' => 'first_name LIKE :fullname OR last_name LIKE :fullname',
                    'params' => array(
                        ':fullname' => $_GET['search'] . '%'
                    ),
                    'order' => 'first_name ASC',
                    'limit' => 10
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0
            ),
            'BMailSendRoleI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BMailSendRoleI18n',
                'select' => array(
                    'id' => 'b_mail_send_role_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(
                        ':i18nId' => $_GET['language']
                    ),
                    'order' => 'name ASC',
                    'limit' => 10
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0
            )
        );
    }

    /**
     * Insert models (Action)
     */
    public function actionCreate()
    {
        // data to update
        $postData = array();
        if (isset($_POST['BMailSendingRole'])) {
            $postData['BMailSendingRole'] = $_POST['BMailSendingRole'];
        }

        // data
        $data = $this->_loadEditModels();

        if (isset($_GET['BMailSendingRole']['b_mail_template_id'])) {
            $data['BMailSendingRole']->b_mail_template_id = $_GET['BMailSendingRole']['b_mail_template_id'];
        }

        // related data
        $relatedData = array();

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        $pk = array();
        if ($isSaved) {
            // set primary key
            $pk = array(
                'b_person_id' => $data['BMailSendingRole']->b_person_id,
                'b_mail_template_id' => $data['BMailSendingRole']->b_mail_template_id,
                'b_mail_send_role_id' => $data['BMailSendingRole']->b_mail_send_role_id
            );
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new MailSendingRoleEditDataView($data, $relatedData, $pk, $isSaved)
            )
        );
    }

    /**
     * Update models (Action)
     */
    public function actionUpdate()
    {
        // data to update
        $postData = array();
        if (isset($_POST['BMailSendingRole'])) {
            $postData['BMailSendingRole'] = $_POST['BMailSendingRole'];
        }

        // primary key
        $pk = array();
        $pk['b_person_id'] = $_GET['b_person_id'];
        $pk['b_mail_template_id'] = $_GET['b_mail_template_id'];
        $pk['b_mail_send_role_id'] = $_GET['b_mail_send_role_id'];

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = array();
        $relatedData['BMailTemplate[id]'] = array(
            '' => B::t('unitkit', 'input_select')
        ) + BHtml::listDatasCombobox('BMailTemplate', array(
            'id',
            'id'
        ));

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        // update the primary key
        if ($isSaved) {
            $pk['b_person_id'] = $data['BMailSendingRole']->b_person_id;
            $pk['b_mail_template_id'] = $data['BMailSendingRole']->b_mail_template_id;
            $pk['b_mail_send_role_id'] = $data['BMailSendingRole']->b_mail_send_role_id;
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new MailSendingRoleEditDataView($data, $relatedData, $pk, $isSaved)
            )
        );
    }

    /**
     * Edit a row (Action)
     */
    public function actionEditRow()
    {
        // data to update
        $postData = array();
        if (isset($_POST['BMailSendingRole'])) {
            $postData['BMailSendingRole'] = $_POST['BMailSendingRole'];
        }

        // primary key
        $pk['b_person_id'] = $_GET['b_person_id'];
        $pk['b_mail_template_id'] = $_GET['b_mail_template_id'];
        $pk['b_mail_send_role_id'] = $_GET['b_mail_send_role_id'];

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = array();
        $relatedData['BMailTemplate[id]'] = array(
            '' => B::t('unitkit', 'input_select')
        ) + BHtml::listDatasCombobox('BMailTemplate', array(
            'id',
            'id'
        ));

        // save models
        $isSaved = ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        if (! $isSaved) {
            // render view
            $html = $this->bRenderPartial('list/_tbodyRowEdit', array(
                'dataView' => new MailSendingRoleEditRowDataView($data, $relatedData, $pk, $isSaved)
            ), true);
        } else {
            // update the primary key
            $pk['b_person_id'] = $data['BMailSendingRole']->b_person_id;
            $pk['b_mail_template_id'] = $data['BMailSendingRole']->b_mail_template_id;
            $pk['b_mail_send_role_id'] = $data['BMailSendingRole']->b_mail_send_role_id;

            // refresh the row
            $html = $this->_refreshRow($pk);
        }
        echo CJSON::encode(array(
            'html' => $html,
            'refreshRow' => $isSaved
        ));
        Yii::app()->end();
    }
}