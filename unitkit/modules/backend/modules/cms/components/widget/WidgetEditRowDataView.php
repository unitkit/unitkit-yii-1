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
                'model' => $data['BCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );
    }
}