<?php

/**
 * This class represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BUserIdentityAuto extends BBaseUserIdentity
{
    /**
     * User id
     *
     * @var int
     */
    private $_id;

    /**
     * BAutoLogin model
     *
     * @var BAutoLogin
     */
    private $_model;

    /**
     * Unique ID used to connect
     *
     * @var string
     */
    private $_uuid;

    /**
     * Key 1 used to connect
     *
     * @var string
     */
    private $_key1;

    /**
     * Key 2 used to connect
     *
     * @var string
     */
    private $_key2;

    /**
     * Auto login from keys
     *
     * @param string $uuid Unique ID
     * @param string $key1 Key 1
     * @param string $key2 Key 2
     */
    public function __construct($uuid, $key1, $key2)
    {
        $this->_uuid = $uuid;
        $this->_key1 = $key1;
        $this->_key2 = $key2;
    }

    /**
     * Authenticates a user based on keys
     *
     * @param array $keys array of keys
     * @return bool
     */
    public function authenticate()
    {
        $model = BPerson::model()->getByUUID($this->_uuid);

        if ($model === null || ! CPasswordHelper::verifyPassword($this->_key1, $model->bAutoLogins[0]->key1) || ! CPasswordHelper::verifyPassword($this->_key2, $model->bAutoLogins[0]->key2)) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } elseif ($model->activated == 0)
            $this->errorCode = self::ERR_USER_NOT_ACTIVATED;
        elseif ($model->validated == 0)
            $this->errorCode = self::ERR_USER_NOT_VALIDATED;
        else {
            $this->_id = $model->id;
            $this->_model = $model->bAutoLogins[0];
            $this->errorCode = self::ERROR_NONE;
            return true;
        }

        return false;
    }

    /**
     * Get BAutoLogin model
     *
     * @return BAutoLogin
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @see CUserIdentity::getId()
     */
    public function getId()
    {
        return $this->_id;
    }
}