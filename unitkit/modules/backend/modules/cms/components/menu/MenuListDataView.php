<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuListDataView extends BListDataView
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
        $this->id = 'bCmsMenuMenuMain';

        // component title
        $this->title = B::t('backend', 'cms_menu_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bCmsMenuGroupI18ns.name',
            'bCmsMenu.rank',
            'bCmsMenuI18ns.name',
            'bCmsMenuI18ns.url',
        );

        // controller
        $controller = Yii::app()->controller;

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                	'class' => 'input-ajax-select allow-clear',
                	'id' => 'bCmsMenuGroupI18nNameGridSearch',
                	'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'BCmsMenuGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                	),
                	'data-placeholder' => B::t('unitkit', 'input_select'),
                	'data-text' =>
                        ! empty($model->b_cms_menu_group_id)
                        ?
                        	BCmsMenuGroupI18n::model()->findByPk(array(
                                'b_cms_menu_group_id' => $model->b_cms_menu_group_id,
                                'i18n_id' => Yii::app()->language
                            ))->name
                        :
                        	''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_menu_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_menu_i18ns_url',
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
                'attribute' => 'b_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bCmsMenuGroupI18nNameAdvSearch',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'BCmsMenuGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->b_cms_menu_group_id)
                        ?
                            BCmsMenuGroupI18n::model()->findByPk(array(
                				'b_cms_menu_group_id' => $model->b_cms_menu_group_id,
                				'i18n_id' => Yii::app()->language
                			))->name
                        :
                            ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_menu_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_cms_menu_i18ns_url',
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
                        'id' => 'bCmsMenuVCreatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsMenuVCreatedAtEndAdvSearch'
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
                        'id' => 'bCmsMenuVUpdatedAtStartAdvSearch'
                    )
                )),
                new BItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => B::t('unitkit', 'input_search'),
                        'id' => 'bCmsMenuVUpdatedAtEndAdvSearch'
                    )
                ))
            ),
        );

        // rows
        foreach($data as $d) {
            $this->rows[] = new MenuListRowDataView($d, array('id' => $d->id,));
        }

        // pagination
        $this->pagination = $pagination;
    }
}