<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditRowDataView extends UEditRowItemDataView
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
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'u_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array('name' => 'UCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UCmsPage']->u_cms_layout_id) ? UCmsLayoutI18n::model()->findByPk(array(
                        'u_cms_layout_id' => $data['UCmsPage']->u_cms_layout_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            )),
        );
    }
}