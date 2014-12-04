<?php

/**
 * This class represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UUserIdentity extends UBaseUserIdentity
{
    /**
     * User id
     *
     * @var int
     */
    private $_id;

    /**
     * Username
     *
     * @var string username
     */
    private $_username;

    /**
     * Password
     *
     * @var string password
     */
    private $_password;

    public function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * @see CUserIdentity::authenticate()
     */
    public function authenticate()
    {
        $model = UPerson::model()->findByEmail($this->_username);
        if ($model === null || ! CPasswordHelper::verifyPassword($this->_password, $model->password)) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } elseif ($model->activated == 0) {
            $this->errorCode = self::ERR_USER_NOT_ACTIVATED;
        } elseif ($model->validated == 0) {
            $this->errorCode = self::ERR_USER_NOT_VALIDATED;
        } else {
            $this->_id = $model->id;
            $this->errorCode = self::ERROR_NONE;
            return true;
        }
        return false;
    }

    /**
     * @see CUserIdentity::getId()
     */
    public function getId()
    {
        return $this->_id;
    }
}