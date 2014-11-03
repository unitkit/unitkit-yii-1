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
     * @param array $datas Array of CModels
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     * @param CController $controller
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved, &$controller)
    {
        $this->id = 'bI18nI18nTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BI18nI18n::model();

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

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