<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UWidgetCmsCarousel extends CWidget
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
        $this->_models = UCmsAlbumPhoto::model()
            ->with('uCmsAlbumPhotoI18n')
            ->findAllByAttributes(array('u_cms_album_id' => $this->album_id));
    }

    public function run()
    {
        $html = '
            <div id="'.$this->container_id.'" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#'.$this->container_id.'" data-slide-to="0" class="active"></li>
                    <li data-target="#'.$this->container_id.'" data-slide-to="1"></li>
                    <li data-target="#'.$this->container_id.'" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner" role="listbox">';
        $i = 0;
        foreach($this->_models as $photo) {
            $html .= '
                    <div class="item '.($i == 0 ? 'active' : '').'">
                        <img  src="'.Yii::app()->getModule('frontend')->albumPhotoUrlDest.'/lg/'.$photo->file_path.'" />
                    </div>';
            ++$i;
        }
        $html .= '
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#'.$this->container_id.'" data-slide="prev" role="button">
                    <span class="icon-prev"></span>
                </a>
                <a class="right carousel-control" href="#'.$this->container_id.'" data-slide="next" role="button">
                    <span class="icon-next"></span>
                </a>
            </div>';

        echo $html;
    }
}