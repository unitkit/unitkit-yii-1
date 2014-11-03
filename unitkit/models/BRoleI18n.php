<?php

/**
 * This is the model class for table "b_role_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BRoleI18n extends CActiveRecord
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
        return 'b_role_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_role_id, i18n_id, name', 'required', 'on' => array('insert', 'update')),
            array('name', 'required', 'on' => 'preInsert'),
            array('b_role_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_role_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('name', 'length', 'max' => 255),
            array('name', 'type', 'type' => 'string'),

            // search
            array('b_role_id, i18n_id, name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bRole' => array(self::BELONGS_TO, 'BRole', 'b_role_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_role_id' => B::t('unitkit', 'b_role_i18n:b_role_id'),
            'i18n_id' => B::t('unitkit', 'b_role_i18n:i18n_id'),
            'name' => B::t('unitkit', 'model:name')
        );
    }
}