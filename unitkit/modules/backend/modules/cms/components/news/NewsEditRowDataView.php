<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsEditRowDataView extends BEditRowItemDataView
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
                'model' => $datas['BCmsNews'],
                'attribute' => 'b_cms_news_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array('name' => 'BCmsNewsGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BCmsNews']->b_cms_news_group_id) ? BCmsNewsGroupI18n::model()->findByPk(array(
                                    'b_cms_news_group_id' => $datas['BCmsNews']->b_cms_news_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('newsGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('newsGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsNewsI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsNewsI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsNews'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm'
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsNews'],
                'attribute' => 'published_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm date-picker',
                    'placeholder' => $datas['BCmsNews']->getAttributeLabel('published_at'),
                )
            )),
        );
    }
}