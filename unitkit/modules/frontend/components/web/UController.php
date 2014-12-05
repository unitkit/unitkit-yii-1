<?php

/**
 * @see BBaseController
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UController extends UBaseController
{
    /**
     *
     * @var string The default layout for the controller view.
     */
    public $layout = '//../modules/frontend/views/layouts/base';

    /**
     * @see CController::init()
     */
    public function init()
    {
        $this->initLanguage();
        $this->autoRedirect();
    }

    /**
     * Auto redirect
     */
    public function autoRedirect() {
        if (Yii::app()->request->requestUri === '/') {
            $this->redirect('/'.Yii::app()->language, true, 301);
        }
    }

    /**
     * Initialization of language
     */
    protected function initLanguage()
    {
        $i18nId = null;
        if (isset($_POST['language'])) { // update language
            $i18nId = ULanguagesApp::secureLanguage($_POST['language']);
            $this->redirect($_POST[$i18nId]);
        } elseif (isset($_GET['language'])) {
            $i18nId = ULanguagesApp::secureLanguage($_GET['language']);
        } else {
            if (Yii::app()->user->hasState('language')) {
                $i18nId = ULanguagesApp::secureLanguage(Yii::app()->user->getState('language'));
            } elseif (isset(Yii::app()->request->cookies['language'])) {
                $i18nId = ULanguagesApp::secureLanguage(Yii::app()->request->cookies['language']->value);
            } else {
                $i18nId = ULanguagesApp::secureLanguage(ULanguagesApp::getBrowserLanguage());
            }
            $_GET['language'] = $i18nId;
        }
        ULanguagesApp::setLanguage($i18nId);
    }
}