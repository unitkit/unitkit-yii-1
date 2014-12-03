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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsAlbumAlbumEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_album_create_title');
        $this->updateTitle = B::t('backend', 'cms_album_update_title');

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
        $this->isNewRecord = $data['BCmsAlbum']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsAlbum'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsAlbumI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsAlbumI18n']->getAttributeLabel('title'),
                )
            )),
        );

        if (! $data['BCmsAlbum']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsAlbum'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsAlbum']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsAlbum'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsAlbum']->updated_at
            ));
        }
    }
}