<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginEditRowDataView extends BEditRowItemDataView
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
                'model' => $data['BAutoLogin'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BPerson[email]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BAutoLogin']->b_person_id) ? BPerson::model()->findByPk($data['BAutoLogin']->b_person_id)->email : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'bAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm date-picker',
                    'placeholder' => $data['BAutoLogin']->getAttributeLabel('expired_at')
                )
            )),
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data['BAutoLogin']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        );
    }
}