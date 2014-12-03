<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RoleEditDataView extends BEditDataView
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
        $this->id = 'bRoleRoleEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_role_create_title');
        $this->updateTitle = B::t('backend', 'right_role_update_title');

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
        $this->isNewRecord = $data['BRole']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BRoleI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BRoleI18n']->getAttributeLabel('name')
                )
            )),
            new BItemField(array(
                'model' => $data['BRole'],
                'attribute' => 'operation',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BRole']->getAttributeLabel('operation')
                )
            )),
            new BItemField(array(
                'model' => $data['BRole'],
                'attribute' => 'business_rule',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BRole']->getAttributeLabel('business_rule')
                )
            ))
        );

        if (! $data['BRole']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BRole'],
                'attribute' => 'created_at',
                'value' => $data['BRole']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BRole'],
                'attribute' => 'updated_at',
                'value' => $data['BRole']->updated_at
            ));
        }
    }
}