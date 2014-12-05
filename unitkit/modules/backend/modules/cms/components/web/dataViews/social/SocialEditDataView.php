<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SocialEditDataView extends UEditDataView
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
        $this->id = 'uCmsSocialSocialEdit';

        // component title
        $this->updateTitle = Unitkit::t('backend', 'cms_social_update_title');

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
        $this->isNewRecord = $data['UCmsSocial']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsSocial'],
                'attribute' => 'name',
                'value' => $data['UCmsSocial']->name,
            )),
            new UItemField(array(
                'model' => $data['UCmsSocialI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsSocialI18n']->getAttributeLabel('url'),
                )
            )),
        );
    }
}