<?php

/**
 * This is the model class for table "b_person"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BPerson extends CActiveRecord
{
    // virtual attributes
    public $v_created_at_start;
    public $v_created_at_end;
    public $v_updated_at_start;
    public $v_updated_at_end;

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
        return 'b_person';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('email, activated, validated, default_language, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('email', 'emailExist', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('email', 'length', 'max' => 255),
            array('email', 'type', 'type' => 'string'),
            array('email', 'email', 'allowEmpty' => false, 'checkMX' => true, 'on' => array('insert', 'update')),
            array('password', 'length', 'max' => 200),
            array('password', 'type', 'type' => 'string'),
            array('first_name', 'length', 'max' => 50, 'min' => 2),
            array('first_name', 'type', 'type' => 'string'),
            array('last_name', 'length', 'max' => 50),
            array('last_name', 'type', 'type' => 'string'),
            array('activated', 'boolean', 'on' => array('insert', 'update')),
            array('validated', 'boolean', 'on' => array('insert', 'update')),
            array('active_reset', 'boolean', 'on' => array('insert', 'update')),
            array('default_language', 'length', 'max' => 16),
            array('default_language', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, email, password, first_name, last_name, activated, validated, default_language, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     * @see BPerson::beforeSave()
     */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->password == '')
                unset($this->password);
            else
                $this->password = CPasswordHelper::hashPassword($this->password, 13);

            return true;
        }

        return false;
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bI18n' => array(self::BELONGS_TO, 'BI18n', 'default_language'),
            'bI18nI18ns' => array(self::HAS_MANY, 'BI18nI18n', array('b_i18n_id' => 'default_language')),
            'bAutoLogins' => array(self::HAS_MANY, 'BAutoLogin', 'b_person_id'),
            'bInterfaceSettings' => array(self::HAS_MANY, 'BInterfaceSetting', 'b_person_id'),
            'bMailSendingRoles' => array(self::HAS_MANY, 'BMailSendingRole', 'b_person_id'),
            'bPersonGroups' => array(self::HAS_MANY, 'BPersonGroup', 'b_person_id'),
            'bPersonTokens' => array(self::HAS_MANY, 'BPersonToken', 'b_person_id')
        );
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get BPerson from BAutoLogin uuid
     *
     * @param string $uuid Unique ID
     * @return CActiveRecord
     */
    public function getByUUID($uuid)
    {
        return $this->with(
            array(
                'bAutoLogins' => array(
                    'joinType' => 'LEFT JOIN', 'together' => 'b_person',
                    'condition' => 'uuid = :uuid AND expired_at > :now',
                    'params' => array(':uuid' => $uuid, ':now' => date('Y-m-d H:i:s'))
                )
            )
        )->find();
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'email' => B::t('unitkit', 'b_person:email'),
            'password' => B::t('unitkit', 'b_person:password'),
            'first_name' => B::t('unitkit', 'b_person:first_name'),
            'last_name' => B::t('unitkit', 'b_person:last_name'),
            'activated' => B::t('unitkit', 'model:activated'),
            'validated' => B::t('unitkit', 'model:validated'),
            'active_reset' => B::t('unitkit', 'b_person:active_reset'),
            'default_language' => B::t('unitkit', 'b_person:default_language'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_i18n_i18ns_name' => BI18nI18n::model()->getAttributeLabel('name')
        );
    }

    /**
     * Verify if email already exist
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function emailExist($attribute, $params)
    {
        $person = $this->find(
            array(
                'select' => 'id',
                'condition' => 'email = :email AND id <> :id',
                'params' => array(':email' => $this->email, ':id' => $this->id)
            )
        );

        if ($person !== null)
            $this->addError('email', B::t('backend', 'b_person_email_exist'));
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
        $criteria->alias = 'bPerson';
        $criteria->with = array(
            'bI18nI18ns' => array(
                'select' => 'name',
                'alias' => 'bI18nI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bPerson',
                'on' => 'bI18nI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bPerson.id', $this->id);
            $criteria->compare('bPerson.email', $this->email, true);
            $criteria->compare('bPerson.password', $this->password, true);
            $criteria->compare('bPerson.first_name', $this->first_name, true);
            $criteria->compare('bPerson.last_name', $this->last_name, true);
            $criteria->compare('bPerson.activated', $this->activated);
            $criteria->compare('bPerson.validated', $this->validated);
            $criteria->compare('bPerson.active_reset', $this->active_reset);
            $criteria->compare('bPerson.default_language', $this->default_language, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bPerson.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bPerson.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('bPerson.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('bPerson.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bPerson.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bPerson.id' => array('label' => $this->getAttributeLabel('id')),
                        'bPerson.email' => array('label' => $this->getAttributeLabel('email')),
                        'bPerson.password' => array('label' => $this->getAttributeLabel('password')),
                        'bPerson.first_name' => array('label' => $this->getAttributeLabel('first_name')),
                        'bPerson.last_name' => array('label' => $this->getAttributeLabel('last_name')),
                        'bPerson.activated' => array('label' => $this->getAttributeLabel('activated')),
                        'bPerson.validated' => array('label' => $this->getAttributeLabel('validated')),
                        'bPerson.active_reset' => array('label' => $this->getAttributeLabel('validated')),
                        'bPerson.default_language' => array('label' => $this->getAttributeLabel('default_language')),
                        'bPerson.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bPerson.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bI18nI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_i18n_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }

    /**
     * Get Person by email
     *
     * @param string $email
     * @return CActiveRecord
     */
    public function findByEmail($email)
    {
        return $this->find('email = :email', array(':email' => $email));
    }
}