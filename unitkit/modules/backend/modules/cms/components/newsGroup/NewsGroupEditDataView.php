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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsNewsGroupNewsGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_news_group_create_title');
        $this->updateTitle = B::t('backend', 'cms_news_group_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($datas as $data)
        	if($this->hasErrors = $data->hasErrors())
        		break;

        // new record status
        $this->isNewRecord = $datas['BCmsNewsGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsNewsGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BCmsNewsGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsNewsGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $datas['BCmsNewsGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsNewsGroup'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsNewsGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsNewsGroup'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsNewsGroup']->updated_at
            ));
        }
    }
}