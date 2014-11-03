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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsMenuMenuEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_menu_create_title');
        $this->updateTitle = B::t('backend', 'cms_menu_update_title');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($datas as $data)
        	if($this->hasErrors = $data->hasErrors())
        		break;

        // new record status
        $this->isNewRecord = $datas['BCmsMenu']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'b_cms_menu_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array('name' => 'BCmsMenuGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BCmsMenu']->b_cms_menu_group_id) ? BCmsMenuGroupI18n::model()->findByPk(array(
                                    'b_cms_menu_group_id' => $datas['BCmsMenu']->b_cms_menu_group_id,
                                    'i18n_id' => Yii::app()->language
                                ))->name : '',
                    'data-addAction' => $this->controller->createUrl('menuGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('menuGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'rank',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsMenuI18n']->getAttributeLabel('rank'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenuI18n'],
                'attribute' => 'name',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsMenuI18n']->getAttributeLabel('name'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsMenuI18n'],
                'attribute' => 'url',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm active-slug',
                    'placeholder' => $datas['BCmsMenuI18n']->getAttributeLabel('url'),
                )
            )),
        );

        if (! $datas['BCmsMenu']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsMenu']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsMenu'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsMenu']->updated_at
            ));
        }
    }
}