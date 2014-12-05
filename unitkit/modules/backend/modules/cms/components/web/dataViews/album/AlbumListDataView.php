<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumListDataView extends UListDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$data, &$relatedData, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = 'uCmsAlbumAlbumMain';

        // component title
        $this->title = Unitkit::t('backend', 'cms_album_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uCmsAlbumI18ns.title',
            'uCmsAlbum.created_at',
            'uCmsAlbum.updated_at',
        );

        $pagination->pageSize = 11;

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_album_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UDateRangeItemField(
                $model,
                'created_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVCreatedAtStartGridSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVCreatedAtEndGridSearch'
                    )
                ))
            ),
            new UDateRangeItemField(
                $model,
                'updated_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVUpdatedAtStartGridSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVUpdatedAtEndGridSearch'
                    )
                ))
            ),
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_album_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
        	new UDateRangeItemField(
                $model,
                'created_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVCreatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVCreatedAtEndAdvSearch'
                    )
                ))
            ),
        	new UDateRangeItemField(
                $model,
                'updated_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVUpdatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsAlbumVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($data as $d) {
            $this->rows[] = new AlbumListRowDataView($d, array('id' => $d->id,));
        }

        // pagination
        $this->pagination = $pagination;
    }
}