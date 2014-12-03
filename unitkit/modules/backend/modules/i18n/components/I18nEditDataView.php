<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class I18nEditDataView extends BEditDataView
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
        $this->id = 'bI18nI18nEdit';

        // component title
        $this->createTitle = B::t('backend', 'i18n_i18n_create_title');
        $this->updateTitle = B::t('backend', 'i18n_i18n_update_title');

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
        $this->isNewRecord = $data['BI18n']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BI18n'],
                'attribute' => 'id',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BI18n']->getAttributeLabel('id')
                )
            )),
            new BItemField(array(
                'model' => $data['BI18nI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BI18nI18n']->getAttributeLabel('name')
                )
            ))
        );
    }
}