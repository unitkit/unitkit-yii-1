<?php

/**
 * Data view of translate interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumPhotoTranslateDataView extends BTranslateDataView
{
    /**
     * Constructor
     *
     * @param array $datas Array of CModels
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsAlbumPhotoAlbumPhotoTranslate';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = BCmsAlbumPhotoI18n::model();

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        $this->setAction($this->controller->createUrl(
            $this->controller->id . '/translate',
            $this->pk + array('album' => $_GET['album'])
        ));

        $this->setCloseAction($this->controller->createUrl(
            $this->controller->id . '/list',
            array('album' => $_GET['album'])
        ));

        // items
        $this->items = array(
            new BItemField(array(
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'id' => false,
                )
            )),
        );
    }
}