<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsGroupEditDataView extends BEditDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsNewsGroupNewsGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_news_group_create_title');
        $this->updateTitle = B::t('backend', 'cms_news_group_update_title');

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
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsNewsGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsNewsGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsNewsGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsNewsGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $data['BCmsNewsGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsNewsGroup'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsNewsGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsNewsGroup'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsNewsGroup']->updated_at
            ));
        }
    }
}