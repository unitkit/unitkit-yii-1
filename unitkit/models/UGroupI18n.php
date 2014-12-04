<?php

/**
 * This is the model class for table "u_group_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UGroupI18n extends CActiveRecord
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
        return 'u_group_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('i18n_id, name', 'required', 'on' => array('insert', 'update')),
            array('name', 'required', 'on' => 'preInsert'),
            array('u_group_id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_group_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('name', 'length', 'max' => 255),
            array('name', 'type', 'type' => 'string'),

            // search
            array('u_group_id, i18n_id, name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uGroup' => array(self::BELONGS_TO, 'UGroup', 'u_group_id'),
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_group_id' => Unitkit::t('unitkit', 'u_group_i18n:u_group_id'),
            'i18n_id' => Unitkit::t('unitkit', 'u_group_i18n:i18n_id'),
            'name' => Unitkit::t('unitkit', 'model:name')
        );
    }
}