<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerTranslateContainersArrayRowDataView
{
    /**
     * Items
     *
     * @var array
     */
    public $items;

    public $data;

    public function __construct(&$data, &$relatedData)
    {
        $controller = Yii::app()->controller;
        $this->data = $data;
        $this->relatedDatas = $relatedData;

        $this->items = array(
            new UItemField(array(
                'attribute' => 'content',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'data-ckeditorFilebrowserBrowseUrl' => Yii::app()->controller->createUrl('/cms/image'),
                    'data-ckeditorLanguage' => Yii::app()->language
                )
            ))
        );
    }
}