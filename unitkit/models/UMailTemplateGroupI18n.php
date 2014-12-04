<?php

/**
 * This is the model class for table "u_mail_template_group_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMailTemplateGroupI18n extends CActiveRecord
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
        return 'u_mail_template_group_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_mail_template_group_id, i18n_id, name', 'required', 'on' => array('insert', 'update')),
            array('name', 'required', 'on' => 'preInsert'),
            array('u_mail_template_group_id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_mail_template_group_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('name', 'length', 'max' => 255),
            array('name', 'type', 'type' => 'string'),

            // search
            array('u_mail_template_group_id, i18n_id, name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id'),
            'uMailTemplateGroup' => array(self::BELONGS_TO, 'UMailTemplateGroup', 'u_mail_template_group_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_mail_template_group_id' => Unitkit::t('unitkit', 'u_mail_template_group_i18n:u_mail_template_group_id'),
            'i18n_id' => Unitkit::t('unitkit', 'u_mail_template_group_i18n:i18n_id'),
            'name' => Unitkit::t('unitkit', 'u_mail_template_group_i18n:name')
        );
    }
}