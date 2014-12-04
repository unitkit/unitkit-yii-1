<?php

/**
 * @see CUrlManager
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
abstract class UBaseUrlManager extends CUrlManager
{
    /**
     * Cache key
     */
    const CACHE_RULES_KEY = 'b_cache_rules_key';

    /**
     * Cache prefix key
     */
    const CACHE_RULES_PREFIX_KEY = 'b_cache_rules_key:prefix';

    /**
     * Cache time
     */
    const CACHE_RULES_TIME = 86400;

    /**
     * Clear cache in all applications
     */
    public function clearAllCache()
    {
        if (($cache = Yii::app()->getComponent('cmsCache')) !== null) {
            $cache->delete(self::CACHE_RULES_PREFIX_KEY);
        }
    }

    /**
     * Get rules
     */
    abstract protected function getRules();

    /**
     * @see CUrlManager::processRules()
     */
    protected function processRules()
    {
        $cache = Yii::app()->getComponent('cmsCache');
        $cacheUrl = Yii::app()->getComponent('urlCache');

        $prefix = $cache->get(self::CACHE_RULES_PREFIX_KEY);
        if ($prefix === false) {
            $prefix = 'b_cache_rules:'.uniqid(uniqid(UTools::password(512)), true);
            $cache->set(self::CACHE_RULES_PREFIX_KEY, $prefix);
        }
        if (($data = $cacheUrl->get(self::CACHE_RULES_KEY.':'.$prefix)) !== false) {
            $this->rules = $data;
        }

        if (empty($this->rules)) {
            $this->rules += $this->getRules();
        }

        $cacheUrl->set(self::CACHE_RULES_KEY.':'.$prefix, $this->rules, self::CACHE_RULES_TIME);

        parent::processRules();
    }

    /**
     * @see CUrlManager::createUrl()
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if (isset($params['partial'])) {
            unset($params['partial']);
        }

        if (! isset($params['language'])) {
            if (Yii::app()->user->hasState('language')) {
                Yii::app()->language = ULanguagesApp::secureLanguage(Yii::app()->user->getState('language'));
            } elseif (isset(Yii::app()->request->cookies['language'])) {
                Yii::app()->language = ULanguagesApp::secureLanguage(Yii::app()->request->cookies['language']->value);
            }
            $params['language'] = Yii::app()->language;
        }

        return parent::createUrl($route, $params, $ampersand);
    }
}