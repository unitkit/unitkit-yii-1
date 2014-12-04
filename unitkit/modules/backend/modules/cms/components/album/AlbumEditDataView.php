<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumEditDataView extends UEditDataView
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
        $this->id = 'uCmsAlbumAlbumEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_album_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_album_update_title');

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
        $this->isNewRecord = $data['UCmsAlbum']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsAlbum'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsAlbumI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsAlbumI18n']->getAttributeLabel('title'),
                )
            )),
        );

        if (! $data['UCmsAlbum']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsAlbum'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsAlbum']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsAlbum'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsAlbum']->updated_at
            ));
        }
    }
}