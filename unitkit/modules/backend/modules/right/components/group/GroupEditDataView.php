<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupEditDataView extends UEditDataView
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
        $this->id = 'uGroupGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'right_person_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'right_person_group_update_title');

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
        $this->isNewRecord = $data['UGroup']->isNewRecord;

        // set page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['UGroup']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UGroup'],
                'attribute' => 'updated_at',
                'value' => $data['UGroup']->updated_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UGroup'],
                'attribute' => 'created_at',
                'value' => $data['UGroup']->created_at
            ));
        }
    }
}