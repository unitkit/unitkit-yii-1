<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupEditRowDataView extends BEditRowItemDataView
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
                'model' => $datas['BVariableGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariableGroupI18n']->getAttributeLabel('name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BVariableGroup'],
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariableGroup']->getAttributeLabel('code')
                )
            ))
        // new BItemField(array(
        // 'model' => $datas['BVariableGroup'],
        // 'attribute' => 'created_at',
        // 'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $datas['BVariableGroup']->created_at, 'yyyy-MM-dd hh:mm:ss'
        // ))
        // )),
        // new BItemField(array(
        // 'model' => $datas['BVariableGroup'],
        // 'attribute' => 'updated_at',
        // 'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $datas['BVariableGroup']->updated_at, 'yyyy-MM-dd hh:mm:ss'
        // ))
        // )),
                );
    }
}