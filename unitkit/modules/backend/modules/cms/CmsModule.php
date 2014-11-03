<?php

/**
 * Cms module
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class CmsModule extends CWebModule
{
    public
        $imagePathDest,
        $imageUrlDest,
        $albumPhotoPathDest,
        $albumPhotoUrlDest;

    public function init()
    {
        $this->setImport(array(
            'cms.models.*',
            'cms.components.*',
            'cms.components.containerType.*',
            'cms.components.edito.*',
            'cms.components.editoGroup.*',
            'cms.components.image.*',
            'cms.components.layout.*',
            'cms.components.pageContainer.*',
            'cms.components.pageContent.*',
            'cms.components.pageContentEdito.*',
            'cms.components.pageContentWidget.*',
            'cms.components.widget.*',
            'cms.components.social.*',
            'cms.components.news.*',
            'cms.components.newsGroup.*',
            'cms.components.menu.*',
            'cms.components.menuGroup.*',
            'cms.components.album.*',
            'cms.components.albumPhoto.*',
        ));

        $this->initUploader();
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

    /**
     * Init uploader components
     */
    protected function initUploader()
    {
        // cms image
        BCmsImage::$upload['file_path']['pathDest'] = $this->imagePathDest;
        BCmsImage::$upload['file_path']['urlDest'] = $this->imageUrlDest;

        // cms album photo
        BCmsAlbumPhoto::$upload['file_path']['pathDest'] = $this->albumPhotoPathDest;
        BCmsAlbumPhoto::$upload['file_path']['urlDest'] = $this->albumPhotoUrlDest;
    }
}