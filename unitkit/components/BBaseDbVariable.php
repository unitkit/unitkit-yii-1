<?php

/**
 * BBaseDbVariable represents a variable that stores value variable in database.
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseDbVariable extends CApplicationComponent
{
    /**
     * Cache duration
     *
     * @var int
     */
    public static $cacheDuration = 86400;

    /**
     * ID of the cache application component that is used to cache the messages.
     *
     * @var string
     */
    public $cacheID;

    /**
     * List of variables.
     * array(group_id => (var_id => , var_id =>), group_id => array(var_id =>, var_id => ))
     *
     * @var array
     */
    private static $_vars = array();

    /**
     * Get variable value from cache
     *
     * @param string $code Code ID
     * @param string $param BBParam param
     * @param bool $refresh refresh parameters
     */
    public function getVariable($code, $param, $refresh = false)
    {
        if (! isset(self::$_vars[$code]) || $refresh) {
            // cache
            $cache = Yii::app()->getComponent($this->cacheID);
            // key
            $key = 'b_variable:b_variable_group:' . $this->getCacheDynKey($refresh) . ':' . $code;

            // get variables from cache
            self::$_vars[$code] = $cache->get($key);

            // get variables from database
            if (false === self::$_vars[$code]) {
                self::$_vars[$code] = array();
                foreach (BVariable::model()->with(array(
                    'bVariableGroup' => array(
                        'condition' => 'code = :code',
                        'params' => array(
                            ':code' => $code
                        )
                    )
                ))->findAll() as $BBParam) {
                    self::$_vars[$code][$BBParam->param] = $BBParam->val;
                }
                $cache->set($key, self::$_vars[$code], self::$cacheDuration);
            }
        }

        if (isset(self::$_vars[$code][$param])) {
            return self::$_vars[$code][$param];
        } else {
            return $code.':'.$param;
        }
    }

    /**
     * Get name of dynamic key
     */
    protected static function getCacheDynKeyName()
    {
        return 'b_variable:dynamic_key';
    }

    /**
     * Get dynamic key from cache
     *
     * @param bool $refresh force refresh
     */
    public function getCacheDynKey($refresh = false)
    {
        $val = ($refresh === true) ? false : Yii::app()->getComponent($this->cacheID)->get($this->getCacheDynKeyName());
        return ($val === false) ? self::refreshCacheDynKey() : $val;
    }

    /**
     * Delete dynamic key cache in cache
     */
    public function deleteCacheDynKey()
    {
        return Yii::app()->getComponent($this->cacheID)->delete($this->getCacheDynKeyName());
    }

    /**
     * Refresh dynamic key in cache
     */
    public function refreshCacheDynKey()
    {
        $dynVal = uniqid(rand(), true);
        Yii::app()->getComponent($this->cacheID)->set($this->getCacheDynKeyName(), $dynVal, self::$cacheDuration);
        return $dynVal;
    }
}