<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerListDataView extends UListDataView
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
        $this->id = 'uCmsPagePageContainerMain';

        // component title
        $this->title = Unitkit::t('backend', 'cms_page_container_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uCmsPageI18ns.title',
            'uCmsLayoutI18ns.name',
            'uCmsPageI18ns.slug',
            'uCmsPage.activated',
            'uCmsPage.cache_duration',
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uCmsLayoutI18nTitleGridSearch',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsLayoutI18n[name]',
                            'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->u_cms_layout_id)
                            ?
                            UCmsLayoutI18n::model()->findByPk(array(
                                'u_cms_layout_id' => $model->u_cms_layout_id,
                                'i18n_id' => Yii::app()->language
                            ))->name
                            :
                            ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked'),
                ),
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked'),
                ),
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uCmsLayoutI18nTitleAdvSearch',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsLayoutI18n[name]',
            				'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->u_cms_layout_id)
                        ?
                            UCmsLayoutI18n::model()->findByPk(array(
                				'u_cms_layout_id' => $model->u_cms_layout_id,
                				'u_i18n_id' => Yii::app()->language
                			))->name
                        :
                            ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_page_i18ns_html_keywords',
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
                        'id' => 'uCmsPageVCreatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsPageVCreatedAtEndAdvSearch'
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
                        'id' => 'uCmsPageVUpdatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsPageVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($data as $d) {
            $this->rows[] = new PageContainerListRowDataView($d, array('id' => $d->id,));
        }

        // pagination
        $this->pagination = $pagination;
    }
}