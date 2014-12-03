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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = 'bCmsPagePageContainerEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_page_container_create_title');
        $this->updateTitle = B::t('backend', 'cms_page_container_update_title');

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
            if (!is_array($d)) {
                if ($this->hasErrors = $d->hasErrors()) {
                    break;
                }
            } else {
                foreach ($d as $i) {
                    if ($this->hasErrors = $i->hasErrors()) {
                        break;
                    }
                }
            }
        }

        // new record status
        $this->isNewRecord = $data['BCmsPage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm'.($this->isNewRecord ? ' active-slug' : ''),
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'b_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select input-ajax-select-layout',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'BCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BCmsPage']->b_cms_layout_id) ? BCmsLayoutI18n::model()->findByPk(array(
                        'b_cms_layout_id' => $data['BCmsPage']->b_cms_layout_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-pageId' => isset($this->pk['id']) ? $this->pk['id'] : null,
                    'data-actionLoadContent' => $this->controller->createUrl(
                        $this->controller->id.'/listContainer'
                    )
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            ))
        );

        if ( ! $this->isNewRecord) {
            $this->items[] = new BItemField(array(
                'label' => B::t('backend', $data['BCmsPage']->tableName().':cacheManagment'),
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
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('html_title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('html_description'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsPageI18n'],
                'attribute' => 'html_keywords',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsPageI18n']->getAttributeLabel('html_keywords'),
                )
            )),
            new BItemField(array(
                'label' => B::t('backend', $data['BCmsPage']->tableName().':pageContainers'),
                'value' => $this->controller->bRenderPartial(
                    'edit/_container',
                    array('dataView' => new PageContainerEditContainersArrayDataView($data)),
                    true
                )
            )),
        ));

        if (! $data['BCmsPage']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsPage']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsPage'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsPage']->updated_at
            ));
        }
    }
}