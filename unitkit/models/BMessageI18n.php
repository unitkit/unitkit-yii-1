<?php

/**
 * This is the model class for table "b_message_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMessageI18n extends CActiveRecord
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
        return 'b_message_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_message_id, i18n_id', 'required', 'on' => array('insert', 'update')),
            array('b_message_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('translation', 'length', 'max' => 65535),
            array('translation', 'type', 'type' => 'string'),

            // search
            array('b_message_id, i18n_id, translation', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bMessage' => array(self::BELONGS_TO, 'BMessage', 'b_message_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_message_id' => B::t('unitkit', 'b_message_i18n:b_message_id'),
            'i18n_id' => B::t('unitkit', 'b_message_i18n:i18n_id'),
            'translation' => B::t('unitkit', 'b_message_i18n:translation')
        );
    }
}