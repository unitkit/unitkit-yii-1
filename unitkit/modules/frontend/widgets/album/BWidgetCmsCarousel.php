<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BWidgetCmsCarousel extends CWidget
{
    public $container_id;

    /**
     * Cms album ID
     * @var int
     */
    public $album_id;

    protected $_models;

    public function init()
    {
        $this->_models = BCmsAlbumPhoto::model()
            ->with('bCmsAlbumPhotoI18n')
            ->findAllByAttributes(array('b_cms_album_id' => $this->album_id));
    }

    public function run()
    {
        $html = '
            <div id="'.$this->container_id.'" class="carousel slide">
                <!-- Indicators -->
                <ol class="carousel-indicators hidden-xs">
                    <li data-target="#'.$this->container_id.'" data-slide-to="0" class="active"></li>
                    <li data-target="#'.$this->container_id.'" data-slide-to="1"></li>
                    <li data-target="#'.$this->container_id.'" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">';
        $i = 0;
        foreach($this->_models as $photo) {
            $html .= '
                    <div class="item '.($i == 0 ? 'active' : '').'">
                        <img class="img-responsive img-full" src="'.Yii::app()->getModule('frontend')->albumPhotoUrlDest.'/lg/'.$photo->file_path.'" />
                    </div>';
            ++$i;
        }
        $html .= '
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#'.$this->container_id.'" data-slide="prev">
                    <span class="icon-prev"></span>
                </a>
                <a class="right carousel-control" href="#'.$this->container_id.'" data-slide="next">
                    <span class="icon-next"></span>
                </a>
            </div>';

        echo $html;
    }
}