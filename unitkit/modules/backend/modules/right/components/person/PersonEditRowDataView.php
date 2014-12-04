<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonEditRowDataView extends UEditRowItemDataView
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
                'model' => $data['UPerson'],
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UPerson']->getAttributeLabel('email')
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UPerson']->getAttributeLabel('first_name')
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UPerson']->getAttributeLabel('last_name')
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UPerson']->getAttributeLabel('activated')
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'validated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UPerson']->getAttributeLabel('validated')
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UPerson']->default_language) ? UI18nI18n::model()->findByPk(array(
                        'u_i18n_id' => $data['UPerson']->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            )),
            new UItemField(array(
                'model' => $data['UPerson'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data['UPerson']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        );
    }
}