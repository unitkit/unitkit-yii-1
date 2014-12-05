<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageListRowDataView extends UListRowItemDataView
{
    /**
     * Constructor
     *
     * @param CModel $data
     * @param mixed $pk
     */
    public function __construct($data, $pk)
    {
        $this->isTranslatable = true;
        $this->pk = array_merge($pk, $_GET);
        $this->data = $data;
        $this->items = array(
            isset($data->uCmsImageI18ns[0]) ? $data->uCmsImageI18ns[0]->title : '',
            $this->controller->getUploader('UCmsImage[file_path]')['uploader']->htmlOverview(
                $data,
                'file_path',
                array(
                    'type' => UUploader::OVERVIEW_IMAGE,
                )
            ),
        );
    }
}