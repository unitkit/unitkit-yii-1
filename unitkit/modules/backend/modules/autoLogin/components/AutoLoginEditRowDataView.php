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
                'model' => $datas['BAutoLogin'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BPerson[email]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BAutoLogin']->b_person_id) ? BPerson::model()->findByPk($datas['BAutoLogin']->b_person_id)->email : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'bAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm date-picker',
                    'placeholder' => $datas['BAutoLogin']->getAttributeLabel('expired_at')
                )
            )),
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'created_at',
                'value' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($datas['BAutoLogin']->created_at, 'yyyy-MM-dd hh:mm:ss'))
            ))
        );
    }
}