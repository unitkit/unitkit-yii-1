<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageEditRowDataView extends UEditRowItemDataView
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
            new UItemField(array(
                'model' => $data['UCmsImageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsImageI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsImage'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('UCmsImage[file_path]')['uploader']->htmlUploader(
                    $data['UCmsImage'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => UUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                    )
                )
            )),
        );
    }
}