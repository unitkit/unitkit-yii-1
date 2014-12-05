<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuListDataView extends UListDataView
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
        $this->id = 'uCmsMenuMenuMain';

        // component title
        $this->title = Unitkit::t('backend', 'cms_menu_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uCmsMenuGroupI18ns.name',
            'uCmsMenu.rank',
            'uCmsMenuI18ns.name',
            'uCmsMenuI18ns.url',
        );

        // controller
        $controller = Yii::app()->controller;

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                	'class' => 'input-ajax-select allow-clear',
                	'id' => 'uCmsMenuGroupI18nNameGridSearch',
                	'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsMenuGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                	),
                	'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                	'data-text' =>
                        ! empty($model->u_cms_menu_group_id)
                        ?
                        	UCmsMenuGroupI18n::model()->findByPk(array(
                                'u_cms_menu_group_id' => $model->u_cms_menu_group_id,
                                'i18n_id' => Yii::app()->language
                            ))->name
                        :
                        	''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_menu_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_menu_i18ns_url',
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
                'attribute' => 'u_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uCmsMenuGroupI18nNameAdvSearch',
                    'data-action' => $controller->createUrl(
                        $controller->id.'/advComboBox/',
                        array(
                            'name' => 'UCmsMenuGroupI18n[name]',
            				'language' => Yii::app()->language
                        )
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' =>
                        ! empty($model->u_cms_menu_group_id)
                        ?
                            UCmsMenuGroupI18n::model()->findByPk(array(
                				'u_cms_menu_group_id' => $model->u_cms_menu_group_id,
                				'i18n_id' => Yii::app()->language
                			))->name
                        :
                            ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_menu_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_cms_menu_i18ns_url',
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
                        'id' => 'uCmsMenuVCreatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_created_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsMenuVCreatedAtEndAdvSearch'
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
                        'id' => 'uCmsMenuVUpdatedAtStartAdvSearch'
                    )
                )),
                new UItemField(array(
                    'model' => $model,
                    'attribute' => 'v_updated_at_end',
                    'type' => 'activeTextField',
                    'htmlOptions' => array(
                        'class' => 'form-control input-sm date-picker date-range',
                        'placeholder' => Unitkit::t('unitkit', 'input_search'),
                        'id' => 'uCmsMenuVUpdatedAtEndAdvSearch'
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