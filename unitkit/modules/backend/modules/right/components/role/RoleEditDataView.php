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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        $this->id = 'bRoleRoleEdit';

        // component title
        $this->createTitle = B::t('backend', 'right_role_create_title');
        $this->updateTitle = B::t('backend', 'right_role_update_title');

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
        $this->isNewRecord = $datas['BRole']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BRoleI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BRoleI18n']->getAttributeLabel('name')
                )
            )),
            new BItemField(array(
                'model' => $datas['BRole'],
                'attribute' => 'operation',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BRole']->getAttributeLabel('operation')
                )
            )),
            new BItemField(array(
                'model' => $datas['BRole'],
                'attribute' => 'business_rule',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BRole']->getAttributeLabel('business_rule')
                )
            ))
        );

        if (! $datas['BRole']->isNewRecord) {

            $this->items[] = new BItemField(array(
                'model' => $datas['BRole'],
                'attribute' => 'created_at',
                'value' => $datas['BRole']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BRole'],
                'attribute' => 'updated_at',
                'value' => $datas['BRole']->updated_at
            ));
        }
    }
}