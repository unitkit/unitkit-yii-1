<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BWidgetCmsAlbum extends CWidget
{
    /**
     * Cms album ID
     *
     * @var int
     */
    public $id;

    /**
     * List of album ID
     *
     * @var int
     */
    public $ids;

    /**
     * Number of columns
     *
     * @var int
     */
    public $cols = 4;

    protected $_models;
    protected $_isList;

    public function init()
    {
        $this->_isList = is_array($this->ids);

        $this->_models = BCmsAlbumPhoto::model()
            ->with('bCmsAlbumPhotoI18n', 'bCmsAlbumI18n')
            ->findAllByAttributes(
                array('b_cms_album_id' => $this->_isList ? $this->ids : $this->id),
                $this->_isList ? array('order' => 'bCmsAlbumI18n.b_cms_album_id') : array()
            );

        if($this->cols < 1 || ! is_numeric($this->cols)) {
            $this->cols = 4;
        }
    }

    public function run()
    {
        if (! $this->_isList) {
            $i = 0;
            $count = count($this->_models);
            $countPrev = $count - 1;

            $html = '<section>';
            foreach ($this->_models as $photo) {
                if ($i % $this->cols == 0) {
                    $html .= '<div class="row">';
                }
                $html .= '
                <div class="col-xs-6 col-md-3">
                   <a href="' . Yii::app()->getModule('frontend')->albumPhotoUrlDest . '/lg/' . $photo->file_path . '" class="thumbnail">
                       <img src="' . Yii::app()->getModule('frontend')->albumPhotoUrlDest . '/sm/' . $photo->file_path . '" width="100" alt="" />
                   </a>
                </div>';
                if ((($i + 1) % $this->cols == 0 && ($i != 0 || $this->cols == 1)) || $i == $countPrev) {
                    $html .= '</div>';
                }
                ++$i;
            }
            $html .= '</section>';
        } else {
            $albums = array();
            foreach ($this->_models as $photo) {
                $albums[$photo->b_cms_album_id][] = $photo;
            }

            $html = '';
            foreach ($albums as $album) {
                $i = 0;
                $count = count($album);
                $countPrev = $count - 1;

                $html .= '
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">'.$album[0]->bCmsAlbumI18n->title.'</h2>
                    <hr>
                </div>
                <section>';
                foreach ($album as $photo) {
                    if ($i % $this->cols == 0) {
                        $html .= '<div class="row">';
                    }
                    $html .= '
                    <div class="col-xs-6 col-md-3">
                       <a href="' . Yii::app()->getModule('frontend')->albumPhotoUrlDest . '/lg/' . $photo->file_path . '" class="thumbnail">
                           <img src="' . Yii::app()->getModule('frontend')->albumPhotoUrlDest . '/sm/' . $photo->file_path . '" alt="" />
                       </a>
                    </div>';
                    if ((($i + 1) % $this->cols == 0 && ($i != 0 || $this->cols == 1)) || $i == $countPrev) {
                        $html .= '</div>';
                    }
                    ++$i;
                }
                $html .= '</section>';
            }
        }

        echo $html;
    }
}