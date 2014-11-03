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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bI18nI18nEdit';

        // component title
        $this->createTitle = B::t('backend', 'i18n_i18n_create_title');
        $this->updateTitle = B::t('backend', 'i18n_i18n_update_title');

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
        $this->isNewRecord = $datas['BI18n']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BI18n'],
                'attribute' => 'id',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BI18n']->getAttributeLabel('id')
                )
            )),
            new BItemField(array(
                'model' => $datas['BI18nI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BI18nI18n']->getAttributeLabel('name')
                )
            ))
        );
    }
}