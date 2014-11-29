<?php

/**
 * @see CController
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseController extends CController
{

    /**
     * @var string Prefix view of openBlob interface
     */
    public $bPrefixLayout = '//b';

    /**
     * @var array The breadcrumbs of the current page. The value of this property will
     *      be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     *      for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * @var array The value of this property will be assigned to fill view or layout
     */
    public $cmsPageContents = array();

    /**
     * @var string The CMS view
     */
    public $cmsView = 'index';

    /**
     * @var array Default roles used in default templates
     */
    protected $_defaultRoles = array();

    /**
     * @see CController::init()
     */
    public function init()
    {
        $this->initLanguage();
    }

    /**
     * @see CController::createUrl()
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if ($route === '') {
            $route = $this->getId() . '/' . $this->getAction()->getId();
        } elseif (strpos($route, '/') === false) {
            $route = $this->getId() . '/' . $route;
        }
        if ($route[0] !== '/' && ($module = $this->getModule()) !== null) {
            $route = $module->getId() . '/' . $route;
        } else {
            $route = '/' . Yii::app()->params['baseModuleApplication'] . $route;
        }

        return Yii::app()->createUrl(trim($route, '/'), $params, $ampersand);
    }

    /**
     * Get array of default roles
     * Each roles are associated to an default action used from the template
     */
    public function getDefaultRoles($value = null)
    {
        if (empty($this->_defaultRoles)) {
            $this->setDefaultRoles();
        }

        if ($value === null) {
            return $this->_defaultRoles;
        } elseif (isset($this->_defaultRoles[$value])) {
            return $this->_defaultRoles[$value];
        } else {
            return array(false);
        }
    }

    /**
     * Set default roles
     */
    public function setDefaultRoles()
    {
        $this->_defaultRoles = Yii::app()->rights->getDefaultRoles($this->id, $this->module->id);
    }

    /**
     * Initialization of menu
     */
    public function getNavBarData()
    {
        return new BNavBarData();
    }

    /**
     * Initialization of language
     */
    protected function initLanguage()
    {
        $i18nId = null;
        if (isset($_POST['language'])) { // update language
            $i18nId = BLanguagesApp::secureLanguage($_POST['language']);
            $this->redirect($_POST[$i18nId]);
        } elseif (isset($_GET['language'])) {
            $i18nId = BLanguagesApp::secureLanguage($_GET['language']);
        } else {
            if (Yii::app()->user->hasState('language')) {
                $i18nId = BLanguagesApp::secureLanguage(Yii::app()->user->getState('language'));
            } elseif (isset(Yii::app()->request->cookies['language'])) {
                $i18nId = BLanguagesApp::secureLanguage(Yii::app()->request->cookies['language']->value);
            } else {
                $i18nId = BLanguagesApp::secureLanguage(BLanguagesApp::getBrowserLanguage());
            }
        }
        BLanguagesApp::setLanguage($i18nId);
    }

    /**
     * The filter method for 'accessControl' filter.
     * This filter is a wrapper of {@link CAccessControlFilter}.
     * To use this filter, you must override {@link accessRules} method.
     *
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     */
    public function filterCmsPage($filterChain)
    {
        $filter = new BCmsPageFilter();
        $filter->setRules($this->cmsPageRules());
        $filter->filter($filterChain);
    }

    /**
     * Returns the cms page rules for this controller.
     *
     * @return array list of rules.
     */
    public function cmsPageRules()
    {
        return array();
    }

    /**
     * Select automatically the good render function
     *
     * @param string $view name of the view to be rendered. See {@link getViewFile} for details
     *        about how the view script is resolved.
     * @param array $data data to be extracted into PHP variables and made available to the view script
     * @param array $jsonParams parameters to be sent into JSON result (ajax context only)
     */
    public function dynamicRender($view, $data, $jsonParams = array())
    {
        if ( isset($_GET['api'])) {
            echo $this->bRenderPartial('api/'.$view, $data, true);
            Yii::app()->end();
        } else {
            $renderFunction = Yii::app()->request->isAjaxRequest ? 'bRenderPartial' : 'bRender';

            $html = $this->$renderFunction($view, $data, true);

            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array_merge(array(
                        'html' => $html,
                        'title' => $this->pageTitle,
                    ),
                    isset($_REQUEST['renderScript']) ? Yii::app()->clientScript->renderDynamicScripts() : array(),
                    $jsonParams
                ));
                Yii::app()->end();
            } else {
                echo $html;
            }
        }
    }

    /**
     * Renders a view.
     *
     * The named view refers to a PHP script (resolved via {@link getViewFile})
     * that is included by this method. If $data is an associative array,
     * it will be extracted as PHP variables and made available to the script.
     *
     * This method differs from {@link render()} in that it does not
     * apply a layout to the rendered result. It is thus mostly used
     * in rendering a partial view, or an AJAX response.
     *
     * @param string $view name of the view to be rendered. See {@link getViewFile} for details
     *        about how the view script is resolved.
     * @param array $data data to be extracted into PHP variables and made available to the view script
     * @param boolean $return whether the rendering result should be returned instead of being displayed to end users
     * @param boolean $processOutput whether the rendering result should be postprocessed using {@link processOutput}.
     * @param string $prefixView prefix layout
     * @return string the rendering result. Null if the rendering result is not required.
     * @throws CException if the view does not exist
     * @see getViewFile
     * @see processOutput
     * @see render
     */
    public function bRenderPartial($view, $data = null, $return = false, $processOutput = false, $prefixView = null)
    {
        if (($viewFile = $this->getViewFile($view)) !== false) {
            $output = $this->renderFile($viewFile, $data, true);
            if ($processOutput) {
                $output = $this->processOutput($output);
            }
            if ($return) {
                return $output;
            } else {
                echo $output;
            }
        } else {
            if ($prefixView === null) {
                $prefixView = $this->bPrefixLayout;
            }
            return $this->renderPartial($prefixView . '/' . $view, $data, $return, $processOutput);
        }
    }

    /**
     * Renders a view with a layout.
     *
     * This method first calls {@link renderPartial} to render the view (called content view).
     * It then renders the layout view which may embed the content view at appropriate place.
     * In the layout view, the content view rendering result can be accessed via variable
     * <code>$content</code>. At the end, it calls {@link processOutput} to insert scripts
     * and dynamic contents if they are available.
     *
     * By default, the layout view script is "protected/views/layouts/main.php".
     * This may be customized by changing {@link layout}.
     *
     * @param string $view name of the view to be rendered. See {@link getViewFile} for details
     *        about how the view script is resolved.
     * @param array $data data to be extracted into PHP variables and made available to the view script
     * @param boolean $return whether the rendering result should be returned instead of being displayed to end users.
     * @param string $prefixView prefix layout
     * @return string the rendering result. Null if the rendering result is not required.
     * @see renderPartial
     * @see getLayoutFile
     */
    public function bRender($view, $data = null, $return = false, $prefixView = null)
    {
        if ($this->beforeRender($view)) {
            if ($prefixView === null) {
                $prefixView = $this->bPrefixLayout;
            }
            $output = $this->bRenderPartial($view, $data, true, false, $prefixView);
            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false) {
                $output = $this->renderFile($layoutFile, array(
                    'content' => $output
                ), true);
            }
            $this->afterRender($view, $output);

            $output = $this->processOutput($output);

            if ($return) {
                return $output;
            } else {
                echo $output;
            }
        }
    }
}