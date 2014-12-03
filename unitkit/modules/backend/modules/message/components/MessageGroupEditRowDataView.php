<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageGroupEditRowDataView extends BEditRowItemDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related datas
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
    {
        // primary key
        $this->pk = $pk;

        // datas
        $this->data = $data;

        // related datas
        $this->relatedData = $relatedData;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMessageGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMessageGroupI18n']->getAttributeLabel('name')
                )
            ))
        // new BItemField(array(
        // 'model' => $datas['BMessageGroup'],
        // 'attribute' => 'created_at',
        // 'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $datas['BMessageGroup']->created_at, 'yyyy-MM-dd hh:mm:ss'
        // ))
        // )),
        // new BItemField(array(
        // 'model' => $datas['BMessageGroup'],
        // 'attribute' => 'updated_at',
        // 'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $datas['BMessageGroup']->updated_at, 'yyyy-MM-dd hh:mm:ss'
        // ))
        // )),
                );
    }
}