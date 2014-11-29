<?php

/**
 * This class manages language in the app
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseLanguagesApp extends CComponent
{

    /**
     * Get browser language
     */
    public static function getBrowserLanguage()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        else
            return Yii::app()->sourceLanguage;
    }

    /**
     * Secure i18n ID
     *
     * @param string $sLang i18n ID
     * @return i18n ID return a valid language
     */
    public static function secureLanguage($i18nId)
    {
        return self::isValidLanguage($i18nId) ? $i18nId : Yii::app()->language;
    }

    /**
     * Verify if the i18n ID is valid
     *
     * @param string $i18nId i18n ID
     * @return bool
     */
    public static function isValidLanguage($i18nId)
    {
        return in_array($i18nId, BSiteI18n::model()->getI18nIds());
    }

    /**
     * Set language
     *
     * @param string $i18nId i18n ID
     * @param bool $secure verify the i18n ID and correct it if needed
     */
    public static function setLanguage($i18nId, $secure = true)
    {
        $i18nId = $secure ? self::secureLanguage($i18nId) : $i18nId;
        self::setCookieLanguage($i18nId, false);
        self::setAppLanguage($i18nId, false);
        self::setUserLanguage($i18nId, false);
    }

    /**
     * Set cookie language
     *
     * @param string $i18nId i18n ID
     * @param bool $secure verify the i18n ID and correct it if needed
     */
    public static function setCookieLanguage($i18nId, $secure = true)
    {
        $i18nId = $secure ? self::secureLanguage($i18nId) : $i18nId;
        $cookie = new CHttpCookie('language', $i18nId);
        $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
        Yii::app()->request->cookies['language'] = $cookie;
    }

    /**
     * Set app language
     *
     * @param string $i18nId i18n ID
     * @param bool $secure verify the i18n ID and correct it if needed
     */
    public static function setAppLanguage($i18nId, $secure = true)
    {
        $i18nId = $secure ? self::secureLanguage($i18nId) : $i18nId;
        Yii::app()->language = $i18nId;
    }

    /**
     * Set user language
     *
     * @param string $i18nId i18n ID
     * @param bool $secure verify the i18n ID and correct it if needed
     */
    public static function setUserLanguage($i18nId, $secure = true)
    {
        $i18nId = $secure ? self::secureLanguage($i18nId) : $i18nId;
        Yii::app()->user->setState('language', $i18nId);
    }
}