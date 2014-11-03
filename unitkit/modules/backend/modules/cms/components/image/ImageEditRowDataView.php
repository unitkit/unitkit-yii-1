<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageEditRowDataView extends BEditRowItemDataView
{
    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     */
    public function __construct($datas, $relatedDatas, $pk)
    {
        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $datas;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsImageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsImageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsImage'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsImage[file_path]')['uploader']->htmlUploader(
                    $datas['BCmsImage'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => BUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                    )
                )
            )),
        );
    }
}