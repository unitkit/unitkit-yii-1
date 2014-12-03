<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableEditDataView extends BEditDataView
{

    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        $this->id = 'bVariableVariableEdit';

        // component title
        $this->createTitle = B::t('backend', 'variable_variable_create_title');
        $this->updateTitle = B::t('backend', 'variable_variable_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($data as $d) {
            if ($this->hasErrors = $d->hasErrors())
                break;
        }

        // new record status
        $this->isNewRecord = $data['BVariable']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BVariable'],
                'attribute' => 'b_variable_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BVariableGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BVariable']->b_variable_group_id) ? BVariableGroupI18n::model()->findByPk(array(
                        'b_variable_group_id' => $data['BVariable']->b_variable_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-addAction' => $this->controller->createUrl('variableGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('variableGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $data['BVariable'],
                'attribute' => 'param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BVariable']->getAttributeLabel('param')
                )
            )),
            new BItemField(array(
                'model' => $data['BVariable'],
                'attribute' => 'val',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BVariable']->getAttributeLabel('val')
                )
            )),
            new BItemField(array(
                'model' => $data['BVariableI18n'],
                'attribute' => 'description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BVariableI18n']->getAttributeLabel('description')
                )
            ))
        );

        if (! $data['BVariable']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BVariable'],
                'attribute' => 'created_at',
                'value' => $data['BVariable']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BVariable'],
                'attribute' => 'updated_at',
                'value' => $data['BVariable']->updated_at
            ));
        }
    }
}