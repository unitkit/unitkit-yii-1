<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class LayoutEditDataView extends UEditDataView
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
        $this->id = 'uCmsLayoutLayoutEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_layout_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_layout_update_title');

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
        $this->isNewRecord = $data['UCmsLayout']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsLayoutI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsLayoutI18n']->getAttributeLabel('name'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsLayout'],
                'attribute' => 'max_container',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsLayout']->getAttributeLabel('max_container'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsLayout'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsLayout']->getAttributeLabel('path'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsLayout'],
                'attribute' => 'view',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsLayout']->getAttributeLabel('views'),
                )
            )),
        );

        if (! $data['UCmsLayout']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsLayout'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsLayout']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsLayout'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsLayout']->updated_at
            ));
        }
    }
}