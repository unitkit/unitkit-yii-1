<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsEditDataView extends UEditDataView
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
        $this->id = 'uCmsNewsNewsEdit';

        // component title
        $this->createTitle = Unitkit::t('backend', 'cms_news_create_title');
        $this->updateTitle = Unitkit::t('backend', 'cms_news_update_title');

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
        $this->isNewRecord = $data['UCmsNews']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['UCmsNews'],
                'attribute' => 'u_cms_news_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'UCmsNewsGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['UCmsNews']->u_cms_news_group_id) ? UCmsNewsGroupI18n::model()->findByPk(array(
                        'u_cms_news_group_id' => $data['UCmsNews']->u_cms_news_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-addAction' => $this->controller->createUrl('newsGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('newsGroup/update'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsNewsI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsNewsI18n']->getAttributeLabel('title'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsNewsI18n'],
                'attribute' => 'content',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'placeholder' => $data['UCmsNewsI18n']->getAttributeLabel('content'),
                    'data-ckeditorFilebrowserBrowseUrl' => Yii::app()->controller->createUrl('/cms/image'),
                    'data-ckeditorLanguage' => Yii::app()->language
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsNews'],
                'attribute' => 'activated',
                'type' => 'activeCheckBox',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['UCmsNews']->getAttributeLabel('activated'),
                )
            )),
            new UItemField(array(
                'model' => $data['UCmsNews'],
                'attribute' => 'published_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'uCmsNewsPublishedAtEdit',
                    'class' => 'form-control input-sm jui-datePicker',
                    'placeholder' => $data['UCmsNews']->getAttributeLabel('published_at'),
                )
            )),
        );

        if (! $data['UCmsNews']->isNewRecord) {
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsNews'],
                'attribute' => 'created_at',
                'value' =>  $data['UCmsNews']->created_at
            ));
            $this->items[] = new UItemField(array(
                'model' => $data['UCmsNews'],
                'attribute' => 'updated_at',
                'value' =>  $data['UCmsNews']->updated_at
            ));
        }
    }
}