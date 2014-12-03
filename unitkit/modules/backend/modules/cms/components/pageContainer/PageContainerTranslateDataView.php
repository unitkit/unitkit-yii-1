<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerTranslateDataView extends BTranslateDataView
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
        $this->id = 'bCmsPagePageContainerTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BCmsPageI18n::model();

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
                'model' => 'BCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'attribute' => 'slug',
                'model' => 'BCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm active-slug',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'attribute' => 'html_title',
                'model' => 'BCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'attribute' => 'html_description',
                'model' => 'BCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'attribute' => 'html_keywords',
                'model' => 'BCmsPageI18n',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
            new BItemField(array(
                'label' => B::t('backend', BCmsPage::model()->tableName().':pageContainers'),
                'value' => $this->controller->bRenderPartial(
                    'translate/_container',
                    array('dataView' => new PageContainerTranslateContainersArrayRowDataView($this->data, $this->relatedData)),
                    true
                )
            )),
        );
    }
}