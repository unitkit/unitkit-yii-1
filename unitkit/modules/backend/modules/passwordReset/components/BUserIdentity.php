<?php

/**
 * This class represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BUserIdentity extends BBaseUserIdentity
{
    /**
     * User id
     *
     * @var int
     */
    private $_id;

    public function __construct($id)
    {
        $this->_id = $id;
    }

    /**
     * Get user id
     *
     * @see CUserIdentity::getId()
     */
    public function getId()
    {
        return $this->_id;
    }
}