<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsGroupEditDataView extends UEditDataView
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
        $this->id = 'uCmsNewsGroupNewsGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_news_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_news_group_update_title');

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
        $this->isNewRecord = $data['UCmsNewsGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsNewsGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsNewsGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsNewsGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $data['UCmsNewsGroup']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsNewsGroup'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsNewsGroup']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsNewsGroup'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsNewsGroup']->updated_at
            ));
        }
    }
}