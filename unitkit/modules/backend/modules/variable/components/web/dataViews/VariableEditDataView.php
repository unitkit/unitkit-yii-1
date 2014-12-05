<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableEditDataView extends UEditDataView
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
        $this->id = 'uVariableVariableEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'variable_variable_create_title');
        $this->updateTitle = Unitkit::t('backend', 'variable_variable_update_title');

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
        $this->isNewRecord = $data['UVariable']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UVariable'],
                'attribute' => 'u_variable_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UVariableGroupI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UVariable']->u_variable_group_id) ? UVariableGroupI18n::model()->findByPk(array(
                        'u_variable_group_id' => $data['UVariable']->u_variable_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-addAction' => $this->controller->createUrl('variableGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('variableGroup/update'),
                )
            )),
            new UItemField(array(
                'model' => $data['UVariable'],
                'attribute' => 'param',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UVariable']->getAttributeLabel('param')
                )
            )),
            new UItemField(array(
                'model' => $data['UVariable'],
                'attribute' => 'val',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UVariable']->getAttributeLabel('val')
                )
            )),
            new UItemField(array(
                'model' => $data['UVariableI18n'],
                'attribute' => 'description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UVariableI18n']->getAttributeLabel('description')
                )
            ))
        );

        if (! $data['UVariable']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UVariable'],
                'attribute' => 'created_at',
                'value' => $data['UVariable']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UVariable'],
                'attribute' => 'updated_at',
                'value' => $data['UVariable']->updated_at
            ));
        }
    }
}