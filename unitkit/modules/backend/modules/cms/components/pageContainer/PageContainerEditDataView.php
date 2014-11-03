<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditDataView extends BEditDataView
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
        $this->id = 'bCmsPagePageContainerEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_page_container_create_title');
        $this->updateTitle = B::t('backend', 'cms_page_container_update_title');

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
        	if( ! is_array($data)) {
        	    if($this->hasErrors = $data->hasErrors())
                    break;
        	} else {
        	    foreach($data as $d)
                    if($this->hasErrors = $d->hasErrors())
                        break;
        	}

        // new record status
        $this->isNewRecord = $datas['BCmsPage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm'.($this->isNewRecord ? ' active-slug' : ''),
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select input-ajax-select-layout',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advCombobox/',
                        array('name' => 'BCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($datas['BCmsPage']->b_cms_layout_id) ? BCmsLayoutI18n::model()->findByPk(array(
                        'b_cms_layout_id' => $datas['BCmsPage']->b_cms_layout_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-pageId' => isset($this->pk['id']) ? $this->pk['id'] : null,
                    'data-actionLoadContent' => $this->controller->createUrl(
                        $this->controller->id.'/listContainer'
                    )
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            ))
        );

        if ( ! $this->isNewRecord) {
            $this->items[] = new BItemField(array(
                'label' => B::t('backend', $datas['BCmsPage']->tableName().':cacheManagment'),
                'value' => BHtml::link(
                    B::t('backend', 'btn_refresh_cms_page'),
                    $this->controller->createUrl($this->controller->id.'/refreshPageCache'),
                    array(
                        'class' => 'btn btn-default btn-refresh-cms-page btn-quick-ajax',
                        'data-targetContainer' => '.refresh-cms-page-status',
                    )
                ).' <div class="refresh-cms-page-status"></div>',
            ));
        }

        $this->items = array_merge($this->items, array(
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_title'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_description'),
                )
            )),
            new BItemField(array(
                'model' => $datas['BCmsPageI18n'],
                'attribute' => 'html_keywords',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BCmsPageI18n']->getAttributeLabel('html_keywords'),
                )
            )),
            new BItemField(array(
                'label' => B::t('backend', $datas['BCmsPage']->tableName().':pageContainers'),
                'value' => $this->controller->bRenderPartial(
                    'edit/_container',
                    array('dataView' => new PageContainerEditContainersArrayDataView($datas)),
                    true
                )
            )),
        ));

        if (! $datas['BCmsPage']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'created_at',
                'value' =>  $datas['BCmsPage']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $datas['BCmsPage'],
                'attribute' => 'updated_at',
                'value' =>  $datas['BCmsPage']->updated_at
            ));
        }
    }
}