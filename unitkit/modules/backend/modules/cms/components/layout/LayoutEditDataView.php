<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class LayoutEditDataView extends BEditDataView
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
        $this->id = 'bCmsLayoutLayoutEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_layout_create_title');
        $this->updateTitle = B::t('backend', 'cms_layout_update_title');

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
        $this->isNewRecord = $data['BCmsLayout']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsLayoutI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsLayoutI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsLayout'],
                'attribute' => 'max_container',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsLayout']->getAttributeLabel('max_container'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsLayout'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsLayout']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsLayout'],
                'attribute' => 'view',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsLayout']->getAttributeLabel('views'),
                )
            )),
        );

        if (! $data['BCmsLayout']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsLayout'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsLayout']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsLayout'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsLayout']->updated_at
            ));
        }
    }
}