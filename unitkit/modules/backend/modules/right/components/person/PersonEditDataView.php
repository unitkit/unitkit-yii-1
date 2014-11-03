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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bPersonPersonEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_person_create_title');
        $this->updateTitle = B::t('backend', 'right_person_update_title');

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
            if (! is_array($data) && $this->hasErrors = $data->hasErrors())
                break;

        // new record status
        $this->isNewRecord = $datas['BPerson']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'email',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('email')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'password',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('password')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'first_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('first_name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'last_name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('last_name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('activated')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'validated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('validated')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'active_reset',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BPerson']->getAttributeLabel('active_reset')
                )
            )),
            new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'default_language',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advCombobox/', array(
                        'name' => 'BI18nI18n[name]',
                        'language' => Yii::app()->language
                    )),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BPerson']->default_language) ? BI18nI18n::model()->findByPk(array(
                        'b_i18n_id' => $datas['BPerson']->default_language,
                        'i18n_id' => Yii::app()->language
                    ))->name : ''
                )
            ))
        );

        if (! $datas['BPerson']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'created_at',
                'value' => $datas['BPerson']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BPerson'],
                'attribute' => 'updated_at',
                'value' => $datas['BPerson']->updated_at
            ));
        }
    }
}