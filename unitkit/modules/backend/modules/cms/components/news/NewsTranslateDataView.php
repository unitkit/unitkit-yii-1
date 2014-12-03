<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsTranslateDataView extends BTranslateDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModels
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsNewsNewsTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BCmsNewsI18n::model();

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(
            new BItemField(array(
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'attribute' => 'content',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm advanced-textarea',
                    'id' => false,
                )
            )),
        );
    }
}