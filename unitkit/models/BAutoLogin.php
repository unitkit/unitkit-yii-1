<?php

/**
 * This is the model class for table "b_auto_login"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BAutoLogin extends CActiveRecord
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
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'b_auto_login';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // save
            array('b_person_id, key1, key2, duration, expired_at, created_at', 'required', 'on' => array('insert', 'update')),
            array('created_at', 'unsafe'),
            array('uuid', 'unsafe', 'on' => array('insert', 'update')),
            array('uuid', 'length', 'max' => 64),
            array('uuid', 'type', 'type' => 'string'),
            array('b_person_id', 'type', 'type' => 'integer'),
            array('key1', 'length', 'max' => 64),
            array('key1', 'type', 'type' => 'string'),
            array('key2', 'length', 'max' => 64),
            array('key2', 'type', 'type' => 'string'),
            array('duration', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),

            // search
            array('id, uuid, b_person_id, key1, key2, duration, v_expired_at_start, v_expired_at_end, v_created_at_start, v_created_at_end',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        return array('bPerson' => array(self::BELONGS_TO, 'BPerson', 'b_person_id'));
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'uuid' => B::t('unitkit', 'b_auto_login:uuid'),
            'b_person_id' => B::t('unitkit', 'b_auto_login:b_person_id'),
            'key1' => B::t('unitkit', 'b_auto_login:key1'), 'key2' => B::t('unitkit', 'b_auto_login:key2'),
            'duration' => B::t('unitkit', 'b_auto_login:duration'),
            'expired_at' => B::t('unitkit', 'b_auto_login:expired_at'),
            'created_at' => B::t('unitkit', 'model:created_at'),

            // related attributes
            'lk_b_person_first_name' => BPerson::model()->getAttributeLabel('first_name')
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
        $criteria->alias = 'bAutoLogin';
        $criteria->with = array(
            'bPerson' => array(
                'select' => 'email, first_name, last_name', 'alias' => 'bPerson',
                'joinType' => 'LEFT JOIN', 'together' => 'bAutoLogin'
            )
        );

        if ($this->validate()) {
            $criteria->compare('bAutoLogin.uuid', $this->uuid);
            $criteria->compare('bAutoLogin.b_person_id', $this->b_person_id);
            $criteria->compare('bAutoLogin.key1', $this->key1, true);
            $criteria->compare('bAutoLogin.key2', $this->key2, true);
            $criteria->compare('bAutoLogin.duration', $this->duration);
            if ($this->v_expired_at_start != '') {
                $criteria->addCondition('bAutoLogin.expired_at >= :v_expired_at_start');
                $criteria->params += array(':v_expired_at_start' => $this->v_expired_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bAutoLogin.created_at <= DATE_ADD(:v_expired_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_expired_at_end' => $this->v_expired_at_end);
            }
            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bAutoLogin.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bAutoLogin.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bAutoLogin.created_at' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bAutoLogin.uuid' => array('label' => $this->getAttributeLabel('uuid')),
                        'bAutoLogin.b_person_id' => array('label' => $this->getAttributeLabel('b_person_id')),
                        'bAutoLogin.key1' => array('label' => $this->getAttributeLabel('key1')),
                        'bAutoLogin.key2' => array('label' => $this->getAttributeLabel('key2')),
                        'bAutoLogin.duration' => array('label' => $this->getAttributeLabel('duration')),
                        'bAutoLogin.expired_at' => array('label' => $this->getAttributeLabel('expired_at')),
                        'bAutoLogin.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bPerson.first_name' => array('label' => $this->getAttributeLabel('lk_b_person_first_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}