<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumEditRowDataView extends UEditRowItemDataView
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
                'model' => $data['UCmsAlbumI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsAlbumI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsAlbum'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $data['UCmsAlbum']->created_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),
            new UItemField(array(
                'model' => $data['UCmsAlbum'],
                'attribute' => 'updated_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $data['UCmsAlbum']->updated_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),
        );
    }
}