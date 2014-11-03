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

    public $datas;

    public function __construct(&$datas, &$relatedDatas)
    {
        $controller = Yii::app()->controller;
        $this->datas = $datas;
        $this->relatedDatas = $relatedDatas;

        $this->items = array(
            new BItemField(array(
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