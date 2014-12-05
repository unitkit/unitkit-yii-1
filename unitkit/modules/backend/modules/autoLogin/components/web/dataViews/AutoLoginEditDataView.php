<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginEditDataView extends UEditDataView
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
        $this->id = 'uAutoLoginAutoLoginEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'auto_login_auto_login_create_title');
        $this->updateTitle = Unitkit::t('backend', 'auto_login_auto_login_update_title');

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
        $this->isNewRecord = $data['UAutoLogin']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'u_person_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl($this->controller->id . '/advComboBox/', array(
                        'name' => 'UPerson[email]'
                    )),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UAutoLogin']->u_person_id) ? UPerson::model()->findByPk($data['UAutoLogin']->u_person_id)->email : ''
                )
            )),
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UAutoLogin']->getAttributeLabel('duration')
                )
            )),
            new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'expired_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'uAutoLoginExpiredAtEdit',
                    'class' => 'form-control input-sm jui-datePicker',
                    'placeholder' => $data['UAutoLogin']->getAttributeLabel('expired_at')
                )
            ))
        );

        if (! $data['UAutoLogin']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UAutoLogin'],
                'attribute' => 'created_at',
                'value' => $data['UAutoLogin']->created_at
            ));
        }
    }
}