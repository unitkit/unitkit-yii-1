<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class LayoutListDataView extends BListDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     * @param CController $controller CController component
     */
    public function __construct(&$data, &$relatedData, &$model, &$sort, &$pagination, &$controller)
    {
        // id
        $this->id = 'bCmsLayoutLayoutMain';

        // component title
        $this->title = B::t('backend', 'cms_layout_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bCmsLayoutI18ns.name',
            'bCmsLayout.max_container',
            'bCmsLayout.path',
            'bCmsLayout.view',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_layout_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'max_container',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'view',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_layout_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'max_container',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'path',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'view',
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
                        'id' => 'bCmsLayoutVCreatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsLayoutVCreatedAtEndAdvSearch'
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
                        'id' => 'bCmsLayoutVUpdatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsLayoutVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($data as $d) {
            $this->rows[] = new LayoutListRowDataView($d, array('id' => $d->id,));
        }

        // pagination
        $this->pagination = $pagination;
    }
}