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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bVariableVariableEdit';

        // component title
        $this->createTitle = B::t('backend', 'variable_variable_create_title');
        $this->updateTitle = B::t('backend', 'variable_variable_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($datas as $data)
            if ($this->hasErrors = $data->hasErrors())
                break;

            // new record status
        $this->isNewRecord = $datas['BVariable']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BVariable'],
                'attribute' => 'b_variable_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BVariableGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BVariable']->b_variable_group_id) ? BVariableGroupI18n::model()->findByPk(array(
                        'b_variable_group_id' => $datas['BVariable']->b_variable_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-addAction' => $this->controller->createUrl('variableGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('variableGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BVariable'],
                'attribute' => 'param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariable']->getAttributeLabel('param')
                )
            )),
            new BItemField(array(
                'model' => $datas['BVariable'],
                'attribute' => 'val',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariable']->getAttributeLabel('val')
                )
            )),
            new BItemField(array(
                'model' => $datas['BVariableI18n'],
                'attribute' => 'description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariableI18n']->getAttributeLabel('description')
                )
            ))
        );

        if (! $datas['BVariable']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BVariable'],
                'attribute' => 'created_at',
                'value' => $datas['BVariable']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BVariable'],
                'attribute' => 'updated_at',
                'value' => $datas['BVariable']->updated_at
            ));
        }
    }
}