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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsWidgetWidgetEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_widget_create_title');
        $this->updateTitle = B::t('backend', 'cms_widget_update_title');

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
        $this->isNewRecord = $datas['BCmsWidget']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BCmsWidgetI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidgetI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidget']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'arg',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsWidget']->getAttributeLabel('arg'),
                )
            )),
        );

        if (! $datas['BCmsWidget']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsWidget']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsWidget'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsWidget']->updated_at
            ));
        }
    }
}