<?php

/**
 * This class manages the mails in the app
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
abstract class BBaseMail extends CComponent
{

    /**
     * Array of parameters used to build the request
     *
     * @var mixed
     */
    public $sqlParams = array();

    /**
     * Array of parameters used to build the mail
     *
     * @var string
     */
    public $staticParams = array();

    /**
     * Array of file path to include
     *
     * @var mixed
     */
    public $filesPath = array();

    /**
     * Enable code parsing to execute static functions
     *
     * @var bool
     */
    public $parseToExecute = true;

    /**
     * Class name contained functions to execute
     */
    public $classFunction = 'BMailFunction';

    /**
     * Reply to
     *
     * @var mixed array(email[, name]) see mailer::AddReplyTo()
     */
    public $replyTo = array();

    /**
     * Form name
     *
     * @var string $fromName
     */
    public $fromName;

    /**
     * Instance of PHPMailer
     *
     * @var PHPMailer
     */
    protected $_mailer;

    /**
     * Initialize component
     */
    public function init()
    {}

    /**
     * Get mailer instance
     */
    public function getMailer()
    {
        if ($this->_mailer === null)
            $this->_mailer = Yii::app()->mailer;
        return $this->_mailer;
    }

    /**
     * Set mailer instance
     *
     * @param PHPMailer $mailer
     */
    public function setMailer($mailer)
    {
        $this->_mailer = $mailer;
    }

    /**
     * Send an email using a specific mail template
     *
     * @param int $id mail template ID
     * @param string $i18nId i18n ID
     * @throws Exception
     *
     * @return bool return true if message is correctly sent else false
     */
    public function sendMailTemplate($id, $i18nId)
    {
        // get mail template
        $modelMailTemp = new BMailTemplate();
        $modelMailTemp->unsetAttributes();
        $mailTemplate = $modelMailTemp->with(array(
            'bMailTemplateI18ns' => array(
                'condition' => 'i18n_id = :i18n_id',
                'joinType' => 'LEFT JOIN',
                'params' => array(
                    ':i18n_id' => $i18nId
                )
            )
        ))->findByAttributes(array(
            'id' => $id
        ));

        if ($mailTemplate === null)
            throw new Exception(B::t('unitkit', 'mail_template_not_exist'));
        elseif (! isset($mailTemplate->bMailTemplateI18ns[0]))
            throw new Exception(B::t('unitkit', 'mail_template_not_translated'));

            // get sending roles
        $modelSendingRoles = new BMailSendingRole();
        $modelSendingRoles->unsetAttributes();
        $sendingRoles = $modelSendingRoles->with(array(
            'bPerson' => array(
                'joinType' => 'LEFT JOIN'
            )
        ))->findAllByAttributes(array(
            'b_mail_template_id' => $mailTemplate->id
        ));

        if (count($sendingRoles) == 0)
            throw new Exception(B::t('unitkit', 'mail_no_sending_role'));

            // decode params
        $mailObject = $mailTemplate->bMailTemplateI18ns[0]->object;
        $mailBody = $mailTemplate->bMailTemplateI18ns[0]->message;

        // replace static parameters
        foreach ($this->staticParams as $param => $value) {
            $mailObject = str_replace('{' . $param . '}', $value, $mailObject);
            $mailBody = str_replace('{' . $param . '}', $value, $mailBody);
        }

        if ($mailTemplate->sql_request != '') {
            // build sql parameters
            $params = empty($this->sqlParams) ? $this->buildSqlParams($mailTemplate->sql_param) : $this->sqlParams;

            // execute query
            $connection = Yii::app()->db;
            $command = $connection->createCommand($mailTemplate->sql_request);

            foreach ($params as $param => $value)
                $command->bindParam(':' . $param, $value);

            $resQuery = $command->queryRow();

            if ($resQuery === false)
                throw new Exception(B::t('unitkit', 'mail_template_request_error'));

            // exception
            foreach ($resQuery as $attrName => $attrVal) {
                $mailObject = str_replace('{' . $attrName . '}', $attrVal, $mailObject);
                $mailBody = str_replace('{' . $attrName . '}', $attrVal, $mailBody);
                if ($attrName === 'b_mt_email_to' && $attrVal != '')
                    $this->mailer->AddAddress($attrVal);
                elseif ($attrName === 'b_mt_email_from' && $attrVal != '')
                    $this->mailer->SetFrom($attrVal);
                elseif ($attrName === 'b_mt_email_sender' && $attrVal != '')
                    $this->mailer->Sender = $attrVal;
            }
        }

        if (! empty($this->replyTo))
            $this->mailer->AddReplyTo($this->replyTo[0], isset($this->replyTo[1]) ? utf8_decode($this->replyTo[1]) : '');

        if ($this->parseToExecute)
            $mailBody = self::parseMailFunction($mailBody, $this->classFunction);

        $mailBodyHtml = '';
        if ($mailTemplate->html_mode == 1)
            $mailBodyHtml = $mailBody;

        // add attachment
        foreach ($this->filesPath as $path)
            $this->mailer->AddAttachment($path);

        $this->mailer->Subject = utf8_decode($mailObject);
        if ($mailBodyHtml != '') {
            $this->mailer->MsgHTML(utf8_decode($mailBodyHtml));
            $this->mailer->AltBody = strip_tags($mailBody);
        } else
            $this->mailer->Body = utf8_decode($mailBody);

        foreach ($sendingRoles as $sendingRole) {
            switch ($sendingRole->b_mail_send_role_id) {
                case B::v('unitkit', 'b_send_role_id:from'):
                    $this->mailer->SetFrom($sendingRole->bPerson->email, isset($this->fromName) ? utf8_decode($this->fromName) : '');
                    $this->mailer->Sender = $sendingRole->bPerson->email;
                    break;
                case B::v('unitkit', 'b_send_role_id:to'):
                    $this->mailer->AddAddress($sendingRole->bPerson->email);
                    break;
                case B::v('unitkit', 'b_send_role_id:cc'):
                    $this->mailer->AddCC($sendingRole->bPerson->email);
                    break;
                case B::v('unitkit', 'b_send_role_id:bcc'):
                    $this->mailer->AddBCC($sendingRole->bPerson->email);
                    break;
            }
        }

        return $this->mailer->Send();
    }

    /**
     * Extract params from mail functions
     * The separator character used is "|"
     *
     * @param string $string
     */
    public static function extractParamsMailFunction($string)
    {
        $params = explode('|', $string);
        return $params;
    }

    /**
     * Build sql parameters
     *
     * @param string $value string to transform
     * @return mixed array of parameters array( array(0 => id, 1 => value), array(0 => id, 1 => value), ...)
     */
    public function buildSqlParams($value)
    {
        $params = array();
        $tmpParams = explode('&', $value);
        foreach ($tmpParams as $param) {
            $exParam = explode('=', $param);
            $params[$exParam[0]] = $exParam[1];
        }
        return $params;
    }

    /**
     * Parse string in order to find functions to execute
     * Functions are contained in the class $classFunction
     *
     * @param string $string string to parse
     * @param string $classFunction class name contained functions to execute
     */
    protected static function parseMailFunction($string, $classFunction)
    {
        $list = array();
        preg_match_all("#\{(.*)\((.*)\)\}#msU", $string, $list, PREG_SET_ORDER);
        $find = array();
        $replace = array();
        foreach ($list as $function) {
            $find[] = '{' . $function[1] . '(' . $function[2] . ')}';
            $replace[] = $classFunction::$function[1]($function[2]);
        }
        return str_replace($find, $replace, $string);
    }
}