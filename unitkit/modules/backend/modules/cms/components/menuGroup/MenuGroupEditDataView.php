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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsMenuGroupMenuGroupEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_menu_group_create_title');
        $this->updateTitle = B::t('backend', 'cms_menu_group_update_title');

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
        $this->isNewRecord = $data['BCmsMenuGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsMenuGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsMenuGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsMenuGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $data['BCmsMenuGroup']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsMenuGroup'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsMenuGroup']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsMenuGroup'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsMenuGroup']->updated_at
            ));
        }
    }
}