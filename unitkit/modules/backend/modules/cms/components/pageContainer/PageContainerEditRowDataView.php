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

        // controller
        $controller = Yii::app()->controller;

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advCombobox/',
                        array('name' => 'BCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BCmsPage']->b_cms_layout_id) ? BCmsLayoutI18n::model()->findByPk(array(
                                    'b_cms_layout_id' => $datas['BCmsPage']->b_cms_layout_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_description'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_keywords',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_keywords'),
                )
            )),
           /* new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $datas['BCmsPage']->created_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'updated_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $datas['BCmsPage']->updated_at, 'yyyy-MM-dd hh:mm:ss'
                ))
            )),*/
        );
    }
}