<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginListRowDataView extends UListRowItemDataView
{

    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {
        $this->pk = $pk;
        $this->items = array(
            $data->uPerson->fullName,
            $data->duration,
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data->expired_at, 'yyyy-MM-dd hh:mm:ss')),
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data->created_at, 'yyyy-MM-dd hh:mm:ss'))
        );
    }
}