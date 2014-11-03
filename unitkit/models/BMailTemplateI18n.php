<?php

/**
 * This is the model class for table "b_mail_template_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMailTemplateI18n extends CActiveRecord
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
        return 'b_mail_template_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_mail_template_id, i18n_id, object, message', 'required', 'on' => array('insert', 'update')),
            array('object, message', 'required', 'on' => 'preInsert'),
            array('b_mail_template_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_mail_template_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('object', 'length', 'max' => 255),
            array('object', 'type', 'type' => 'string'),
            array('message', 'length', 'max' => 65535),
            array('message', 'type', 'type' => 'string'),

            // search
            array('b_mail_template_id, i18n_id, object, message', 'safe', 'on' => 'search'));
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bMailTemplate' => array(self::BELONGS_TO, 'BMailTemplate', 'b_mail_template_id'),
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_mail_template_id' => B::t('unitkit', 'b_mail_template_i18n:b_mail_template_id'),
            'i18n_id' => B::t('unitkit', 'b_mail_template_i18n:i18n_id'),
            'object' => B::t('unitkit', 'b_mail_template_i18n:object'),
            'message' => B::t('unitkit', 'b_mail_template_i18n:message')
        );
    }
}