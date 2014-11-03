<?php

/**
 * This is the model class for table "b_i18n_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BI18nI18n extends CActiveRecord
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
        return 'b_i18n_i18n';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_i18n_id, i18n_id, name', 'required',
                'on' => array('insert', 'update')),
            array('name', 'required', 'on' => 'preInsert'),
            array('b_i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_i18n_id', 'length', 'max' => 16),
            array('b_i18n_id', 'type', 'type' => 'string'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('name', 'length', 'max' => 255),
            array('name', 'type', 'type' => 'string'),

            // search
            array('b_i18n_id, i18n_id, name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'b_i18n_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_i18n_id' => B::t('unitkit', 'b_i18n_i18n:b_i18n_id'),
            'i18n_id' => B::t('unitkit', 'b_i18n_i18n:i18n_id'),
            'name' => B::t('unitkit', 'b_i18n_i18n:name')
        );
    }
}