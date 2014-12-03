<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class I18nTranslateDataView extends BTranslateDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModels
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     * @param CController $controller
     */
    public function __construct($data, $relatedData, $pk, $isSaved, &$controller)
    {
        $this->id = 'bI18nI18nTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BI18nI18n::model();

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(
            new BItemField(array(
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false
                )
            ))
        );
    }
}