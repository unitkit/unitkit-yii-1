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
            'cms.components.web.dataViews.*',
            'cms.components.web.dataViews.containerType.*',
            'cms.components.web.dataViews.image.*',
            'cms.components.web.dataViews.layout.*',
            'cms.components.web.dataViews.pageContainer.*',
            'cms.components.web.dataViews.pageContent.*',
            'cms.components.web.dataViews.pageContentWidget.*',
            'cms.components.web.dataViews.widget.*',
            'cms.components.web.dataViews.social.*',
            'cms.components.web.dataViews.news.*',
            'cms.components.web.dataViews.newsGroup.*',
            'cms.components.web.dataViews.menu.*',
            'cms.components.web.dataViews.menuGroup.*',
            'cms.components.web.dataViews.album.*',
            'cms.components.web.dataViews.albumPhoto.*',
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
        UCmsImage::$upload['file_path']['pathDest'] = $this->imagePathDest;
        UCmsImage::$upload['file_path']['urlDest'] = $this->imageUrlDest;

        // cms album photo
        UCmsAlbumPhoto::$upload['file_path']['pathDest'] = $this->albumPhotoPathDest;
        UCmsAlbumPhoto::$upload['file_path']['urlDest'] = $this->albumPhotoUrlDest;
    }
}