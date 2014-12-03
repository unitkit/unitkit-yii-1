<?php

/**
 * !!!!!!!!!!! BE CAREFUL !!!!!!!!!!!!!!
 * Note, when {@link allowAutoLogin cookie-based authentication} is enabled,
 * all these persistent data will be stored in cookie. Therefore, DO NOT
 * STORE PASSWORD or OTHER SENSITIVE DATA in the persistent storage. Instead,
 * YOU SHOULD STORE THEM DIRECTLY IN SESSION on the server side if needed.
 *
 * @see CWebUser
 *
 * autoRenewCookie is disabled
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseWebUser extends CWebUser
{
    /**
     * List of roles
     *
     * @var array
     */
    private $_roles = array();

    /**
     * List of access
     *
     * @var array
     */
    private $_access = array();

    /**
     * List of groups
     *
     * @var array
     */
    private $_groups = array();

    /**
     * BPerson
     *
     * @var BPerson
     */
    private $_person;

    /**
     * Navigate role
     *
     * @var int
     */
    protected $_navigateRole;

    /**
     * Auto login duration
     *
     * @var int
     */
    protected $_autoLoginDuration;

    /**
     * Array of data used to auto login
     *
     * @var mixed
     */
    protected $_autoLoginData;

    public function init()
    {
        parent::init();
        Yii::app()->getSession()->open();

        if ($this->getIsGuest()) {
            if ($this->allowAutoLogin) {
                $this->restoreFromCookie();
            }
        } else {
            // Person must exist, be activated and have role to navigate
            $person = $this->getPerson();
            if ($person === null || $person->activated == 0 || $person->validated == 0 || ! $this->checkAccess($this->_navigateRole)) {
                $this->logout();
            }
        }

        if ($this->autoUpdateFlash)
            $this->updateFlash();

        $this->updateAuthStatus();
    }

    /**
     * This method is disabled
     */
    protected function renewCookie()
    {}

    /**
     * Populates the current user object with the information obtained from cookie.
     * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
     * The user identity information is recovered from cookie.
     * Sufficient security measures are used to prevent cookie data from being tampered.
     *
     * @see saveToCookie
     */
    protected function restoreFromCookie()
    {
        $app = Yii::app();
        $request = $app->request;
        $cookie = $request->cookies->itemAt($this->getStateKeyPrefix());

        if ($cookie && ! empty($cookie->value) && is_string($cookie->value) && ($data = $app->getSecurityManager()->validateData($cookie->value)) !== false) {
            $data = @unserialize($data);
            if (is_array($data) && isset($data[0 /* uuid */], $data[1 /* key1 */], $data[2 /* key2 */])) {
                $identity = new BUserIdentityAuto($data[0 /* uuid */], $data[1 /* key1 */], $data[2 /* key2 */]);
                if ($identity->authenticate()) {
                    // get session
                    $session = Yii::app()->getSession();
                    // regenerate session ID
                    $session->regenerateID(true);

                    // set ID
                    $this->setId($identity->getId());

                    // BAutoLogin model
                    $autoLogin = $identity->getModel();
                    // regenerate auto login
                    $this->generateAutoLogin($autoLogin->uuid);

                    // if is an ajax request
                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        $this->loginRequiredAjaxResponse = json_encode(array(
                            'loginReload' => true,
                            'sess_key' => $session['sess_key'],
                            'csrf' => Yii::app()->request->getCsrfToken()
                        ));
                        $this->loginRequired();
                    }
                    return true;
                } else {
                    Yii::app()->getRequest()
                        ->getCookies()
                        ->remove($this->getStateKeyPrefix());
                }
            }
        }
        return false;
    }

    /**
     * Search if user has the specific group
     *
     * @param int $group BGroup ID
     */
    public function hasGroup($group)
    {
        return in_array(sha1($group), $this->getGroups());
    }

    /**
     * Get person
     *
     * @return BPerson
     */
    public function getPerson()
    {
        if (! $this->getIsGuest() && empty($this->_person))
            $this->_person = Yii::app()->rights->getPerson($this->getId());

        return $this->_person;
    }

    /**
     * Get user groups
     *
     * @return array of rights
     */
    protected function getGroups()
    {
        if (! $this->getIsGuest() && empty($this->_groups)) {
            $this->_groups = Yii::app()->rights->getPersonGroup($this->getId());
        }
        return $this->_groups;
    }

    /**
     * Logs in a user.
     *
     * The user identity information will be saved in storage that is
     * persistent during the user session. By default, the storage is simply
     * the session storage. If the duration parameter is greater than 0,
     * a cookie will be sent to prepare for cookie-based login in future.
     *
     * Note, you have to set {@link allowAutoLogin} to true
     * if you want to allow user to be authenticated based on the cookie information.
     *
     * @param IUserIdentity $identity the user identity (which should already be authenticated)
     * @param integer $duration number if the duration is equal to 1 and allowAutoLogin is enabled,
     *        a auto login session is built
     * @return boolean whether the user is logged in
     */
    public function login($identity, $duration = 0)
    {
        if (Yii::app()->rights->hasRole($identity->getId(), $this->_navigateRole)) {
            // regenerate session ID
            Yii::app()->getSession()->regenerateID(true);

            // set ID
            $this->setId($identity->getId());

            // set default language
            BLanguagesApp::setLanguage($this->getPerson()->default_language);

            // generate auto login
            if ($this->allowAutoLogin && $duration > 0)
                $this->generateAutoLogin();
        }

        return ! $this->getIsGuest();
    }

    /**
     * Logs out the current user.
     * This will remove authentication-related session data.
     * If the parameter is true, the whole session will be destroyed as well.
     *
     * @param boolean $destroySession whether to destroy the whole session. Defaults to true. If false,
     *        then {@link clearStates} will be called, which removes only the data stored via {@link setState}.
     */
    public function logout($destroySession = true)
    {
        if ($this->allowAutoLogin) {
            Yii::app()->getRequest()
                ->getCookies()
                ->remove($this->getStateKeyPrefix());
            if ($this->identityCookie !== null) {
                $cookie = $this->createIdentityCookie($this->getStateKeyPrefix());
                $cookie->value = null;
                $cookie->expire = 0;
                Yii::app()->getRequest()
                    ->getCookies()
                    ->add($cookie->name, $cookie);
            }

            // delete auto login entry in database
            // we get uuid from session rather than cookie in order to prevent hack
            $uuid = $this->getState('bAutoLogin:uuid');
            if ($uuid !== null) {
                BAutoLogin::model()->deleteAllByAttributes(array(
                    'uuid' => $uuid
                ));
            }
        }

        if ($destroySession)
            Yii::app()->getSession()->destroy();
        else
            $this->clearStates();
    }

    /**
     * Generate auto login
     *
     * @param string $prevUUID previous uuid
     */
    protected function generateAutoLogin($prevUUID = null)
    {
        $model = new BAutoLogin();

        // begin transaction
        $transaction = $model->dbConnection->beginTransaction();
        try {
            // generate uuid and keys
            $this->_autoLoginData[0 /* uuid */] = BTools::sha256(uniqid(mt_rand(), true) . ':' . BTools::password(500));
            $this->_autoLoginData[1 /* key 1 */] = BTools::sha512(uniqid(mt_rand(), true) . ':' . BTools::password(500));
            $this->_autoLoginData[2 /* key 2 */] = BTools::sha512(uniqid(mt_rand(), true) . ':' . BTools::password(500));

            // hash keys in database
            $hashKeys = array(
                CPasswordHelper::hashPassword($this->_autoLoginData[1 /* key 1 */], 13),
                CPasswordHelper::hashPassword($this->_autoLoginData[2 /* key 2 */], 13)
            );

            // duration in second
            $duration = 3600 * 24 * $this->_autoLoginDuration;

            // set attributes
            $model->uuid = $this->_autoLoginData[0 /* uuid */];
            $model->key1 = $hashKeys[0];
            $model->key2 = $hashKeys[1];
            $model->b_person_id = $this->getId();
            $model->duration = $duration;
            $model->created_at = BTools::now();
            $model->expired_at = date('Y-m-d H:i:s', time() + $duration);

            // save
            if ($model->save()) {
                // delete previous auto login instance
                if ($prevUUID !== null) {
                    $model->deleteAllByAttributes(array(
                        'uuid' => $prevUUID
                    ));
                }

                // commit
                $transaction->commit();

                // save uuid in session in order to reuse them for logout process
                $this->setState('bAutoLogin:uuid', $this->_autoLoginData[0 /* uuid */]);

                // save keys on cookie
                $this->saveToCookie($duration);

                return true;
            } else
                throw new Exception();
        } catch (Exception $e) {
            // roll back
            if ($transaction->active)
                $transaction->rollback();
            else
                throw $e;
        }

        return false;
    }

    /**
     * Saves necessary user data into a cookie.
     * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
     * These information are used to do authentication next time when user visits the application.
     *
     * @param integer $duration number of seconds that the user can remain in logged-in status. Defaults to 0, meaning login till the user closes the browser.
     * @see restoreFromCookie
     * @throws Exception
     */
    protected function saveToCookie($duration)
    {
        if (! empty($this->_autoLoginData)) {
            $app = Yii::app();
            $cookie = $this->createIdentityCookie($this->getStateKeyPrefix());
            $cookie->expire = time() + $duration;
            $cookie->value = $app->getSecurityManager()->hashData(serialize($this->_autoLoginData));
            $app->getRequest()
                ->getCookies()
                ->add($cookie->name, $cookie);
        } else {
            throw new Exception();
        }
    }

    /**
     * @see CWebUser::loginRequired()
     */
    public function loginRequired()
    {
        $app = Yii::app();
        $request = $app->getRequest();

        if ($request->getIsAjaxRequest() && ! isset($this->loginRequiredAjaxResponse)) {
            $this->loginRequiredAjaxResponse = json_encode(array(
                'loginReload' => true,
                'url' => $app->createUrl($app->user->loginUrl[0])
            ));
        }

        parent::loginRequired();
    }

    /**
     * Get person roles
     *
     * @return array
     */
    protected function getRoles()
    {
        if (empty($this->_roles)) {
            $this->_roles = Yii::app()->rights->getPersonRoles($this->getId());
        }

        return $this->_roles;
    }

    /**
     * Performs access check multiple for this user.
     *
     * @param mixed $operations array of operation {@link BBaseWebUser::checkAccess}
     * @param array $params {@link BBaseWebUser::checkAccess}
     * @param string $allowCaching {@link BBaseWebUser::checkAccess}
     * @return boolean
     */
    public function checkMultiAccess($operations, $params = array(), $allowCaching = true)
    {
        foreach ($operations as $operation) {
            if ($this->checkAccess($operation, $params, $allowCaching)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Performs access check for this user.
     *
     * @param string $operation the name of the operation that need access check.
     * @param array $params name-value pairs that would be passed to business rules associated
     *        with the tasks and roles assigned to the user.
     *        Since version 1.1.11 a param with name 'userId' is added to this array, which holds the value of
     *        {@link getId()} when {@link CDbAuthManager} or {@link CPhpAuthManager} is used.
     * @param boolean $allowCaching whether to allow caching the result of access check.
     *        When this parameter
     *        is true (default), if the access check of an operation was performed before,
     *        its result will be directly returned when calling this method to check the same operation.
     *        If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
     *        to obtain the up-to-date access result. Note that this caching is effective
     *        only within the same request and only works when <code>$params=array()</code>.
     * @return boolean whether the operations can be performed by this user.
     */
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
        if ($allowCaching && $params === array() && isset($this->_access[$operation]))
            return $this->_access[$operation];

        if (! isset($params['userId']))
            $params['userId'] = $this->getId();

        $access = isset($this->roles[$operation]) && $this->executeBizRule($this->roles[$operation], $params);

        if ($allowCaching && $params === array())
            $this->_access[$operation] = $access;

        return $access;
    }

    /**
     * Executes the specified business rule.
     *
     * @param string $bizRule the business rule to be executed.
     * @param array $params parameters name-value pairs that would be passed to biz rules
     * @return boolean whether the business rule returns true.
     *         If the business rule is empty, it will still return true.
     */
    public function executeBizRule($bizRule, $params)
    {
        return $bizRule === '' || $bizRule === null || @eval($bizRule) != 0;
    }
}