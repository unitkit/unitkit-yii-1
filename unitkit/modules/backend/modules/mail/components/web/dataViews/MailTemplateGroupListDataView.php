<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateGroupListDataView extends UListDataView
{

    /**
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
        $this->id = 'uMailTemplateGroupMailTemplateGroupMain';

        // component title
        $this->title = Unitkit::t('backend', 'mail_mail_template_group_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'uMailTemplateGroupI18ns.name'
        );

        // search
        $this->gridSearch = array(
            new UItemField(array(
                'model' => $model,
                'attribute' => 'lk_u_mail_template_group_i18ns_name',
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
                'attribute' => 'lk_u_mail_template_group_i18ns_name',
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
                    'id' => 'uMailTemplateGroupVCreatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_created_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateGroupVCreatedAtEndAdvSearch'
                )
            ))),
            new UDateRangeItemField($model, 'updated_at', new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_start',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateGroupVUpdatedAtStartAdvSearch'
                )
            )), new UItemField(array(
                'model' => $model,
                'attribute' => 'v_updated_at_end',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm date-picker date-range',
                    'placeholder' => Unitkit::t('unitkit', 'input_search'),
                    'id' => 'uMailTemplateGroupVUpdatedAtEndAdvSearch'
                )
            )))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new MailTemplateGroupListRowDataView($d, array(
                'id' => $d->id
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}