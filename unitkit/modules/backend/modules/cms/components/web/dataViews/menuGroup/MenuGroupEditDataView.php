<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuGroupEditDataView extends UEditDataView
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
        $this->id = 'uCmsMenuGroupMenuGroupEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_menu_group_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_menu_group_update_title');

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
        $this->isNewRecord = $data['UCmsMenuGroup']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsMenuGroup'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsMenuGroupI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsMenuGroupI18n']->getAttributeLabel('name'),
                )
            )),
        );

        if (! $data['UCmsMenuGroup']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsMenuGroup'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsMenuGroup']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsMenuGroup'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsMenuGroup']->updated_at
            ));
        }
    }
}