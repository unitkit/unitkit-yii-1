<?php

/**
 * This is the model class for table "b_person_token"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BPersonToken extends CActiveRecord
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
        return 'b_person_token';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_person_id, password, action, expired_at, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('b_person_id', 'type', 'type' => 'integer'),
            array('uuid, password', 'length', 'max' => 64),
            array('uuid, password', 'type', 'type' => 'string'),
            array('action', 'length', 'max' => 64),
            array('action', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),

            // search
            array('id, b_person_id, key, closed_at, created_at, updated_at, action', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bPerson' => array(self::BELONGS_TO, 'BPerson', 'b_person_id', 'joinType' => 'INNER JOIN')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'uuid' => B::t('unitkit', 'b_person_token:uuid'),
            'b_person_id' => B::t('unitkit', 'b_person_token:b_person_id'),
            'code' => B::t('unitkit', 'b_person_token:key'), 'action' => B::t('unitkit', 'b_person_token:action'),
            'expired_at' => B::t('unitkit', 'b_person_token:expired_at'),
            'created_at' => B::t('unitkit', 'model:created_at'), 'updated_at' => B::t('unitkit', $this->tableName().':updated_at')
        );
    }
}