<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonListRowDataView extends BListRowItemDataView
{

    /**
     * Constructor
     *
     * @param CModel $data
     * @param mixed $pk
     */
    public function __construct($data, $pk)
    {
        $this->pk = $pk;
        $this->items = array(
            $data->email,
            $data->first_name,
            $data->last_name,
            BHtml::activeCheckBox($data, 'activated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            BHtml::activeCheckBox($data, 'validated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            isset($data->bI18nI18ns[0]) ? $data->bI18nI18ns[0]->name : '',
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data->created_at, 'yyyy-MM-dd hh:mm:ss'))
        );
    }
}