<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetEditRowDataView extends BEditRowItemDataView
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

        // controller
        $controller = Yii::app()->controller;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );
    }
}