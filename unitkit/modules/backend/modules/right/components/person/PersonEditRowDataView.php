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
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('email')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('first_name')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('last_name')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('activated')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'validated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('validated')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BPerson']->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $data['BPerson']->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data['BPerson']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        );
    }
}