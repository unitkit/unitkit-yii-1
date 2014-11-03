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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bGroupGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_person_group_create_title');
        $this->updateTitle = B::t('backend', 'right_person_group_update_title');

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
        $this->isNewRecord = $datas['BGroup']->isNewRecord;

        // set page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $datas['BGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BGroup'],
                'attribute' => 'updated_at',
                'value' => $datas['BGroup']->updated_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BGroup'],
                'attribute' => 'created_at',
                'value' => $datas['BGroup']->created_at
            ));
        }
    }
}