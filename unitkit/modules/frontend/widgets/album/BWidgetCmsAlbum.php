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
     * Number of columns
     *
     * @var int
     */
    public $cols = 4;

    protected $_models;

    public function init()
    {
        $this->_models = BCmsAlbumPhoto::model()
            ->with('bCmsAlbumPhotoI18n')
            ->findAllByAttributes(array('b_cms_album_id' => $this->id));

        if($this->cols < 1 || ! is_numeric($this->cols)) {
            $this->cols = 4;
        }
    }

    public function run()
    {
    	$i = 0;
    	$count = count($this->_models);
        $countPrev = $count - 1;

    	$html = '<section>';
        foreach($this->_models as $photo) {
            if ($i % $this->cols == 0) {
                $html .= '<div class="row">';
            }
            $html .= '
            <div class="col-xs-6 col-md-3">
    	       <a href="'.Yii::app()->getModule('frontend')->albumPhotoUrlDest.'/lg/'.$photo->file_path.'" class="thumbnail">
    	           <img src="'.Yii::app()->getModule('frontend')->albumPhotoUrlDest.'/sm/'.$photo->file_path.'" width="100" alt="" />
    	       </a>
    	    </div>';
            if (( ($i + 1) % $this->cols == 0 && ($i != 0 || $this->cols == 1) ) || $i == $countPrev) {
                $html .= '</div>';
            }
            ++$i;
        }
        $html .= '</section>';

        echo $html;
    }
}