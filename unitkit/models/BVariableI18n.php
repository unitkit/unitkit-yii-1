<?php

/**
 * This is the model class for table "b_variable_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BVariableI18n extends CActiveRecord
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
        return 'b_variable_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_variable_id, i18n_id, description', 'required', 'on' => array('insert', 'update')),
            array('description', 'required', 'on' => 'preInsert'),
            array('b_variable_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_variable_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('description', 'length', 'max' => 65535),
            array('description', 'type', 'type' => 'string'),

            // search
            array('b_variable_id, i18n_id, description', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bVariable' => array(self::BELONGS_TO, 'BVariable', 'b_variable_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_variable_id' => B::t('unitkit', 'b_variable_i18n:b_variable_id'),
            'i18n_id' => B::t('unitkit', 'b_variable_i18n:i18n_id'),
            'description' => B::t('unitkit', 'b_variable_i18n:description')
        );
    }
}