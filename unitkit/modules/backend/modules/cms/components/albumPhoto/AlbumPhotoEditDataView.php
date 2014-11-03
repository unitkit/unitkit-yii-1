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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsAlbumPhotoAlbumPhotoEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_album_photo_create_title', array(
            '{name}' => BHtml::textReduce($relatedDatas['BCmsAlbumI18n']->title, 30)
        ));
        $this->updateTitle = B::t('backend', 'cms_album_photo_update_title', array(
            '{name}' => BHtml::textReduce($relatedDatas['BCmsAlbumI18n']->title, 30)
        ));

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
        $this->isNewRecord = $datas['BCmsAlbumPhoto']->isNewRecord;

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
                'model' => $datas['BCmsAlbumPhotoI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsAlbumPhotoI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsAlbumPhoto'],
                'attribute' => 'file_path',
                'value' => $this->controller->getUploader('BCmsAlbumPhoto[file_path]')['uploader']->htmlUploader(
                    $datas['BCmsAlbumPhoto'],
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

        if (! $datas['BCmsAlbumPhoto']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsAlbumPhoto'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsAlbumPhoto']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsAlbumPhoto'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsAlbumPhoto']->updated_at
            ));
        }
    }
}