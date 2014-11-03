<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumListDataView extends BListDataView
{
    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$datas, &$relatedDatas, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = 'bCmsAlbumAlbumMain';

        // component title
        $this->title = B::t('backend', 'cms_album_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bCmsAlbumI18ns.title',
            'bCmsAlbum.created_at',
            'bCmsAlbum.updated_at',
        );

        $pagination->pageSize = 11;

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_album_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BDateRangeItemField(
                $model,
                'created_at',
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVCreatedAtStartGridSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVCreatedAtEndGridSearch'
                    )
                ))
            ),
            new BDateRangeItemField(
                $model,
                'updated_at',
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVUpdatedAtStartGridSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVUpdatedAtEndGridSearch'
                    )
                ))
            ),
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_album_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
        	new BDateRangeItemField(
                $model,
                'created_at',
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVCreatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVCreatedAtEndAdvSearch'
                    )
                ))
            ),
        	new BDateRangeItemField(
                $model,
                'updated_at',
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVUpdatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsAlbumVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($datas as $data)
            $this->rows[] = new AlbumListRowDataView($data, array('id' => $data->id,));

        // pagination
        $this->pagination = $pagination;
    }
}