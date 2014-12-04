<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UWidgetCmsMenu extends CWidget
{
    /**
     * ID of menu group
     *
     * @var int
     */
    public $id;

    /**
     * Brand name of menu
     *
     * @var string
     */
    public $brand;

    protected $_models;

    public function init()
    {
        $this->_models = UCmsMenu::model()->findMenuCache($this->id, Yii::app()->language);
    }

    public function run()
    {
        $siteI18n = USiteI18n::model()->getI18nIds(false, true);

    	$i = 0;
    	$count = count($this->_models);
        $countPrev = $count - 1;

    	$html = '
        <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">'.$this->brand.'</a>
            </div>
    	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">';

        foreach ($this->_models as $menu) {
            $html .= '<li><a href="'.$menu->uCmsMenuI18ns[0]->url.'">'.$menu->uCmsMenuI18ns[0]->name.'</a></li>';
        }

        if (count($siteI18n) > 1) {
            $html .= '<li class="languages">';
            foreach ($siteI18n as $i18nId) {
                $html .= '<a href="/' . $i18nId . '">' . UHtml::labelI18n($i18nId, true, false) . '</a>';
            }
            $html .= '</li>';
        }
        $html .= '
              </ul>
            </div>
          </div>
        </nav>';

        echo $html;
    }
}