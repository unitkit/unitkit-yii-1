<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginListDataView extends BListDataView
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
        $this->id = 'bAutoLoginAutoLoginMain';

        // component title
        $this->title = B::t('backend', 'auto_login_auto_login_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bPerson.fullname',
            'bAutoLogin.duration',
            'bAutoLogin.expired_at',
            'bAutoLogin.created_at'
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bPersonEmailGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BPerson[fullname]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_person_id) ? BPerson::model()->findByPk($model->b_person_id)->fullname : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BDateRangeItemField($model, 'expired_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVExpiredAtStartGridSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVExpiredAtEndGridSearch'
                )
            ))),
            new BDateRangeItemField($model, 'created_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVCreatedAtStartGridSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVCreatedAtEndGridSearch'
                )
            )))
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'b_person_id',
                'displayAttribute' => BPerson::model()->getAttributeLabel('fullname'),
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'bPersonEmailAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BPerson[fullname]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->b_person_id) ? BPerson::model()->findByPk($model->b_person_id)->fullname : ''
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BDateRangeItemField($model, 'expired_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVExpiredAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVExpiredAtEndAdvSearch'
                )
            ))),
            new BDateRangeItemField($model, 'created_at', new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVCreatedAtStartAdvSearch'
                )
            )), new BItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => 'bAutoLoginVCreatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new AutoLoginListRowDataView($d, array(
                'uuid' => $d->uuid
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}