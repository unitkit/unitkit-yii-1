<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetTranslateDataView extends UTranslateDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModels
     * @param array $relatedData Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     * @param CController $controller
     */
    public function __construct($data, $relatedData, $pk, $isSaved, &$controller)
    {
        // data view id
        $this->id = 'uCmsWidgetWidgetTranslate';

        // component title
        $this->title = Unitkit::t('unitkit', 'translate_title', array('{name}' => 'widget'));

        // page title
        $controller->pageTitle = $this->title;

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = UCmsWidgetI18n::model();

        // datas
        $this->data = $data;

        // related datas
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(
            new UItemField(array(
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
        );
    }
}