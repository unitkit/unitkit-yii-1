<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetEditDataView extends BEditDataView
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
        $this->id = 'bCmsWidgetWidgetEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_widget_create_title');
        $this->updateTitle = B::t('backend', 'cms_widget_update_title');

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
            if ($this->hasErrors = $data->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsWidget']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );

        if (! $data['BCmsWidget']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsWidget']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsWidget'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsWidget']->updated_at
            ));
        }
    }
}