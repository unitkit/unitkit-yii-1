<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupEditDataView extends BEditDataView
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
        $this->id = 'bGroupGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_person_group_create_title');
        $this->updateTitle = B::t('backend', 'right_person_group_update_title');

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
        $this->isNewRecord = $data['BGroup']->isNewRecord;

        // set page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['BGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BGroup'],
                'attribute' => 'updated_at',
                'value' => $data['BGroup']->updated_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BGroup'],
                'attribute' => 'created_at',
                'value' => $data['BGroup']->created_at
            ));
        }
    }
}