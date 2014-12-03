<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoEditRowDataView extends BEditRowItemDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
    {
        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsAlbumPhotoI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsAlbumPhotoI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsAlbumPhoto'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsAlbumPhoto[file_path]')['uploader']->htmlUploader(
                    $data['BCmsAlbumPhoto'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => BUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                        'html_options' => array('style' => 'max-width:350px'),
                    )
                )
            )),
        );
    }
}