<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoEditDataView extends UEditDataView
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
        $this->id = 'uCmsAlbumPhotoAlbumPhotoEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_album_photo_create_title', array(
            '{name}' => UHtml::textReduce($relatedData['UCmsAlbumI18n']->title, 30)
        ));
        $this->updateTitle = Unitkit::t('backend', 'cms_album_photo_update_title', array(
            '{name}' => UHtml::textReduce($relatedData['UCmsAlbumI18n']->title, 30)
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
        $this->isNewRecord = $data['UCmsAlbumPhoto']->isNewRecord;

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
            new UItemField(array(
                'model' => $data['UCmsAlbumPhotoI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsAlbumPhotoI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsAlbumPhoto'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('UCmsAlbumPhoto[file_path]')['uploader']->htmlUploader(
                    $data['UCmsAlbumPhoto'],
                    'file_path',
                    $this->controller->createUrl($this->controller->id.'/upload'),
                    array(
                        'type' => UUploader::OVERVIEW_IMAGE,
                        'route' => $this->controller->id.'/upload',
                        'html_options' => array('style' => 'max-width:350px;'),
                    )
                )
            )),
        );

        if (! $data['UCmsAlbumPhoto']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsAlbumPhoto'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsAlbumPhoto']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsAlbumPhoto'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsAlbumPhoto']->updated_at
            ));
        }
    }
}