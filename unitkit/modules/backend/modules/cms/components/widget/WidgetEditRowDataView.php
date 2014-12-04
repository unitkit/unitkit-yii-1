<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetEditRowDataView extends UEditRowItemDataView
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
                'model' => $data['UCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );
    }
}