<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumEditRowDataView extends BEditRowItemDataView
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
                'model' => $data['BCmsAlbumI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsAlbumI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsAlbum'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $data['BCmsAlbum']->created_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),
            new BItemField(array(
                'model' => $data['BCmsAlbum'],
                'attribute' => 'updated_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $data['BCmsAlbum']->updated_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),
        );
    }
}