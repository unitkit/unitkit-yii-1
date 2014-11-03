<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginEditDataView extends BEditDataView
{

    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bAutoLoginAutoLoginEdit';

        // component title
        $this->createTitle = B::t('backend', 'auto_login_auto_login_create_title');
        $this->updateTitle = B::t('backend', 'auto_login_auto_login_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($datas as $data)
            if ($this->hasErrors = $data->hasErrors())
                break;

            // new record status
        $this->isNewRecord = $datas['BAutoLogin']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BPerson[email]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BAutoLogin']->b_person_id) ? BPerson::model()->findByPk($datas['BAutoLogin']->b_person_id)->email : ''
                )
            )),
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'bAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm jui-datePicker',
                    'placeholder' => $datas['BAutoLogin']->getAttributeLabel('expired_at')
                )
            ))
        );

        if (! $datas['BAutoLogin']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BAutoLogin'],
                'attribute' => 'created_at',
                'value' => $datas['BAutoLogin']->created_at
            ));
        }
    }
}