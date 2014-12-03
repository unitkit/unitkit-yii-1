<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateGroupEditDataView extends BEditDataView
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
        $this->id = 'bMailTemplateGroupMailTemplateGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_template_group_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_template_group_update_title');

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
        $this->isNewRecord = $data['BMailTemplateGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BMailTemplateGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BMailTemplateGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['BMailTemplateGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BMailTemplateGroup'],
                'attribute' => 'created_at',
                'value' => $data['BMailTemplateGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BMailTemplateGroup'],
                'attribute' => 'updated_at',
                'value' => $data['BMailTemplateGroup']->updated_at
            ));
        }
    }
}