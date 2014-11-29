<?php

/**
 * This class manages language in the app
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BLanguagesApp extends BBaseLanguagesApp
{
    /**
     * @see BBaseLanguagesApp::isValidLanguage($i18nId)
     */
    public static function isValidLanguage($i18nId)
    {
        return in_array($i18nId, BSiteI18n::model()->getI18nIds(false, true));
    }
}