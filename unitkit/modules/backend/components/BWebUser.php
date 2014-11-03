<?php

/**
 * !!!!!!!!!!! BE CAREFUL !!!!!!!!!!!!!!
 * Note, when {@link allowAutoLogin cookie-based authentication} is enabled,
 * all these persistent data will be stored in cookie. Therefore, DO NOT
 * STORE PASSWORD or OTHER SENSITIVE DATA in the persistent storage. Instead,
 * YOU SHOULD STORE THEM DIRECTLY IN SESSION on the server side if needed.
 *
 * autoRenewCookie is disabled
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BWebUser extends BBaseWebUser
{

    public function init()
    {
        $this->_autoLoginDuration = B::v('backend', 'b_auto_login_duration');
        $this->_navigateRole = B::v('backend', 'b_role_id:navigate');

        parent::init();
    }
}