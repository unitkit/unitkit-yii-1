<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumListRowDataView extends UListRowItemDataView
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
            isset($data->uCmsAlbumI18ns[0]) ? $data->uCmsAlbumI18ns[0]->title : '',
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                $data->created_at, 'yyyy-MM-dd hh:mm:ss'
            )),
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                $data->updated_at, 'yyyy-MM-dd hh:mm:ss'
            )),
        );
    }
}