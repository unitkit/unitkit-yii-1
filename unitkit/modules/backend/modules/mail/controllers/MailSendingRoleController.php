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
    protected function _advancedConbobox()
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
        // datas to update
        $postDatas = array();
        if (isset($_POST['BMailSendingRole']))
            $postDatas['BMailSendingRole'] = $_POST['BMailSendingRole'];

            // datas
        $datas = $this->_loadEditModels();

        if (isset($_GET['BMailSendingRole']['b_mail_template_id']))
            $datas['BMailSendingRole']->b_mail_template_id = $_GET['BMailSendingRole']['b_mail_template_id'];

        // related datas
        $relatedDatas = array();

        // save datas
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postDatas) ? $this->_saveEditModels($datas, $postDatas) : false;

        $pk = array();
        if ($isSaved) {
            // set primary key
            $pk = array(
                'b_person_id' => $datas['BMailSendingRole']->b_person_id,
                'b_mail_template_id' => $datas['BMailSendingRole']->b_mail_template_id,
                'b_mail_send_role_id' => $datas['BMailSendingRole']->b_mail_send_role_id
            );
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new MailSendingRoleEditDataView($datas, $relatedDatas, $pk, $isSaved)
            )
        );
    }

    /**
     * Update models (Action)
     */
    public function actionUpdate()
    {
        // datas to update
        $postDatas = array();
        if (isset($_POST['BMailSendingRole']))
            $postDatas['BMailSendingRole'] = $_POST['BMailSendingRole'];

            // primary key
        $pk = array();
        $pk['b_person_id'] = $_GET['b_person_id'];
        $pk['b_mail_template_id'] = $_GET['b_mail_template_id'];
        $pk['b_mail_send_role_id'] = $_GET['b_mail_send_role_id'];

        // datas
        $datas = $this->_loadEditModels($pk);

        // related datas
        $relatedDatas = array();
        $relatedDatas['BMailTemplate[id]'] = array(
            '' => B::t('unitkit', 'input_select')
        ) + BHtml::listDatasCombobox('BMailTemplate', array(
            'id',
            'id'
        ));

        // save datas
        $isSaved = Yii::app()->request->isPostRequest && ! empty($postDatas) ? $this->_saveEditModels($datas, $postDatas) : false;

        // update the primary key
        if ($isSaved) {
            $pk['b_person_id'] = $datas['BMailSendingRole']->b_person_id;
            $pk['b_mail_template_id'] = $datas['BMailSendingRole']->b_mail_template_id;
            $pk['b_mail_send_role_id'] = $datas['BMailSendingRole']->b_mail_send_role_id;
        }

        $this->dynamicRender(
            'edit/edit',
            array(
                'dataView' => new MailSendingRoleEditDataView($datas, $relatedDatas, $pk, $isSaved)
            )
        );
    }

    /**
     * Edit a row (Action)
     *
     * @throws Exception
     */
    public function actionEditRow()
    {
        // datas to update
        $postDatas = array();
        if (isset($_POST['BMailSendingRole']))
            $postDatas['BMailSendingRole'] = $_POST['BMailSendingRole'];

            // primary key
        $pk['b_person_id'] = $_GET['b_person_id'];
        $pk['b_mail_template_id'] = $_GET['b_mail_template_id'];
        $pk['b_mail_send_role_id'] = $_GET['b_mail_send_role_id'];

        // datas
        $datas = $this->_loadEditModels($pk);

        // related datas;
        $relatedDatas = array();
        $relatedDatas['BMailTemplate[id]'] = array(
            '' => B::t('unitkit', 'input_select')
        ) + BHtml::listDatasCombobox('BMailTemplate', array(
            'id',
            'id'
        ));

        // save models
        $isSaved = ! empty($postDatas) ? $this->_saveEditModels($datas, $postDatas) : false;

        if (! $isSaved) {
            // render view
            $html = $this->bRenderPartial('list/_tbodyRowEdit', array(
                'dataView' => new MailSendingRoleEditRowDataView($datas, $relatedDatas, $pk, $isSaved)
            ), true);
        } else {
            // update the primary key
            $pk['b_person_id'] = $datas['BMailSendingRole']->b_person_id;
            $pk['b_mail_template_id'] = $datas['BMailSendingRole']->b_mail_template_id;
            $pk['b_mail_send_role_id'] = $datas['BMailSendingRole']->b_mail_send_role_id;

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