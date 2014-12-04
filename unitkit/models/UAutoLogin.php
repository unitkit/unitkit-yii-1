<?php

/**
 * This is the model class for table "u_auto_login"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UAutoLogin extends CActiveRecord
{
    // virtual attributes
    public $v_expired_at_start;
    public $v_expired_at_end;
    public $v_created_at_start;
    public $v_created_at_end;

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
        return 'u_auto_login';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_person_id, key1, key2, duration, expired_at, created_at', 'required', 'on' => array('insert', 'update')),
            array('created_at', 'unsafe'),
            array('uuid', 'unsafe', 'on' => array('insert', 'update')),
            array('uuid', 'length', 'max' => 64),
            array('uuid', 'type', 'type' => 'string'),
            array('u_person_id', 'type', 'type' => 'integer'),
            array('key1', 'length', 'max' => 64),
            array('key1', 'type', 'type' => 'string'),
            array('key2', 'length', 'max' => 64),
            array('key2', 'type', 'type' => 'string'),
            array('duration', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),

            // search
            array('id, uuid, u_person_id, key1, key2, duration, v_expired_at_start, v_expired_at_end, v_created_at_start, v_created_at_end',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array('uPerson' => array(self::BELONGS_TO, 'UPerson', 'u_person_id'));
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'uuid' => Unitkit::t('unitkit', 'u_auto_login:uuid'),
            'u_person_id' => Unitkit::t('unitkit', 'u_auto_login:u_person_id'),
            'key1' => Unitkit::t('unitkit', 'u_auto_login:key1'), 'key2' => Unitkit::t('unitkit', 'u_auto_login:key2'),
            'duration' => Unitkit::t('unitkit', 'u_auto_login:duration'),
            'expired_at' => Unitkit::t('unitkit', 'u_auto_login:expired_at'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),

            // related attributes
            'lk_u_person_first_name' => UPerson::model()->getAttributeLabel('first_name')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @param string i18n ID
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($i18nId)
    {
        $criteria = $this->getDbCriteria();
        $criteria->alias = 'uAutoLogin';
        $criteria->with = array(
            'uPerson' => array(
                'select' => 'email, first_name, last_name', 'alias' => 'uPerson',
                'joinType' => 'LEFT JOIN', 'together' => 'uAutoLogin'
            )
        );

        if ($this->validate()) {
            $criteria->compare('uAutoLogin.uuid', $this->uuid);
            $criteria->compare('uAutoLogin.u_person_id', $this->u_person_id);
            $criteria->compare('uAutoLogin.key1', $this->key1, true);
            $criteria->compare('uAutoLogin.key2', $this->key2, true);
            $criteria->compare('uAutoLogin.duration', $this->duration);
            if ($this->v_expired_at_start != '') {
                $criteria->addCondition('uAutoLogin.expired_at >= :v_expired_at_start');
                $criteria->params += array(':v_expired_at_start' => $this->v_expired_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uAutoLogin.created_at <= DATE_ADD(:v_expired_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_expired_at_end' => $this->v_expired_at_end);
            }
            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uAutoLogin.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uAutoLogin.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uAutoLogin.created_at' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uAutoLogin.uuid' => array('label' => $this->getAttributeLabel('uuid')),
                        'uAutoLogin.u_person_id' => array('label' => $this->getAttributeLabel('u_person_id')),
                        'uAutoLogin.key1' => array('label' => $this->getAttributeLabel('key1')),
                        'uAutoLogin.key2' => array('label' => $this->getAttributeLabel('key2')),
                        'uAutoLogin.duration' => array('label' => $this->getAttributeLabel('duration')),
                        'uAutoLogin.expired_at' => array('label' => $this->getAttributeLabel('expired_at')),
                        'uAutoLogin.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uPerson.first_name' => array('label' => $this->getAttributeLabel('lk_u_person_first_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}