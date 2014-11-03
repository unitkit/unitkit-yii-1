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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bMessageGroupMessageGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'message_message_group_create_title');
        $this->updateTitle = B::t('backend', 'message_message_group_update_title');

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
        $this->isNewRecord = $datas['BMessageGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BMessageGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BMessageGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm select-related-field',
                    'placeholder' => $datas['BMessageGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $datas['BMessageGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BMessageGroup'],
                'attribute' => 'created_at',
                'value' => $datas['BMessageGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BMessageGroup'],
                'attribute' => 'updated_at',
                'value' => $datas['BMessageGroup']->updated_at
            ));
        }
    }
}