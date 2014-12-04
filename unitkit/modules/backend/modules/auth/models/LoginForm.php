<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class LoginForm extends CFormModel
{
    public $username;
    public $password;
    public $remember_me;
    private $_identity;

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            array('password', 'authenticate'),
            array('remember_me', 'boolean')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'username' => Unitkit::t('backend', 'login_form:username'),
            'password' => Unitkit::t('backend', 'login_form:password'),
            'remember_me' => Unitkit::t('backend', 'login_form:remember_me')
        );
    }

    /**
     * Authenticate
     *
     * @param string $attribute
     * @param mixed $params
     */
    public function authenticate($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $this->_identity = new UUserIdentity($this->username, $this->password);
            if (! $this->_identity->authenticate()) {
                if ($this->_identity->errorCode === UUserIdentity::ERR_USER_NOT_ACTIVATED) {
                    $this->addError('password', Unitkit::t('backend', 'account_not_activated'));
                } elseif ($this->_identity->errorCode === UUserIdentity::ERR_USER_NOT_VALIDATED) {
                    $this->addError('password', Unitkit::t('backend', 'account_not_validated'));
                } else {
                    $this->addError('password', Unitkit::t('backend', 'bad_login_password'));
                }
            }
        }
    }

    /**
     * Login
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UUserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }

        if ($this->_identity->errorCode === UUserIdentity::ERROR_NONE) {
            $user = Yii::app()->user;
            if (! $user->login($this->_identity, $this->remember_me)) {
                $this->addError('password', Unitkit::t('backend', 'bad_login_password'));
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}