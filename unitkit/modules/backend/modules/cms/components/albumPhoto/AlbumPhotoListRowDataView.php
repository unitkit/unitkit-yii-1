<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoListRowDataView extends BListRowItemDataView
{
    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {
        $this->isTranslatable = true;
        $this->pk = $pk;
        $this->items = array(
            isset($data->bCmsAlbumPhotoI18ns[0]) ? $data->bCmsAlbumPhotoI18ns[0]->title : '',
            Yii::app()->controller->getUploader('BCmsAlbumPhoto[file_path]')['uploader']->htmlOverview(
                $data,
                'file_path',
                array(
                    'type' => BUploader::OVERVIEW_IMAGE,
                    'html_options' => array('style' => 'max-width:350px; max-height:100px;')
                )
            ),
        );
    }
}