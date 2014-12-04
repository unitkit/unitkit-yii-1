<?php

/**
 * @see CClientScript
 * @author Kevin Walter
 * @version 1.0
 */
class UBaseClientScript extends CClientScript
{

    /**
     * Path of generic css file
     *
     * @var string
     */
    protected static $_genericCssFileCache = './cache/css/generic.css';

    /**
     * Path of generic script file
     *
     * @var string
     */
    protected static $_genericScriptFileCache = './cache/js/generic.js';

    /**
     * Prefix file name
     *
     * @var string
     */
    protected static $_prefixFileName = '';

    /**
     * Array of i18n ID
     *
     * @var array
     */
    protected $_i18nIds;

    /**
     * Common css files to include
     *
     * @var array
     */
    protected $_genericCssFiles = array();

    /**
     * Common script files to include
     *
     * @var array
     */
    protected $_genericScriptFiles = array();

    /**
     * Dynamic script files to include
     *
     * @var array
     */
    protected $_dynamicScriptFiles = array();

    /**
     * Dynamic css files to include
     *
     * @var array
     */
    protected $_dynamicCssFiles = array();

    /**
     * Dynamic script to include
     *
     * @var array
     */
    protected $_dynamicScript = array();

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // default configuration
        $this->corePackages = array();
        $this->coreScriptPosition = CClientScript::POS_END;
        $this->defaultScriptFilePosition = CClientScript::POS_END;

        // get array of i18n ID
        $this->_i18nIds = USiteI18n::model()->getI18nIds();

        // register generic scripts
        $this->registerGenericCssFiles();
        $this->registerGenericScriptFiles();
        $this->registerAppCrudCoreScripts();

        // register script
        if (B_APP_ENV != B_DEV_ENV)
            $this->refactorGeneric();
    }

    /**
     * @see CClientScript::render()
     */
    public function render(&$output)
    {
        foreach ($this->_dynamicScriptFiles as $path) {
            $this->registerScriptFile($path);
        }

        foreach ($this->_dynamicCssFiles as $path) {
            $this->registerCssFile($path);
        }

        foreach ($this->_dynamicScript as $id => $script) {
            $this->registerScript($id, $script);
        }

        parent::render($output);
    }

    /**
     * Render dynamic scripts
     */
    public function renderDynamicScripts()
    {
        $scriptFiles = array();
        foreach ($this->_dynamicScriptFiles as $path) {
            $scriptFiles[] = $path;
        }

        $cssFiles = array();
        foreach ($this->_dynamicCssFiles as $path) {
            $cssFiles[] = $path;
        }

        foreach ($this->_dynamicCssFiles as $path) {
            $this->registerCssFile($path);
        }

        return array(
            'scriptFiles' => $scriptFiles,
            'cssFiles' => $cssFiles,
            'scripts' => $this->_dynamicScript
        );
    }

    /**
     * Render dynamic script
     *
     * @param $id Script ID
     * @return array
     */
    public function renderDynamicScript($id)
    {
        return array(
            'scripts' => isset($this->_dynamicScript[$id]) ? $this->_dynamicScript[$id] : ''
        );
    }

    /**
     * Register dynamic script file
     *
     * @param string $path
     * @return UBaseClientScript
     */
    public function registerDynamicScriptFile($path)
    {
        $this->_dynamicScriptFiles[] = $path;
        return $this;
    }

    /**
     * Register dynamic css file
     *
     * @param string $path
     * @return UBaseClientScript
     */
    public function registerDynamicCssFile($path)
    {
        $this->_dynamicCssFiles[] = $path;
        return $this;
    }

    /**
     * Register dynamic script
     *
     * @param string $id Dynamic script ID
     * @param string $script Script
     * @return UBaseClientScript
     */
    public function registerDynamicScript($id, $script)
    {
        $this->_dynamicScript[$id] = $script;
        return $this;
    }

    /**
     * Register core script of app
     */
    protected function registerAppCrudCoreScripts()
    {
        $this->registerAppLanguageCoreScript();
    }

    /**
     * Register language scripts
     */
    protected function registerAppLanguageCoreScript()
    {
        $script = '';
        switch (Yii::app()->language) {
            case 'fr':
                $script .= '$.datepicker.setDefaults($.datepicker.regional[\'fr\']);';
                break;
            case 'de':
                $script .= '$.datepicker.setDefaults($.datepicker.regional[\'de\']);';
                break;
            case 'es':
                $script .= '$.datepicker.setDefaults($.datepicker.regional[\'es\']);';
                break;
        }

        if ($script !== '')
            $this->registerScript('bLanguageCoreScript', $script);
    }

    /**
     * Register generic css files
     */
    protected function registerGenericCssFiles()
    {
        // register css files
        foreach ($this->_genericCssFiles as $path => $combine) {
            $this->registerCssFile($path);
        }
    }

    /**
     * Register generic script files
     */
    protected function registerGenericScriptFiles()
    {
        // register script files
        foreach ($this->_genericScriptFiles as $path => $combine) {
            $this->registerScriptFile($path);
        }
    }

    /**
     * Refactor generic scripts
     */
    protected function refactorGeneric()
    {
        $this->refactorScriptFiles($this->_genericScriptFiles, static::$_genericScriptFileCache);
        $this->refactorCssFiles($this->_genericCssFiles, static::$_genericCssFileCache, static::$_prefixFileName);
    }

    /**
     * Refactor css files
     * $sources files are combined
     *
     * @param mixed $sources array of sources files
     * @param string $destination path of destination file
     * @param string $imgPrefix prefix of images
     */
    public function refactorCssFiles($sources, $destination, $imgPrefix)
    {
        $cssFiles = array();
        foreach ($sources as $path => $combine) {
            if ($combine) {
                $cssFiles[] = $_SERVER['DOCUMENT_ROOT'] . $path;
                $this->scriptMap[basename($path)] = $destination;
            }
        }

        $cssPathFileDest = $_SERVER['DOCUMENT_ROOT'] . $destination;

        if (! file_exists($cssPathFileDest)) {
            $this->combineCssFiles($cssFiles, $cssPathFileDest, $imgPrefix);
        }
    }

    /**
     * Refactor script files
     * $sources files are combined and compressed
     *
     * @param mixed $sources array of sources files
     * @param string $destination path of destination file
     */
    public function refactorScriptFiles($sources, $destination)
    {
        $scriptFiles = array();
        foreach ($sources as $path => $combine) {
            if ($combine) {
                $scriptFiles[] = $_SERVER['DOCUMENT_ROOT'] . $path;
                $this->scriptMap[basename($path)] = $destination;
            }
        }

        $scriptPathFileDest = $_SERVER['DOCUMENT_ROOT'] . $destination;
        if (! file_exists($scriptPathFileDest)) {
            $this->combineScriptFiles($scriptFiles, $scriptPathFileDest);
            $scriptContent = EScriptBoost::minifyJs(file_get_contents($scriptPathFileDest));
            file_put_contents($scriptPathFileDest, $scriptContent);
        }
    }

    /**
     * Combine css files
     *
     * @param mixed $sources array of sources files
     * @param string $destination path of destination file
     * @param string $imgPrefix prefix of images
     */
    public function combineCssFiles($sources, $destination, $imgPrefix)
    {
        $pathParts = pathinfo($destination);
        $pathImgCache = $pathParts['dirname'] . '/../images';
        $cssPathImgCache = '../images';

        $imgFileBuffer = array();
        $nbImg = 0;
        $cssContent = '';

        foreach ($sources as $file) {
            $pFile = pathinfo($file);
            $buffer = file_get_contents($file);
            $arPreg = array();
            preg_match_all('#url\("{0,1}\'{0,1}([^"\')]*)"{0,1}\'{0,1}\)#', $buffer, $arPreg);

            $arReplaced = array();
            foreach ($arPreg[1] as $imgPathForCss) {
                $pImg = pathinfo($imgPathForCss);

                if ($pImg['dirname'][0] == '/')
                    $rPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $pImg['dirname'] . '/' . $pImg['basename'];
                else
                    $rPath = realpath($pFile['dirname'] . '/' . $pImg['dirname']) . '/' . $pImg['basename'];

                if (! array_key_exists($rPath, $imgFileBuffer)) {
                    $nbImg ++;
                    $imgFileBuffer[$rPath] = $imgPrefix . $nbImg . '.' . $pImg['extension'];
                    copy($rPath, $pathImgCache . '/' . $imgFileBuffer[$rPath]);
                }

                if (empty($arReplaced[$imgPathForCss])) {
                    $buffer = str_replace($imgPathForCss, $cssPathImgCache . '/' . $imgFileBuffer[$rPath], $buffer);
                    $arReplaced[$imgPathForCss] = 1;
                }
            }

            $cssContent .= $buffer;
        }
        file_put_contents($destination, $cssContent);
    }

    /**
     * Combine script files
     *
     * @param mixed $sources array of sources files
     * @param string $destination path of destination file
     */
    public function combineScriptFiles($sources, $destination)
    {
        $ctFiles = '';
        foreach ($sources as $file) {
            $ctFiles .= file_get_contents($file);
        }
        file_put_contents($destination, $ctFiles);
    }

    /**
     * Get default message of openBlob list
     */
    public function getAppCrudMessages()
    {
        return "
		$.unitkit.app.defaultMessage.modalConfirmation = '" . addslashes(Unitkit::t('unitkit', 'modal_confirmation')) . "';
		$.unitkit.app.defaultMessage.modalRemoveAll = '" . addslashes(Unitkit::t('unitkit', 'modal_remove_selected')) . "';
		$.unitkit.app.defaultMessage.modalBtnConfirm = '" . addslashes(Unitkit::t('unitkit', 'btn_confirm')) . "';
		$.unitkit.app.defaultMessage.modalBtnCancel = '" . addslashes(Unitkit::t('unitkit', 'btn_cancel')) . "';
		$.unitkit.app.defaultMessage.modalRemoveOne = '" . addslashes(Unitkit::t('unitkit', 'modal_remove_one')) . "';
		$.unitkit.app.defaultMessage.selectInputAdd = '" . addslashes(Unitkit::t('unitkit', 'select_input_add')) . "';
        $.unitkit.app.defaultMessage.selectInputUpdate = '" . addslashes(Unitkit::t('unitkit', 'select_input_update')) . "';
		";
    }

    /**
     * Register openBlob scripts of default view
     *
     * @param mixed $actions array('edit', 'translate') is an array of interface must be initialized
     * @param string $htmlContainer
     * @return UBaseClientScript
     */
    public function registerAppCrudViewCoreScripts($interfaces = array('list', 'edit', 'translate'), $htmlContainer = '')
    {
        $script = $this->getAppCrudMessages();

        if (in_array('list', $interfaces)) {
            $htmlContainer = ($htmlContainer != '') ? $htmlContainer . ' ' : '';

            $script .= "
			var list = new $.unitkit.app.List({
				main: '$htmlContainer.list:first',
				dynamic: '$htmlContainer.dynamic:first'
			});

			list.addAppSettings(new $.unitkit.app.Settings({
				main: '$htmlContainer.dynamic:first',
				list: list
			}));";

            if (in_array('edit', $interfaces)) {
                $script .= "
				list.addAppEdit(new $.unitkit.app.Edit({
					main: '$htmlContainer.dynamic:first',
					list: list
				}));";
            }

            if (in_array('translate', $interfaces)) {
                $script .= "
				list.addAppTranslate(new $.unitkit.app.Translate({
					main: '$htmlContainer.dynamic:first',
					list: list
				}));";
            }

            $script .= 'list.initEvents();';
        }

        $this->registerDynamicScript('bAppCrudCoreScript', $script);

        return $this;
    }
}