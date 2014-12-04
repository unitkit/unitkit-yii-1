<?php

/**
 * This is the model class for table "u_person_token"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UPersonToken extends CActiveRecord
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
        return 'u_person_token';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_person_id, password, action, expired_at, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('u_person_id', 'type', 'type' => 'integer'),
            array('uuid, password', 'length', 'max' => 64),
            array('uuid, password', 'type', 'type' => 'string'),
            array('action', 'length', 'max' => 64),
            array('action', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),

            // search
            array('id, u_person_id, key, closed_at, created_at, updated_at, action', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uPerson' => array(self::BELONGS_TO, 'UPerson', 'u_person_id', 'joinType' => 'INNER JOIN')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'uuid' => Unitkit::t('unitkit', 'u_person_token:uuid'),
            'u_person_id' => Unitkit::t('unitkit', 'u_person_token:u_person_id'),
            'code' => Unitkit::t('unitkit', 'u_person_token:key'), 'action' => Unitkit::t('unitkit', 'u_person_token:action'),
            'expired_at' => Unitkit::t('unitkit', 'u_person_token:expired_at'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'), 'updated_at' => Unitkit::t('unitkit', $this->tableName().':updated_at')
        );
    }
}