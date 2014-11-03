<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuGroupEditDataView extends BEditDataView
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
        $this->id = 'bCmsMenuGroupMenuGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_menu_group_create_title');
        $this->updateTitle = B::t('backend', 'cms_menu_group_update_title');

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
        $this->isNewRecord = $datas['BCmsMenuGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsMenuGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenuGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsMenuGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $datas['BCmsMenuGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsMenuGroup'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsMenuGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsMenuGroup'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsMenuGroup']->updated_at
            ));
        }
    }
}