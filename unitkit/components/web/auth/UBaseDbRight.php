<?php

/**
 * BBaseDbRight manages rights that stores in database
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseDbRight extends CApplicationComponent
{
    /**
     * Cache duration
     *
     * @var int
     */
    public static $cacheDuration = 86400;

    /**
     * The ID of the cache application component that is used to cache the messages.
     *
     * @var string
     */
    public $cacheID;

    /**
     * Cache component
     *
     * @var mixed
     */
    protected $cache;

    public function init()
    {
        parent::init();
        $this->cache = Yii::app()->getComponent($this->cacheID);
    }

    /**
     * Get role name
     *
     * @param string $action Action name
     * @param string $controllerId Controller Id
     * @param string $moduleId Module Id
     * @return string
     */
    public function getRoleName($action, $controllerId, $moduleId)
    {
        return $action . ':' . $this->getRoleSuffix($controllerId, $moduleId);
    }

    /**
     * Get role suffix
     *
     * @param string $controllerId Controller Id
     * @param string $moduleId Module Id
     * @return string
     */
    protected function getRoleSuffix($controllerId, $moduleId)
    {
        $suffix = '';
        if (false === strrpos($moduleId, '/')) {
            $suffix .= Yii::app()->params['baseModuleApplication'] . '/';
        }
        $suffix .= $moduleId. '/'.$controllerId;

        return $suffix;
    }

    /**
     * Get array of default roles
     *
     * @param string $controllerId Controller Id
     * @param string $moduleId Module Id
     * @param string $filter Ex: consult, create, update, delete, translate
     * @return array
     */
    public function getDefaultRoles($controllerId, $moduleId, $filter = null)
    {
        $suffix = $this->getRoleSuffix($controllerId, $moduleId);

        $array = array(
            'consult' => array(
                'consult:' . $suffix,
                'consult:*'
            ),
            'create' => array(
                'create:' . $suffix,
                'create:*'
            ),
            'update' => array(
                'update:' . $suffix,
                'update:*'
            ),
            'delete' => array(
                'delete:' . $suffix,
                'delete:*'
            ),
        );

        if ($filter !== null && isset($array[$filter])) {
            return $array[$filter];
        }

        return $array;
    }

    /**
     * Get name of rights dynamic key
     */
    private static function getCacheRightsDynKeyName()
    {
        return sha1('b_right:dynamic_key');
    }

    /**
     * Get rights dynamic key from cache
     *
     * @param bool $refresh force refresh
     * @return string
     */
    public function getCacheRightsDynKey($refresh = false)
    {
        $val = ($refresh === true) ? false : $this->cache->get(self::getCacheRightsDynKeyName());
        return ($val === false) ? self::refreshCacheRightsDynKey() : $val;
    }

    /**
     * Delete rights dynamic key cache in cache
     *
     * @return bool
     */
    public function deleteCacheRightsDynKey()
    {
        return $this->cache->delete(self::getCacheRightsDynKeyName());
    }

    /**
     * Refresh rights dynamic key in cache
     *
     * @return bool
     */
    public function refreshCacheRightsDynKey()
    {
        $dynVal = uniqid(rand(), true);
        $this->cache->set(self::getCacheRightsDynKeyName(), $dynVal, self::$cacheDuration);

        return $dynVal;
    }

    /**
     * Search if UPerson has the specific role
     *
     * @param int $person UPerson ID
     * @param string $operation URole operation
     * @return bool
     */
    public function hasRole($person, $operation)
    {
        $personRoles = $this->getPersonRoles($person);

        return isset($personRoles[$operation]);
    }

    /**
     * Get person roles
     *
     * @param int $id UPerson ID
     * @param bool $refresh
     * @return array
     */
    public function getPersonRoles($id, $refresh = false)
    {
        // get sub keys
        $subKeysVal = array(
            'person' => $this->getCachePersonDynKey($id, $refresh),
            'right' => $this->getCacheRightsDynKey($refresh)
        );

        // build key
        $key = sha1('u_person_role:'.$subKeysVal['right'].':'.$subKeysVal['person'].':'.$id);

        // get rights from cache
        $roles = $this->cache->get($key);

        if (false === $roles) {
            // get models
            $models = UGroupRole::model()->with(array(
                'uRole' => array(
                    'select' => 'id, operation, business_rule',
                    'joinType' => 'INNER JOIN'
                ),
                'uPersonGroups' => array(
                    'select' => false,
                    'joinType' => 'INNER JOIN'
                ),
                'uPersonGroups.uPerson' => array(
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'u_person_id = :u_person_id AND activated = 1',
                    'params' => array(
                        ':u_person_id' => $id
                    )
                )
            ))->findAll();

            // build array of rights
            $roles = array();
            foreach ($models as $model) {
                if (! in_array($model->uRole->operation, $roles)) {
                    $roles[$model->uRole->operation] = $model->uRole->business_rule;
                }
            }

            // save rights in cache
            $this->cache->set($key, $roles, self::$cacheDuration);
        }

        return $roles;
    }

    /**
     * Get name of dynamic key
     *
     * @param $id UPerson ID
     * @return string
     */
    protected static function getCachePersonDynKeyName($id)
    {
        return 'u_person:dynamic_key:' . $id;
    }

    /**
     * Get dynamic key from cache
     *
     * @param $id UPerson ID
     * @param bool $refresh force refresh
     * @return string
     */
    public function getCachePersonDynKey($id, $refresh = false)
    {
        $val = ($refresh === true) ? false : $this->cache->get(self::getCachePersonDynKeyName($id));
        return ($val === false) ? $this->refreshCachePersonDynKey($id) : $val;
    }

    /**
     * Delete dynamic key cache in cache
     *
     * @param $id UPerson ID
     * @return bool
     */
    public function deleteCachePersonDynKey($id)
    {
        return $this->cache->delete(self::getCachePersonDynKeyName($id));
    }

    /**
     * Refresh dynamic key in cache
     *
     * @param $id UPerson ID
     * @return bool
     */
    public function refreshCachePersonDynKey($id)
    {
        $dynamicVal = uniqid(rand(), true);
        $this->cache->set(self::getCachePersonDynKeyName($id), $dynamicVal, self::$cacheDuration);

        return $dynamicVal;
    }

    /**
     * Get UPerson by ID
     *
     * @param int $id UPerson ID
     * @return CModel
     */
    public function getPerson($id)
    {
        $key = sha1('u_person:' . $id . ':' . $this->getCachePersonDynKey($id));
        $model = $this->cache->get($key);
        if ($model === false) {
            $model = UPerson::model()->findByPk($id);
            $this->cache->set($key, $model, 10800/* 3h */);
        }

        return $model;
    }

    /**
     * Search if UPerson has the specific group
     *
     * @param int $person UPerson ID
     * @param int $group UGroup ID
     * @return bool
     */
    public function hasGroup($person, $group)
    {
        return in_array($group, $this->getPersonGroup($person));
    }

    /**
     * Get person group
     *
     * @param int $id UPerson ID
     * @param bool $refresh
     * @return array
     */
    public function getPersonGroup($id, $refresh = false)
    {
        // get sub keys
        $subKeysVal = array(
            'person' => $this->getCachePersonDynKey($id, $refresh),
            'right' => $this->getCacheRightsDynKey($refresh)
        );

        // build key
        $key = sha1('u_person_group:' . $subKeysVal['right'] . ':' . $subKeysVal['person'] . ':' . $id);

        // get rights from cache
        $groups = $this->cache->get($key);

        if (false === $groups) {
            // get models
            $models = $this->with(array(
                'uPerson' => array(
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'u_person_id = :u_person_id AND activated = 1',
                    'params' => array(
                        ':u_person_id' => $id
                    )
                )
            ))->findAll();

            // build array of rights
            $groups = array();
            foreach ($models as $model) {
                $group = $model->u_group_id;
                if (! in_array($group, $groups)) {
                    $groups[] = $group;
                }
            }

            // save rights in cache
            $this->cache->set($key, $groups, self::$cacheDuration);
        }

        return $groups;
    }
}