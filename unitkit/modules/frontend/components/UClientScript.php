<?php

/**
 * @see UBaseClientScript
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UClientScript extends UBaseClientScript
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
        '/vendor/bower/bootstrap/dist/css/bootstrap.min.css' => true,
    );

    /**
     * Common script files to include
     *
     * @var mixed
     */
    protected $_genericScriptFiles = array(
        '/vendor/bower/jquery/dist/jquery.js' => true,
        '/vendor/bower/bootstrap/dist/js/bootstrap.min.js' => true,
        '/vendor/bower/blockui/jquery.blockUI.js' => true,
        '/unitkit/js/jquery.unitkit.tools.js' => true,
        '/unitkit/js/jquery.unitkit.app.js' => true,
        '/js/jquery.unitkit.app.Frontend.js' => true
    );

    protected function registerAppLanguageCoreScript(){}
}