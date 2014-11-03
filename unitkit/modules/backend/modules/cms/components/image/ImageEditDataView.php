<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageEditDataView extends BEditDataView
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
        $this->id = 'bCmsImageImageEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_image_create_title');
        $this->updateTitle = B::t('backend', 'cms_image_update_title');

        // primary key
        $this->pk = array_merge($pk, $_GET);


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
        $this->isNewRecord = $datas['BCmsImage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsImage'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BCmsImageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsImageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsImage'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsImage[file_path]')['uploader']->htmlUploader(
                    $datas['BCmsImage'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => BUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                    )
                )
            )),
        );

        if (! $datas['BCmsImage']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsImage'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsImage']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsImage'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsImage']->updated_at
            ));
        }
    }
}