<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageGroupEditDataView extends BEditDataView
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
        $this->id = 'bMessageGroupMessageGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'message_message_group_create_title');
        $this->updateTitle = B::t('backend', 'message_message_group_update_title');

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
        $this->isNewRecord = $data['BMessageGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMessageGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BMessageGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $data['BMessageGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['BMessageGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BMessageGroup'],
                'attribute' => 'created_at',
                'value' => $data['BMessageGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BMessageGroup'],
                'attribute' => 'updated_at',
                'value' => $data['BMessageGroup']->updated_at
            ));
        }
    }
}