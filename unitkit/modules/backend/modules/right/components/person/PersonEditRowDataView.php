<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonEditRowDataView extends BEditRowItemDataView
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
                'model' => $datas['BPerson'],
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('email')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('first_name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('last_name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('activated')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'validated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('validated')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BPerson']->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $datas['BPerson']->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($datas['BPerson']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        // new BItemField(array(
        // 'model' => $datas['BPerson'],
        // 'attribute' => 'updated_at',
        // 'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $datas['BPerson']->updated_at, 'yyyy-MM-dd hh:mm:ss'
        // ))
        // )),
                );
    }
}