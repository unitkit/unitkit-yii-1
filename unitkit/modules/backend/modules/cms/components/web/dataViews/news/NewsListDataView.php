<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsListDataView extends UListDataView
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
        $this->id = 'uCmsNewsNewsMain';

        // component title
        $this->title = Unitkit::t('backend', 'cms_news_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uCmsNewsGroupI18ns.name',
            'uCmsNewsI18ns.title',
            'uCmsNews.activated',
            'uCmsNews.published_at',
        );

        // controller
        $controller = Yii::app()->controller;

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_cms_news_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                	'class' => 'input-ajax-select allow-clear',
                	'id' => 'uCmsNewsGroupI18nNameGridSearch',
                	'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsNewsGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                	),
                	'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                	'data-text' =>
                        ! empty($model->u_cms_news_group_id)
                        ?
                        	UCmsNewsGroupI18n::model()->findByPk(array(
                                'u_cms_news_group_id' => $model->u_cms_news_group_id,
                                'i18n_id' => Yii::app()->language
                            ))->name
                        :
                        	''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_news_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            new UDateRangeItemField(
                $model,
                'published_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_published_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVPublishedAtStartGridSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_published_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVPublishedAtEndGridSearch'
                    )
                ))
            ),
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_cms_news_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uCmsNewsGroupI18nNameAdvSearch',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsNewsGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->u_cms_news_group_id)
                        ?
                            UCmsNewsGroupI18n::model()->findByPk(array(
                				'u_cms_news_group_id' => $model->u_cms_news_group_id,
                				'i18n_id' => Yii::app()->language
                			))->name
                        :
                            ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_news_i18ns_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_news_i18ns_content',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'data' => array(
                    '' => Unitkit::t('unitkit', 'input_drop_down_list_all'),
                    '1' => Unitkit::t('unitkit', 'input_drop_down_list_checked'),
                    '0' => Unitkit::t('unitkit', 'input_drop_down_list_unchecked')
                ),
                'htmlOptions' => array(
                    'class' => 'form-control input-sm'
                )
            )),
            new UDateRangeItemField(
                $model,
                'published_at',
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_published_at_start',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVPublishedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_published_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVPublishedAtEndAdvSearch'
                    )
                ))
            ),
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
                        'id' => 'uCmsNewsVCreatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVCreatedAtEndAdvSearch'
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
                        'id' => 'uCmsNewsVUpdatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsNewsVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($data as $d) {
            $this->rows[] = new NewsListRowDataView($d, array('id' => $d->id,));
        }

        // pagination
        $this->pagination = $pagination;
    }
}