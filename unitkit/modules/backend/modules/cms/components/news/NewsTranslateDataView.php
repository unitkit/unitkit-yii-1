<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsTranslateDataView extends UTranslateDataView
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
        $this->id = 'uCmsNewsNewsTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = UCmsNewsI18n::model();

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(
            new UItemField(array(
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new UItemField(array(
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