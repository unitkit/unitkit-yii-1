<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class RoleEditDataView extends UEditDataView
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
        $this->id = 'uRoleRoleEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'right_role_create_title');
        $this->updateTitle = Unitkit::t('backend', 'right_role_update_title');

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
        $this->isNewRecord = $data['URole']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['URoleI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['URoleI18n']->getAttributeLabel('name')
                )
            )),
            new UItemField(array(
                'model' => $data['URole'],
                'attribute' => 'operation',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['URole']->getAttributeLabel('operation')
                )
            )),
            new UItemField(array(
                'model' => $data['URole'],
                'attribute' => 'business_rule',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['URole']->getAttributeLabel('business_rule')
                )
            ))
        );

        if (! $data['URole']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['URole'],
                'attribute' => 'created_at',
                'value' => $data['URole']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['URole'],
                'attribute' => 'updated_at',
                'value' => $data['URole']->updated_at
            ));
        }
    }
}