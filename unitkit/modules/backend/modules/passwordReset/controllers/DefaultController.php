<?php

/**
 * Controller of password reset
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class DefaultController extends BController
{
    /**
     * Default action
     *
     * @var string
     */
    public $defaultAction = 'reset';

    /**
     * @see BBaseController::init()
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = B::t('backend', 'password_reset_title');
    }

    /**
     * Reset action
     */
    public function actionReset()
    {
        // models
        $models = array();
        $models['PasswordResetForm'] = new PasswordResetForm();

        if (Yii::app()->request->isPostRequest && isset($_POST['PasswordResetForm'])) {
            $models['PasswordResetForm']->attributes = $_POST['PasswordResetForm'];
            if ($models['PasswordResetForm']->validate())
                $models['PasswordResetForm']->sendEmail();
        }

        $this->dynamicRender('reset', array(
            'models' => $models
        ));
    }

    /**
     * Validate action
     *
     * @throws CHttpException
     */
    public function actionValidate()
    {
        if (! empty($_GET['uuid']) && ! empty($_GET['code'])) {
            $personToken = BPersonToken::model()->with('bPerson')->findByAttributes(array(
                'uuid' => $_GET['uuid']
            ));

            if ($personToken !== null && CPasswordHelper::verifyPassword($_GET['code'], $personToken->password) && $personToken->action === B::v('backend', 'b_person_token_action:resetPassword') && $personToken->bPerson->active_reset == 1 && new DateTime($personToken->expired_at) >= new DateTime('now')) {
                // models
                $models = array();
                $models['NewPasswordForm'] = new NewPasswordForm();

                if (Yii::app()->request->isPostRequest && isset($_POST['NewPasswordForm'])) {
                    $models['NewPasswordForm']->attributes = $_POST['NewPasswordForm'];
                    if ($models['NewPasswordForm']->validate()) {
                        $person = BPerson::model()->findByPk($personToken->b_person_id);
                        if ($person !== null) {
                            // begin a transaction
                            $transaction = $personToken->dbConnection->beginTransaction();
                            try {
                                // update password and save
                                $person->password = $models['NewPasswordForm']->password;
                                if ($person->save() && $personToken->delete()) {
                                    // flush rights in cache
                                    Yii::app()->rights->deleteCachePersonDynKey($person->id);

                                    // commit transaction
                                    $transaction->commit();

                                    // login user
                                    if (Yii::app()->user->login(new BUserIdentity($person->id)))
                                        $this->redirect(Yii::app()->user->returnUrl);
                                }
                            } catch (Exception $e) {
                                // roll back
                                if ($transaction->active)
                                    $transaction->rollback();
                            }
                        }
                    }
                }

                $this->dynamicRender('newPassword', array(
                    'models' => $models
                ));
            } else {
                $this->dynamicRender('newPassword', array(
                    'message' => B::t('backend', 'reset_password_invalid_token', array(
                        '{link}' => BHtml::link(B::t('backend', 'password_reset_renew'), $this->createUrl($this->id . '/reset'), array(
                            'class' => 'btn btn-sm btn-info'
                        ))
                    ))
                ));
            }
        } else {
            throw new CHttpException(500);
        }
    }
}