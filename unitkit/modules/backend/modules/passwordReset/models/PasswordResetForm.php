<?php

/**
 * Model of password reset form
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PasswordResetForm extends CFormModel
{
    public $email;
    public $isSent = false;

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email', 'allowEmpty' => false, 'checkMX' => true),
            array('email', 'length', 'max' => 300),
            array('email', 'isAuth')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'email' => Unitkit::t('unitkit', 'u_person:email')
        );
    }

    /**
     * Verify if email exist and if password can be reset
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function isAuth($attribute, $params)
    {
        if ($this->email !== '') {
            $person = UPerson::model()->findByAttributes(array(
                'email' => $this->email
            ));
            if ($person === null)
                $this->addError('email', Unitkit::t('backend', 'u_person_email_not_exist'));
            elseif ($person->active_reset == 0)
                $this->addError('email', Unitkit::t('backend', 'password_reset_cant_be_reset'));
        }
    }

    public function sendEmail()
    {
        if (! $this->hasErrors()) {
            $mail = new UMail();
            $mail->classFunction = 'MailFunctionPasswordReset';
            $mail->staticParams = array(
                'nb' => Unitkit::v('backend', 'u_person_token_expired_at:resetPassword')
            );
            $mail->sqlParams = array(
                'email' => $this->email
            );

            if ($mail->sendMailTemplate(Unitkit::v('backend', 'mail_template_id:resetPassword'), Yii::app()->language)) {
                $this->isSent = true;
            }
        }

        return $this->isSent;
    }
}