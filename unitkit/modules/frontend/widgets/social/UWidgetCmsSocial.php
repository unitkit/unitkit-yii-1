<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UWidgetCmsSocial extends CWidget
{
    protected $_models;

    public function init()
    {
    	$this->_models = UCmsSocial::model()->with('uCmsSocialI18n')->findAll('url <> ""');
    }

    public function run()
    {
        $html = '';
        foreach($this->_models as $model) {
            $html .= '<a href="'.$model->uCmsSocialI18n->url.'" target="_blank">'.$model->name.'</a> ';
        }
        $html .= '';

        echo $html;
    }
}