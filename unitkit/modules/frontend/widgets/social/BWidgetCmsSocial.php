<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BWidgetCmsSocial extends CWidget
{
    protected $_models;

    public function init()
    {
    	$this->_models = BCmsSocial::model()->with('bCmsSocialI18n')->findAll('url <> ""');
    }

    public function run()
    {
        $html = '';
        foreach($this->_models as $model) {
            $html .= '<a href="'.$model->bCmsSocialI18n->url.'" target="_blank">'.$model->name.'</a> ';
        }
        $html .= '';

        echo $html;
    }
}