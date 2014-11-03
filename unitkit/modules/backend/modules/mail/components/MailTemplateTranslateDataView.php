<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateTranslateDataView extends BTranslateDataView
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
        $this->id = 'bMailTemplateMailTemplateTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BMailTemplateI18n::model();

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(
            new BItemField(array(
                'attribute' => 'object',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false
                )
            )),
            new BItemField(array(
                'attribute' => 'message',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm advanced-textarea',
                    'id' => false
                )
            ))
        );
    }
}