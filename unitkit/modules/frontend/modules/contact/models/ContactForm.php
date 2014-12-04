<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ContactForm extends CFormModel
{
    public
        $firstName,
        $lastName,
        $email,
        $phone,
        $message;

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            array('firstName, lastName, email, message', 'required'),
            array('email', 'email', 'allowEmpty' => false, 'checkMX' => true),
            array('firstName, lastName', 'length', 'min' => 2, 'max' => 50),
            array('phone', 'length', 'min' => 4, 'max' => 20),
            array('message', 'length', 'min' => 10, 'max' => 5000),
            array('firstName, lastName, phone', 'filter', 'filter' => function($v){ return strip_tags($v); }),
            array('message', 'filter', 'filter' => function($v){ return strip_tags($v); })
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'firstName' => Unitkit::t('frontend', 'contact_form:first_name'),
            'lastName' => Unitkit::t('frontend', 'contact_form:last_name'),
            'email' => Unitkit::t('frontend', 'contact_form:email'),
            'message' => Unitkit::t('frontend', 'contact_form:message'),
            'phone' => Unitkit::t('frontend', 'contact_form:phone'),
        );
    }

    /**
     * Send email
     *
     * @return bool
     * @throws Exception
     */
    public function sendEmail()
    {
        $isSent = false;
        if (! $this->hasErrors()) {
            $mail = new UMail();
            $mail->staticParams = array(
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => nl2br($this->message),
            );
            $mail->replyTo = array($this->email, $this->firstName.' '.$this->lastName);
            if ($mail->sendMailTemplate(Unitkit::v('frontend', 'mail_template_id:contact'), Yii::app()->language)) {
                $isSent = true;
                $this->unsetAttributes(array('firstName', 'lastName', 'email', 'phone', 'message'));
            }
        }

        return $isSent;
    }
} 