<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoEditDataView extends BEditDataView
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
        $this->id = 'bCmsAlbumPhotoAlbumPhotoEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_album_photo_create_title', array(
            '{name}' => BHtml::textReduce($relatedData['BCmsAlbumI18n']->title, 30)
        ));
        $this->updateTitle = B::t('backend', 'cms_album_photo_update_title', array(
            '{name}' => BHtml::textReduce($relatedData['BCmsAlbumI18n']->title, 30)
        ));

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
        $this->isNewRecord = $data['BCmsAlbumPhoto']->isNewRecord;

        $this->setAction($this->controller->createUrl(
            $this->controller->id . '/' . ($this->isNewRecord ? 'create' : 'update'),
            $this->pk + array('album' => $_GET['album'])
        ));

        $this->setCloseAction($this->controller->createUrl(
            $this->controller->id . '/list',
            array('album' => $_GET['album'])
        ));

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsAlbumPhotoI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsAlbumPhotoI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsAlbumPhoto'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsAlbumPhoto[file_path]')['uploader']->htmlUploader(
                    $data['BCmsAlbumPhoto'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => BUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                        'html_options' => array('style' => 'max-width:350px;'),
                    )
                )
            )),
        );

        if (! $data['BCmsAlbumPhoto']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsAlbumPhoto'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsAlbumPhoto']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsAlbumPhoto'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsAlbumPhoto']->updated_at
            ));
        }
    }
}