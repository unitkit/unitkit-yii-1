<?php

/**
 * This is the model class for table "u_cms_menu_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsMenuI18n extends CActiveRecord
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
        return 'u_cms_menu_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_menu_id, i18n_id, name, url', 'required', 'on' => array('insert', 'update')),
			array('name, url', 'required', 'on' => 'preInsert'),
            array('u_cms_menu_id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_cms_menu_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('name', 'length', 'max' => 100),
            array('name', 'type', 'type' => 'string'),
            array('url', 'length', 'max' => 255),
            array('url', 'type', 'type' => 'string'),
            array('url', 'filter', 'filter' => function($string) {
                $slug = preg_replace('/[^A-Za-z0-9-.:\/]+/', '-', $string);
                return $slug;
            }, 'on' => array('preInsert', 'insert', 'update')),
            // search
            array('u_cms_menu_id, i18n_id, name, url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id'),
            'uCmsMenu' => array(self::BELONGS_TO, 'UCmsMenu', 'u_cms_menu_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_cms_menu_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_menu_id'),
            'i18n_id' => Unitkit::t('unitkit', $this->tableName().':i18n_id'),
            'name' => Unitkit::t('unitkit', $this->tableName().':name'),
            'url' => Unitkit::t('unitkit', $this->tableName().':url'),
        );
    }
}