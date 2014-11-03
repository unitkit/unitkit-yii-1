<?php

/**
 * This is the model class for table "b_cms_social_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsSocialI18n extends CActiveRecord
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
        return 'b_cms_social_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_social_id, i18n_id', 'required', 'on' => array('insert', 'update')),
            array('b_cms_social_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_cms_social_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('url', 'length', 'max' => 255),
            array('url',  'url'),

            // search
            array('b_cms_social_id, i18n_id, url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsSocial' => array(self::BELONGS_TO, 'BCmsSocial', 'b_cms_social_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_cms_social_id' => B::t('unitkit', $this->tableName().':b_cms_social_id'),
            'i18n_id' => B::t('unitkit', $this->tableName().':i18n_id'),
            'url' => B::t('unitkit', $this->tableName().':url'),
        );
    }
}