<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RoleListDataView extends UListDataView
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
        $this->id = 'uRoleRoleMain';

        // component title
        $this->title = Unitkit::t('backend', 'right_role_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uRoleI18ns.name',
            'uRole.operation',
            'uRole.business_rule'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_role_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'operation',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'business_rule',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_role_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'operation',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'business_rule',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uRoleVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uRoleVCreatedAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'updated_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uRoleVUpdatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uRoleVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new RoleListRowDataView($d, array(
                'id' => $d->id
            ));
        }

            // pagination
        $this->pagination = $pagination;
    }
}