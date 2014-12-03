<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonEditDataView extends BEditDataView
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
        $this->id = 'bPersonPersonEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_person_create_title');
        $this->updateTitle = B::t('backend', 'right_person_update_title');

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
            if (! is_array($d) && $this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BPerson']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('email')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'password',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('password')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('first_name')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('last_name')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('activated')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'validated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('validated')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'active_reset',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BPerson']->getAttributeLabel('active_reset')
                )
            )),
            new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BPerson']->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $data['BPerson']->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            ))
        );

        if (! $data['BPerson']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'created_at',
                'value' => $data['BPerson']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BPerson'],
                'attribute' => 'updated_at',
                'value' => $data['BPerson']->updated_at
            ));
        }
    }
}