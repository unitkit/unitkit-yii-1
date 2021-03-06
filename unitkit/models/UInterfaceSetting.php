<?php

/**
 * This is the model class for table "u_interface_setting"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UInterfaceSetting extends CActiveRecord
{
    /**
     * Cache duration
     *
     * @var int
     */
    const CACHE_DURATION = 0 /* no limit */;

    /**
     * Maximum number of rows
     */
    const MAX_NB_ROWS = 100;

    /**
     * Default value of page_size column
     *
     * @var int
     */
    public $page_size = 10;

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
        return 'u_interface_setting';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('interface_id, u_person_id, page_size', 'required', 'on' => array('insert', 'update')),
            array('interface_id', 'type', 'type' => 'string'),
            array('interface_id', 'length', 'max' => 64),
            array('u_person_id', 'type', 'type' => 'integer'),
            array('page_size', 'type', 'type' => 'integer'),
            array('page_size', 'numerical', 'allowEmpty' => false, 'integerOnly' => true, 'min' => 1, 'max' => self::MAX_NB_ROWS),

            // search
            array('interface_id, u_person_id, page_size', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uPerson' => array(self::BELONGS_TO, 'UPerson', 'u_person_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'interface_id' => Unitkit::t('unitkit', 'u_interface_setting:interface_id'),
            'u_person_id' => Unitkit::t('unitkit', 'u_interface_setting:u_person_id'),
            'page_size' => Unitkit::t('unitkit', 'u_interface_setting:page_size')
        );
    }

    /**
     * Get key name used in the cache
     */
    protected static function getCacheKeyNamePrefix()
    {
        return 'u_site_i18n_list';
    }

    /**
     * Get person settings about an interface
     *
     * @param int $interface interface ID
     * @param int $person u_person ID
     * @param bool $refresh refresh cache
     * @return CModel
     */
    public function getSettings($interface, $person, $refresh = false)
    {
        // create key
        $key = sha1(self::getCacheKeyNamePrefix() . ':' . $interface . ':' . $person);

        // get model from cache
        $model = $refresh ? false : Yii::app()->cache->get($key);

        // get model from database
        if ($model === false) {
            $model = $this->findByAttributes(
                array('interface_id' => $interface, 'u_person_id' => $person)
            );

            if ($model === null) {
                $model = new self();
                $model->u_person_id = $person;
                $model->interface_id = $interface;
            }

            // set model in cache
            Yii::app()->cache->set($key, $model, self::CACHE_DURATION);
        }

        return $model;
    }

    /**
     * Refresh settings
     *
     * @param int $interface b_interface ID
     * @param int $person u_person ID
     */
    public function refreshSettings($interface, $person)
    {
        // create key
        $key = sha1(self::getCacheKeyNamePrefix() . ':' . $interface . ':' . $person);
        return Yii::app()->cache->delete($key);
    }
}