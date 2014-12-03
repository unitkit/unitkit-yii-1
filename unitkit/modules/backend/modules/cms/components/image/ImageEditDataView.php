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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsImageImageEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_image_create_title');
        $this->updateTitle = B::t('backend', 'cms_image_update_title');

        // primary key
        $this->pk = array_merge($pk, $_GET);

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($data as $d) {
        	if($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsImage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsImage'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsImageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsImageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsImage'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsImage[file_path]')['uploader']->htmlUploader(
                    $data['BCmsImage'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => BUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                    )
                )
            )),
        );

        if (! $data['BCmsImage']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsImage'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsImage']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsImage'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsImage']->updated_at
            ));
        }
    }
}