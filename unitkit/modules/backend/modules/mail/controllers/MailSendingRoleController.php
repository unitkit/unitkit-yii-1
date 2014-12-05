<?php

/**
 * Controller of sending role
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleController extends UAutoController
{
    protected $_model = 'UMailSendingRole';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UPerson[fullName]' => array(
                'search' => $_GET['search'],
                'model' => 'UPerson',
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
            'UMailSendRoleI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UMailSendRoleI18n',
                'select' => array(
                    'id' => 'u_mail_send_role_id',
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
        if (isset($_POST['UMailSendingRole'])) {
            $postData['UMailSendingRole'] = $_POST['UMailSendingRole'];
        }

        // data
        $data = $this->_loadEditModels();

        if (isset($_GET['UMailSendingRole']['u_mail_template_id'])) {
            $data['UMailSendingRole']->u_mail_template_id = $_GET['UMailSendingRole']['u_mail_template_id'];
        }

        // related data
        $relatedData = array();

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        $pk = array();
        if ($isSaved) {
            // set primary key
            $pk = array(
                'u_person_id' => $data['UMailSendingRole']->u_person_id,
                'u_mail_template_id' => $data['UMailSendingRole']->u_mail_template_id,
                'u_mail_send_role_id' => $data['UMailSendingRole']->u_mail_send_role_id
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
        if (isset($_POST['UMailSendingRole'])) {
            $postData['UMailSendingRole'] = $_POST['UMailSendingRole'];
        }

        // primary key
        $pk = array();
        $pk['u_person_id'] = $_GET['u_person_id'];
        $pk['u_mail_template_id'] = $_GET['u_mail_template_id'];
        $pk['u_mail_send_role_id'] = $_GET['u_mail_send_role_id'];

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = array();
        $relatedData['UMailTemplate[id]'] = array(
            '' => Unitkit::t('unitkit', 'input_select')
        ) + UHtml::listDataComboBox('UMailTemplate', array(
            'id',
            'id'
        ));

        // save data
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postData) ? $this->_saveEditModels($data, $postData) : false;

        // update the primary key
        if ($isSaved) {
            $pk['u_person_id'] = $data['UMailSendingRole']->u_person_id;
            $pk['u_mail_template_id'] = $data['UMailSendingRole']->u_mail_template_id;
            $pk['u_mail_send_role_id'] = $data['UMailSendingRole']->u_mail_send_role_id;
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
        if (isset($_POST['UMailSendingRole'])) {
            $postData['UMailSendingRole'] = $_POST['UMailSendingRole'];
        }

        // primary key
        $pk['u_person_id'] = $_GET['u_person_id'];
        $pk['u_mail_template_id'] = $_GET['u_mail_template_id'];
        $pk['u_mail_send_role_id'] = $_GET['u_mail_send_role_id'];

        // data
        $data = $this->_loadEditModels($pk);

        // related data
        $relatedData = array();
        $relatedData['UMailTemplate[id]'] = array(
            '' => Unitkit::t('unitkit', 'input_select')
        ) + UHtml::listDataComboBox('UMailTemplate', array(
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
            $pk['u_person_id'] = $data['UMailSendingRole']->u_person_id;
            $pk['u_mail_template_id'] = $data['UMailSendingRole']->u_mail_template_id;
            $pk['u_mail_send_role_id'] = $data['UMailSendingRole']->u_mail_send_role_id;

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