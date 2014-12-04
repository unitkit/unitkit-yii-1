<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoListRowDataView extends UListRowItemDataView
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
            isset($data->uCmsAlbumPhotoI18ns[0]) ? $data->uCmsAlbumPhotoI18ns[0]->title : '',
            Yii::app()->controller->getUploader('UCmsAlbumPhoto[file_path]')['uploader']->htmlOverview(
                $data,
                'file_path',
                array(
                    'type' => UUploader::OVERVIEW_IMAGE,
                    'html_options' => array('style' => 'max-width:350px; max-height:100px;')
                )
            ),
        );
    }
}