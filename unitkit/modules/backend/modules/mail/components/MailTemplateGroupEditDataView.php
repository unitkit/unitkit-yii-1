<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateGroupEditDataView extends UEditDataView
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
        $this->id = 'uMailTemplateGroupMailTemplateGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'mail_mail_template_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'mail_mail_template_group_update_title');

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
        $this->isNewRecord = $data['UMailTemplateGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UMailTemplateGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UMailTemplateGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $data['UMailTemplateGroup']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UMailTemplateGroup'],
                'attribute' => 'created_at',
                'value' => $data['UMailTemplateGroup']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UMailTemplateGroup'],
                'attribute' => 'updated_at',
                'value' => $data['UMailTemplateGroup']->updated_at
            ));
        }
    }
}