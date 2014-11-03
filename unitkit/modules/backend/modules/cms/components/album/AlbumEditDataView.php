<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumEditDataView extends BEditDataView
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
        $this->id = 'bCmsAlbumAlbumEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_album_create_title');
        $this->updateTitle = B::t('backend', 'cms_album_update_title');

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
        $this->isNewRecord = $datas['BCmsAlbum']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsAlbum'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $datas['BCmsAlbumI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsAlbumI18n']->getAttributeLabel('title'),
                )
            )),
        );

        if (! $datas['BCmsAlbum']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsAlbum'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsAlbum']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsAlbum'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsAlbum']->updated_at
            ));
        }
    }
}