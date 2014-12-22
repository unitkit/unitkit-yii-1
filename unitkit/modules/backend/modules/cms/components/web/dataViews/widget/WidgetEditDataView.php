<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetEditDataView extends UEditDataView
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
        $this->id = 'uCmsWidgetWidgetEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_widget_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_widget_update_title');

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
        $this->isNewRecord = $data['UCmsWidget']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );

        if (! $data['UCmsWidget']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsWidget']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsWidget'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsWidget']->updated_at
            ));
        }
    }
}