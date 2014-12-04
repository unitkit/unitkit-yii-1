<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginListDataView extends UListDataView
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
        $this->id = 'uAutoLoginAutoLoginMain';

        // component title
        $this->title = Unitkit::t('backend', 'auto_login_auto_login_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uPerson.fullname',
            'uAutoLogin.duration',
            'uAutoLogin.expired_at',
            'uAutoLogin.created_at'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uPersonEmailGridSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[fullname]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_person_id) ? UPerson::model()->findByPk($model->u_person_id)->fullname : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UDateRangeItemField($model, 'expired_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVExpiredAtStartGridSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVExpiredAtEndGridSearch'
                )
            ))),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVCreatedAtStartGridSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVCreatedAtEndGridSearch'
                )
            )))
        );

        // advanced search
        $this->advancedSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'u_person_id',
                'displayAttribute' => UPerson::model()->getAttributeLabel('fullname'),
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'class' => 'input-ajax-select allow-clear',
                    'id' => 'uPersonEmailAdvSearch',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[fullname]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($model->u_person_id) ? UPerson::model()->findByPk($model->u_person_id)->fullname : ''
                )
            )),
            new UItemField(array(
                'model' => $model,
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new UDateRangeItemField($model, 'expired_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVExpiredAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_expired_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVExpiredAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'created_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uAutoLoginVCreatedAtEndAdvSearch'
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