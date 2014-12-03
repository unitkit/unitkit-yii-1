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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        $this->id = 'bAutoLoginAutoLoginEdit';

        // component title
        $this->createTitle = B::t('backend', 'auto_login_auto_login_create_title');
        $this->updateTitle = B::t('backend', 'auto_login_auto_login_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($data as $d) {
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

            // new record status
        $this->isNewRecord = $data['BAutoLogin']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'b_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BPerson[email]'
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BAutoLogin']->b_person_id) ? BPerson::model()->findByPk($data['BAutoLogin']->b_person_id)->email : ''
                )
            )),
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'bAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm jui-datePicker',
                    'placeholder' => $data['BAutoLogin']->getAttributeLabel('expired_at')
                )
            ))
        );

        if (! $data['BAutoLogin']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BAutoLogin'],
                'attribute' => 'created_at',
                'value' => $data['BAutoLogin']->created_at
            ));
        }
    }
}