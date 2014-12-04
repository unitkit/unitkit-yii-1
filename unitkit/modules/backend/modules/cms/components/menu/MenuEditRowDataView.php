<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuEditRowDataView extends UEditRowItemDataView
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

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'u_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'UCmsMenuGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UCmsMenu']->u_cms_menu_group_id) ? UCmsMenuGroupI18n::model()->findByPk(array(
                                    'u_cms_menu_group_id' => $data['UCmsMenu']->u_cms_menu_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('menuGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('menuGroup/update'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsMenu']->getAttributeLabel('rank'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenuI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsMenuI18n']->getAttributeLabel('name'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenuI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm active-slug',
                    'placeholder' => $data['UCmsMenuI18n']->getAttributeLabel('url'),
                )
            )),
        );
    }
}