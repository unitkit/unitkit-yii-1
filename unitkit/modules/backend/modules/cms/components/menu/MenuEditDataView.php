<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuEditDataView extends UEditDataView
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
        $this->id = 'uCmsMenuMenuEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_menu_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_menu_update_title');

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
        $this->isNewRecord = $data['UCmsMenu']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'u_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'UCmsMenuGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UCmsMenu']->u_cms_menu_group_id) ? UCmsMenuGroupI18n::model()->findByPk(array(
                                    'u_cms_menu_group_id' => $data['UCmsMenu']->u_cms_menu_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('menuGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('menuGroup/update'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsMenuI18n']->getAttributeLabel('rank'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenuI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsMenuI18n']->getAttributeLabel('name'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsMenuI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm active-slug',
                    'placeholder' => $data['UCmsMenuI18n']->getAttributeLabel('url'),
                )
            )),
        );

        if (! $data['UCmsMenu']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsMenu']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsMenu'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsMenu']->updated_at
            ));
        }
    }
}