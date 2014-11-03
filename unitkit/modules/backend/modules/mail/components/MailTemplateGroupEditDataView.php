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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bMailTemplateGroupMailTemplateGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'mail_mail_template_group_create_title');
        $this->updateTitle = B::t('backend', 'mail_mail_template_group_update_title');

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
        $this->isNewRecord = $datas['BMailTemplateGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BMailTemplateGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BMailTemplateGroupI18n']->getAttributeLabel('name')
                )
            ))
        );

        if (! $datas['BMailTemplateGroup']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BMailTemplateGroup'],
                'attribute' => 'created_at',
                'value' => $datas['BMailTemplateGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BMailTemplateGroup'],
                'attribute' => 'updated_at',
                'value' => $datas['BMailTemplateGroup']->updated_at
            ));
        }
    }
}