<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditDataView extends UEditDataView
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
        $this->id = 'uCmsPagePageContainerEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_page_container_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_page_container_update_title');

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
        $this->isNewRecord = $data['UCmsPage']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'id',
                'type' => 'resolveValue'
            )),
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm'.($this->isNewRecord ? ' active-slug' : ''),
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'u_cms_layout_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select input-ajax-select-layout',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'UCmsLayoutI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UCmsPage']->u_cms_layout_id) ? UCmsLayoutI18n::model()->findByPk(array(
                        'u_cms_layout_id' => $data['UCmsPage']->u_cms_layout_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-pageId' => isset($this->pk['id']) ? $this->pk['id'] : null,
                    'data-actionLoadContent' => $this->controller->createUrl(
                        $this->controller->id.'/listContainer'
                    )
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'slug',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('slug'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPage']->getAttributeLabel('activated'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'cache_duration',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('cache_duration'),
                )
            ))
        );

        if ( ! $this->isNewRecord) {
            $this->items[] = new UItemField(array(
                'label' => Unitkit::t('backend', $data['UCmsPage']->tableName().':cacheManagment'),
                'value' => UHtml::link(
                    Unitkit::t('backend', 'btn_refresh_cms_page'),
                    $this->controller->createUrl($this->controller->id.'/refreshPageCache'),
                    array(
                        'class' => 'btn btn-default btn-refresh-cms-page btn-quick-ajax',
                        'data-targetContainer' => '.refresh-cms-page-status',
                    )
                ).' <div class="refresh-cms-page-status"></div>',
            ));
        }

        $this->items = array_merge($this->items, array(
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'html_title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('html_title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'html_description',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('html_description'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsPageI18n'],
                'attribute' => 'html_keywords',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsPageI18n']->getAttributeLabel('html_keywords'),
                )
            )),
            new UItemField(array(
                'label' => Unitkit::t('backend', $data['UCmsPage']->tableName().':pageContainers'),
                'value' => $this->controller->bRenderPartial(
                    'edit/_container',
                    array('dataView' => new PageContainerEditContainersArrayDataView($data)),
                    true
                )
            )),
        ));

        if (! $data['UCmsPage']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsPage']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsPage'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsPage']->updated_at
            ));
        }
    }
}