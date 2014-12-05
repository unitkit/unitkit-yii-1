<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageGroupEditDataView extends UEditDataView
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
        $this->id = 'uMessageGroupMessageGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'message_message_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'message_message_group_update_title');

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
        $this->isNewRecord = $data['UMessageGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UMessageGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UMessageGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $data['UMessageGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['UMessageGroup']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UMessageGroup'],
                'attribute' => 'created_at',
                'value' => $data['UMessageGroup']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UMessageGroup'],
                'attribute' => 'updated_at',
                'value' => $data['UMessageGroup']->updated_at
            ));
        }
    }
}