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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsLayoutLayoutEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_layout_create_title');
        $this->updateTitle = B::t('backend', 'cms_layout_update_title');

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
        $this->isNewRecord = $datas['BCmsLayout']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsLayoutI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsLayoutI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsLayout'],
                'attribute' => 'max_container',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsLayout']->getAttributeLabel('max_container'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsLayout'],
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsLayout']->getAttributeLabel('path'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsLayout'],
                'attribute' => 'view',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsLayout']->getAttributeLabel('views'),
                )
            )),
        );

        if (! $datas['BCmsLayout']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsLayout'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsLayout']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsLayout'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsLayout']->updated_at
            ));
        }
    }
}