<?php

/**
 * @see CBaseUserIdentity
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseUserIdentity extends CBaseUserIdentity
{
    const ERR_USER_NOT_ACTIVATED = 101;
    const ERR_USER_NOT_VALIDATED = 102;

    /**
     * Authenticates a user based on {@link username} and {@link password}.
     * Derived classes should override this method, or an exception will be thrown.
     * This method is required by {@link IUserIdentity}.
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        throw new CException(Yii::t('yii', '{class}::authenticate() must be implemented.', array(
            '{class}' => get_class($this)
        )));
    }
}