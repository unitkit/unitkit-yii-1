<?php
$html = '<?php

/**
 * Module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ' . unitkitGenerator::underscoredToUpperCamelcase($datas['module']) . 'Module extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            \'' . $datas['module'] . '.models.*\',
            \'' . $datas['module'] . '.components.*\',
            \'' . $datas['module'] . '.components.web.dataViews.*\',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action)) {
            return true;
        } else {
            return false;
        }
    }
}';
return $html;