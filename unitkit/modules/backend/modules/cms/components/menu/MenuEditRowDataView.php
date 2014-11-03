<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuEditRowDataView extends BEditRowItemDataView
{
    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     */
    public function __construct($datas, $relatedDatas, $pk)
    {
        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $datas;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'b_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array('name' => 'BCmsMenuGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BCmsMenu']->b_cms_menu_group_id) ? BCmsMenuGroupI18n::model()->findByPk(array(
                                    'b_cms_menu_group_id' => $datas['BCmsMenu']->b_cms_menu_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('menuGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('menuGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsMenu']->getAttributeLabel('rank'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenuI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsMenuI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenuI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm active-slug',
                    'placeholder' => $datas['BCmsMenuI18n']->getAttributeLabel('url'),
                )
            )),
        );
    }
}