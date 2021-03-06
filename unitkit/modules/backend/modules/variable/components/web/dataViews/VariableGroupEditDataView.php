<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupEditDataView extends UEditDataView
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
        $this->id = 'uVariableGroupVariableGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'variable_variable_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'variable_variable_group_update_title');

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
        $this->isNewRecord = $data['UVariableGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UVariableGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $data['UVariableGroupI18n']->getAttributeLabel('name')
                )
            )),
            new UItemField(array(
                'model' => $data['UVariableGroup'],
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UVariableGroup']->getAttributeLabel('code')
                )
            ))
        );

        if (! $data['UVariableGroup']->isNewRecord) {

            $this->items[] = new UItemField(array(
                'model' => $data['UVariableGroup'],
                'attribute' => 'created_at',
                'value' => $data['UVariableGroup']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UVariableGroup'],
                'attribute' => 'updated_at',
                'value' => $data['UVariableGroup']->updated_at
            ));
        }
    }
}