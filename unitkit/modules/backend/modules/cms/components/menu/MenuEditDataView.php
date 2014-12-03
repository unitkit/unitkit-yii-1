<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuEditDataView extends BEditDataView
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
        // data view id
        $this->id = 'bCmsMenuMenuEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_menu_create_title');
        $this->updateTitle = B::t('backend', 'cms_menu_update_title');

        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($data as $d) {
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsMenu']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsMenu'],
                'attribute' => 'b_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'BCmsMenuGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BCmsMenu']->b_cms_menu_group_id) ? BCmsMenuGroupI18n::model()->findByPk(array(
                                    'b_cms_menu_group_id' => $data['BCmsMenu']->b_cms_menu_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('menuGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('menuGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsMenu'],
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsMenuI18n']->getAttributeLabel('rank'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsMenuI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsMenuI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsMenuI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm active-slug',
                    'placeholder' => $data['BCmsMenuI18n']->getAttributeLabel('url'),
                )
            )),
        );

        if (! $data['BCmsMenu']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsMenu'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsMenu']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsMenu'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsMenu']->updated_at
            ));
        }
    }
}