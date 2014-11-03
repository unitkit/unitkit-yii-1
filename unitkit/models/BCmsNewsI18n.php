<?php

/**
 * This is the model class for table "b_cms_news_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsNewsI18n extends CActiveRecord
{
    /**
     * @see CActiveRecord::scopes()
     */
    public function scopes()
    {
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Post the static model class
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
        return 'b_cms_news_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_news_id, i18n_id, title, content', 'required', 'on' => array('insert', 'update')),
			array('title, content', 'required', 'on' => 'preInsert'),
            array('b_cms_news_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_cms_news_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('title', 'length', 'max' => 200),
            array('title', 'type', 'type' => 'string'),
            array('content', 'length', 'max' => 65535),
            array('content', 'type', 'type' => 'string'),

            // search
            array('b_cms_news_id, i18n_id, title, content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsNews' => array(self::BELONGS_TO, 'BCmsNews', 'b_cms_news_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_cms_news_id' => B::t('unitkit', $this->tableName().':b_cms_news_id'),
            'i18n_id' => B::t('unitkit', $this->tableName().':i18n_id'),
            'title' => B::t('unitkit', $this->tableName().':title'),
            'content' => B::t('unitkit', $this->tableName().':content'),
        );
    }
}