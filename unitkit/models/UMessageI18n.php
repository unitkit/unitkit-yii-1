<?php

/**
 * This is the model class for table "u_message_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMessageI18n extends CActiveRecord
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
        return 'u_message_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_message_id, i18n_id', 'required', 'on' => array('insert', 'update')),
            array('u_message_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('translation', 'length', 'max' => 65535),
            array('translation', 'type', 'type' => 'string'),

            // search
            array('u_message_id, i18n_id, translation', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uMessage' => array(self::BELONGS_TO, 'UMessage', 'u_message_id'),
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_message_id' => Unitkit::t('unitkit', 'u_message_i18n:u_message_id'),
            'i18n_id' => Unitkit::t('unitkit', 'u_message_i18n:i18n_id'),
            'translation' => Unitkit::t('unitkit', 'u_message_i18n:translation')
        );
    }
}