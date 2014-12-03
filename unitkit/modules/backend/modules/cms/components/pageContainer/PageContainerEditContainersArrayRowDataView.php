<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditContainersArrayRowDataView
{
    /**
     * Items
     *
     * @var array
     */
    public $items;

    public function __construct($index, &$data)
    {
        $controller = Yii::app()->controller;

        $this->items = array(
            new BItemField(array(
            	'value' => B::t('backend', 'cms_page_container_index').' '.$index
            )),
            new BItemField(array(
                'model' => $data['BCmsPageContents'][$index]->bCmsPageContentI18n,
                'attribute' => 'content',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'name' => 'BCmsPageContentsI18n['.$index.'][content]',
                    'class' => 'form-control input-sm advanced-textarea',
                    'data-ckeditorFilebrowserBrowseUrl' => Yii::app()->controller->createUrl('/cms/image'),
                    'data-ckeditorLanguage' => Yii::app()->language
                )
            ))
        );
    }
}