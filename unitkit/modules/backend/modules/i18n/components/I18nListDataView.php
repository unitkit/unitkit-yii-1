<?php

/**
 * Data view of list interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class I18nListDataView extends BListDataView
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
        $this->id = 'bI18nI18nMain';

        // component title
        $this->title = B::t('backend', 'i18n_i18n_list_title');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(
            'bI18nI18ns.name',
            'bI18n.id'
        );

        // search
        $this->gridSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_i18n_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'id',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
        );

        // advanced search
        $this->advancedSearch = array(
            new BItemField(array(
                'model' => $model,
                'attribute' => 'id',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            )),
            new BItemField(array(
                'model' => $model,
                'attribute' => 'lk_b_i18n_i18ns_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => B::t('unitkit', 'input_search'),
                    'id' => false
                )
            ))
        );

        // rows
        foreach ($data as $d) {
            $this->rows[] = new I18nListRowDataView($d, array(
                'id' => $d->id
            ));
        }

        // pagination
        $this->pagination = $pagination;
    }
}