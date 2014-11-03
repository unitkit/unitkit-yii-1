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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bVariableGroupVariableGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'variable_variable_group_create_title');
        $this->updateTitle = B::t('backend', 'variable_variable_group_update_title');

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
        $this->isNewRecord = $datas['BVariableGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BVariableGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $datas['BVariableGroupI18n']->getAttributeLabel('name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BVariableGroup'],
                'attribute' => 'code',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BVariableGroup']->getAttributeLabel('code')
                )
            ))
        );

        if (! $datas['BVariableGroup']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BVariableGroup'],
                'attribute' => 'created_at',
                'value' => $datas['BVariableGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BVariableGroup'],
                'attribute' => 'updated_at',
                'value' => $datas['BVariableGroup']->updated_at
            ));
        }
    }
}