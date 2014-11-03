<?php

/**
 * This is the model class for table "b_cms_menu_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsMenuI18n extends CActiveRecord
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
        return 'b_cms_menu_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_menu_id, i18n_id, name, url', 'required', 'on' => array('insert', 'update')),
			array('name, url', 'required', 'on' => 'preInsert'),
            array('b_cms_menu_id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_cms_menu_id', 'type', 'type' => 'integer'),
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
            array('b_cms_menu_id, i18n_id, name, url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'i18n_id'),
            'bCmsMenu' => array(self::BELONGS_TO, 'BCmsMenu', 'b_cms_menu_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_cms_menu_id' => B::t('unitkit', $this->tableName().':b_cms_menu_id'),
            'i18n_id' => B::t('unitkit', $this->tableName().':i18n_id'),
            'name' => B::t('unitkit', $this->tableName().':name'),
            'url' => B::t('unitkit', $this->tableName().':url'),
        );
    }
}