<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerListDataView extends BListDataView
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
        $this->id = 'bCmsPagePageContainerMain';

        // component title
        $this->title = B::t('backend', 'cms_page_container_list_title');

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bCmsPageI18ns.slug',
            'bCmsPage.activated',
            'bCmsPage.cache_duration',
            'bCmsPageI18ns.title',
            'bCmsLayoutI18ns.name',
            'bCmsPageI18ns.html_title',
            'bCmsPageI18ns.html_description',
            'bCmsPageI18ns.html_keywords',
            //'bCmsPage.created_at',
            //'bCmsPage.updated_at',
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'datas' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked'),
                ),
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                	'class' => 'input-ajax-select allow-clear',
                	'id' => 'bCmsLayoutI18nTitleGridSearch',
                	'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array(
                            'name' => 'BCmsLayoutI18n[name]',
            				'language' => Yii::app()->language
                        )
                	),
                	'data-placeholder' => B::t('unitkit', 'input_select'),
                	'data-text' =>
                        ! empty($model->b_cms_layout_id)
                        ?
                        	BCmsLayoutI18n::model()->findByPk(array(
                                'b_cms_layout_id' => $model->b_cms_layout_id,
                                'i18n_id' => Yii::app()->language
                            ))->name
                        :
                        	''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_keywords',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),/*
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
                        'id' => 'bCmsPageVCreatedAtStartGridSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsPageVCreatedAtEndGridSearch'
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
                        'id' => 'bCmsPageVUpdatedAtStartGridSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsPageVUpdatedAtEndGridSearch'
                    )
                ))
            ),*/
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'datas' => array(
                    '' => B::t('unitkit', 'input_drop_down_list_all'),
                    '1' => B::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => B::t('unitkit', 'input_drop_down_list_unchecked'),
                ),
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bCmsLayoutI18nTitleAdvSearch',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array(
                            'name' => 'BCmsLayoutI18n[name]',
            				'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->b_cms_layout_id)
                        ?
                            BCmsLayoutI18n::model()->findByPk(array(
                				'b_cms_layout_id' => $model->b_cms_layout_id,
                				'b_i18n_id' => Yii::app()->language
                			))->name
                        :
                            ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_page_i18ns_html_keywords',
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
                        'id' => 'bCmsPageVCreatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsPageVCreatedAtEndAdvSearch'
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
                        'id' => 'bCmsPageVUpdatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsPageVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($datas as $data)
            $this->rows[] = new PageContainerListRowDataView($data, array('id' => $data->id,));

        // pagination
        $this->pagination = $pagination;
    }
}