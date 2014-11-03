<?php

/**
 * @see BBaseClientScript
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BClientScript extends BBaseClientScript
{
    /**
     * Path of generic css file
     *
     * @var string
     */
    protected static $_genericCssFileCache = '/cache/css/styles.css';

    /**
     * Path of generic script file
     *
     * @var string
     */
    protected static $_genericScriptFileCache = '/cache/js/script.js';

    /**
     * Prefix file name
     *
     * @var string
     */
    protected static $_prefixFileName = 'im_1';

    /**
     * Common css files to include
     *
     * @var mixed
     */
    protected $_genericCssFiles = array(
        '/vendor/bower/bootstrap/dist/css/bootstrap.css' => true,
        '/vendor/bower/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css' => true,
        '/vendor/bower/jquery-ui/themes/base/jquery-ui.css' => true,
        '/vendor/overload/select2/select2.css' => true,
        '/vendor/overload/select2/select2-bootstrap.css' => true,
        '/css/backend.base.css' => true
    );

    /**
     * Common script files to include
     *
     * @var mixed
     */
    protected $_genericScriptFiles = array(
        '/vendor/bower/jquery/dist/jquery.js' => true,
        '/vendor/bower/jquery-ui/ui/jquery-ui.js' => true,
        '/vendor/bower/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.js' => true,
        '/vendor/bower/jquery-ui/ui/i18n/jquery.ui.datepicker-fr.js' => true,
        '/vendor/bower/jquery-ui/ui/i18n/jquery.ui.datepicker-de.js' => true,
        '/vendor/bower/jquery-ui/ui/i18n/jquery.ui.datepicker-es.js' => true,
        '/vendor/bower/jquery-ui/ui/i18n/jquery.ui.datepicker-en-GB.js' => true,
        '/vendor/bower/bootstrap/dist/js/bootstrap.min.js' => true,
        '/vendor/bower/browser/bowser.js' => true,
        '/vendor/bower/blockui/jquery.blockUI.js' => true,
        '/vendor/overload/ckeditor/ckeditor.js' => false,
        '/vendor/overload/ckeditor/adapters/ckeditor.jquery.js' => false,
        '/vendor/manual/swfupload/js/swfupload.js' => true,
        '/vendor/overload/select2/select2.js' => true,
        '/b/js/jquery.b.tools.js' => true,
        '/b/js/jquery.b.app.js' => true,
        '/b/js/jquery.b.app.Edit.js' => true,
        '/b/js/jquery.b.app.List.js' => true,
        '/b/js/jquery.b.app.Translate.js' => true,
        '/b/js/jquery.b.app.Settings.js' => true,
        '/b/js/jquery.b.app.Uploader.js' => true,
        '/b/js/jquery.b.app.Modal.js' => true,
        '/js/jquery.b.app.Backend.js' => true
    );

    public function init()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->registerDynamicScript(
                'bApplicationLanguage',
                "$('.current-language').replaceWith('" . BNavBarData::buildLanguageSelector() . "');
				$.b.application.initChangeLanguageActionEvent();"
            );
        }
        parent::init();
    }
}