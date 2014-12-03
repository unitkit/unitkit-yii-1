<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupEditDataView extends BEditDataView
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
        $this->id = 'bVariableGroupVariableGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'variable_variable_group_create_title');
        $this->updateTitle = B::t('backend', 'variable_variable_group_update_title');

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
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

            // new record status
        $this->isNewRecord = $data['BVariableGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BVariableGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $data['BVariableGroupI18n']->getAttributeLabel('name')
                )
            )),
            new BItemField(array(
                'model' => $data['BVariableGroup'],
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BVariableGroup']->getAttributeLabel('code')
                )
            ))
        );

        if (! $data['BVariableGroup']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $data['BVariableGroup'],
                'attribute' => 'created_at',
                'value' => $data['BVariableGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BVariableGroup'],
                'attribute' => 'updated_at',
                'value' => $data['BVariableGroup']->updated_at
            ));
        }
    }
}