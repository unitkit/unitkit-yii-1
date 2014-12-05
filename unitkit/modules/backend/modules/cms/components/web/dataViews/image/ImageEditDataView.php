<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ImageEditDataView extends UEditDataView
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
        $this->id = 'uCmsImageImageEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_image_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_image_update_title');

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
        $this->isNewRecord = $data['UCmsImage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsImage'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsImageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsImageI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsImage'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('UCmsImage[file_path]')['uploader']->htmlUploader(
                    $data['UCmsImage'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => UUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                    )
                )
            )),
        );

        if (! $data['UCmsImage']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsImage'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsImage']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsImage'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsImage']->updated_at
            ));
        }
    }
}