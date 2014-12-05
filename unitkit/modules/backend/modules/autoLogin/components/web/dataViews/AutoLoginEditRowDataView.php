<?php

/**
 * Data view of edit inline interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginEditRowDataView extends UEditRowItemDataView
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
                'model' => $data['UAutoLogin'],
                'attribute' => 'u_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[email]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UAutoLogin']->u_person_id) ? UPerson::model()->findByPk($data['UAutoLogin']->u_person_id)->email : ''
                )
            )),
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'uAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm date-picker',
                    'placeholder' => $data['UAutoLogin']->getAttributeLabel('expired_at')
                )
            )),
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data['UAutoLogin']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        );
    }
}