<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SocialEditDataView extends BEditDataView
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
        // data view id
        $this->id = 'bCmsSocialSocialEdit';

        // component title
        $this->updateTitle = B::t('backend', 'cms_social_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($data as $d) {
            if ($this->hasErrors = $data->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsSocial']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsSocial'],
                'attribute' => 'name',
                'value' => $data['BCmsSocial']->name,
            )),
            new BItemField(array(
                'model' => $data['BCmsSocialI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsSocialI18n']->getAttributeLabel('url'),
                )
            )),
        );
    }
}