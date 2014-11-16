<?php

/**
 * @see CUrlManager
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseUrlManager extends CUrlManager
{

    /**
     * Get rules
     */
    protected function getRules()
    {
        return array();
    }

    /**
     * @see CUrlManager::processRules()
     */
    protected function processRules()
    {
        $this->rules += $this->getRules();
        return parent::processRules();
    }

    /**
     * @see CUrlManager::createUrl()
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if (isset($params['partial']))
            unset($params['partial']);

        if (! isset($params['language'])) {
            if (Yii::app()->user->hasState('language'))
                Yii::app()->language = BLanguagesApp::secureLanguage(Yii::app()->user->getState('language'));
            elseif (isset(Yii::app()->request->cookies['language']))
                Yii::app()->language = BLanguagesApp::secureLanguage(Yii::app()->request->cookies['language']->value);

            $params['language'] = Yii::app()->language;
        }

        return parent::createUrl($route, $params, $ampersand);
    }
}