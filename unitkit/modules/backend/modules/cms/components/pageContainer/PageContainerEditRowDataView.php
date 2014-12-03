<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditRowDataView extends BEditRowItemDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
    {
        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // controller
        $controller = Yii::app()->controller;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array('name' => 'BCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BCmsPage']->b_cms_layout_id) ? BCmsLayoutI18n::model()->findByPk(array(
                                    'b_cms_layout_id' => $data['BCmsPage']->b_cms_layout_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                )
            )),
        );
    }
}