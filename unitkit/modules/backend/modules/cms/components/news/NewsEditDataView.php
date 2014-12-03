<?php

/**
 * Data view of edit interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsEditDataView extends BEditDataView
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
        $this->id = 'bCmsNewsNewsEdit';

        // component title
        $this->createTitle = B::t('backend', 'cms_news_create_title');
        $this->updateTitle = B::t('backend', 'cms_news_update_title');

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
        $this->isNewRecord = $data['BCmsNews']->isNewRecord;

        // page title
        $this->refreshPageTitle();

        // items
        $this->items = array(
            new BItemField(array(
                'model' => $data['BCmsNews'],
                'attribute' => 'b_cms_news_group_id',
                'type' => 'activeHiddenField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => $this->controller->createUrl(
                        $this->controller->id.'/advComboBox/',
                        array('name' => 'BCmsNewsGroupI18n[name]', 'language' => Yii::app()->language)
                    ),
                    'data-placeholder' => B::t('unitkit', 'input_select'),
                    'data-text' => ! empty($data['BCmsNews']->b_cms_news_group_id) ? BCmsNewsGroupI18n::model()->findByPk(array(
                        'b_cms_news_group_id' => $data['BCmsNews']->b_cms_news_group_id,
                        'i18n_id' => Yii::app()->language
                    ))->name : '',
                    'data-addAction' => $this->controller->createUrl('newsGroup/create'),
                    'data-updateAction' => $this->controller->createUrl('newsGroup/update'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsNewsI18n'],
                'attribute' => 'title',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsNewsI18n']->getAttributeLabel('title'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsNewsI18n'],
                'attribute' => 'content',
                'type' => 'activeTextArea',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm advanced-textarea',
                    'placeholder' => $data['BCmsNewsI18n']->getAttributeLabel('content'),
                    'data-ckeditorFilebrowserBrowseUrl' => Yii::app()->controller->createUrl('/cms/image'),
                    'data-ckeditorLanguage' => Yii::app()->language
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsNews'],
                'attribute' => 'activated',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => false,
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BCmsNews']->getAttributeLabel('activated'),
                )
            )),
            new BItemField(array(
                'model' => $data['BCmsNews'],
                'attribute' => 'published_at',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'id' => 'bCmsNewsPublishedAtEdit',
                    'class' => 'form-control input-sm jui-datePicker',
                    'placeholder' => $data['BCmsNews']->getAttributeLabel('published_at'),
                )
            )),
        );

        if (! $data['BCmsNews']->isNewRecord) {
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsNews'],
                'attribute' => 'created_at',
                'value' =>  $data['BCmsNews']->created_at
            ));
            $this->items[] = new BItemField(array(
                'model' => $data['BCmsNews'],
                'attribute' => 'updated_at',
                'value' =>  $data['BCmsNews']->updated_at
            ));
        }
    }
}