<?php

/**
 * This is the model class for table "u_cms_page_content_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsPageContentI18n extends CActiveRecord
{
    /**
     * @see CActiveRecord::scopes()
     */
    public function scopes()
    {
        return array();
    }

    /**
     * @see CActiveRecord::model()
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'u_cms_page_content_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_page_content_id, i18n_id', 'required', 'on' => array('insert', 'update')),
            array('u_cms_page_content_id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_cms_page_content_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('content', 'length', 'max' => 65535),
            array('content', 'type', 'type' => 'string'),

            // search
            array('u_cms_page_content_id, i18n_id, content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id'),
            'uCmsPageContent' => array(self::BELONGS_TO, 'UCmsPageContent', 'u_cms_page_content_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_cms_page_content_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_page_content_id'),
            'i18n_id' => Unitkit::t('unitkit', $this->tableName().':i18n_id'),
            'content' => Unitkit::t('unitkit', $this->tableName().':content'),
        );
    }
}