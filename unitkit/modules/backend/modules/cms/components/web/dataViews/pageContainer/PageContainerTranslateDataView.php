<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerTranslateDataView extends UTranslateDataView
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
        $this->id = 'uCmsPagePageContainerTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = UCmsPageI18n::model();

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
                'model' => 'UCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new UItemField(array(
                'attribute' => 'slug',
                'model' => 'UCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm active-slug',
                    'id' => false,
                )
            )),
            new UItemField(array(
                'attribute' => 'html_title',
                'model' => 'UCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new UItemField(array(
                'attribute' => 'html_description',
                'model' => 'UCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new UItemField(array(
                'attribute' => 'html_keywords',
                'model' => 'UCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new UItemField(array(
                'label' => Unitkit::t('backend', UCmsPage::model()->tableName().':pageContainers'),
                'value' => $this->controller->bRenderPartial(
                    'translate/_container',
                    array('dataView' => new PageContainerTranslateContainersArrayRowDataView($this->data, $this->relatedData)),
                    true
                )
            )),
        );
    }
}