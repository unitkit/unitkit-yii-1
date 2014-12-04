<?php

/**
 * This is the model class for table "u_person"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UPerson extends CActiveRecord
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
        return 'u_person';
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
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, email, password, first_name, last_name, activated, validated, default_language, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     * @see UPerson::beforeSave()
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
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'default_language'),
            'uI18nI18ns' => array(self::HAS_MANY, 'UI18nI18n', array('u_i18n_id' => 'default_language')),
            'uAutoLogins' => array(self::HAS_MANY, 'UAutoLogin', 'u_person_id'),
            'bInterfaceSettings' => array(self::HAS_MANY, 'BInterfaceSetting', 'u_person_id'),
            'uMailSendingRoles' => array(self::HAS_MANY, 'UMailSendingRole', 'u_person_id'),
            'uPersonGroups' => array(self::HAS_MANY, 'UPersonGroup', 'u_person_id'),
            'uPersonTokens' => array(self::HAS_MANY, 'UPersonToken', 'u_person_id')
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
     * Get UPerson from UAutoLogin uuid
     *
     * @param string $uuid Unique ID
     * @return CActiveRecord
     */
    public function getByUUID($uuid)
    {
        return $this->with(
            array(
                'uAutoLogins' => array(
                    'joinType' => 'LEFT JOIN', 'together' => 'u_person',
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
            'id' => Unitkit::t('unitkit', 'model:id'),
            'email' => Unitkit::t('unitkit', 'u_person:email'),
            'password' => Unitkit::t('unitkit', 'u_person:password'),
            'first_name' => Unitkit::t('unitkit', 'u_person:first_name'),
            'last_name' => Unitkit::t('unitkit', 'u_person:last_name'),
            'activated' => Unitkit::t('unitkit', 'model:activated'),
            'validated' => Unitkit::t('unitkit', 'model:validated'),
            'active_reset' => Unitkit::t('unitkit', 'u_person:active_reset'),
            'default_language' => Unitkit::t('unitkit', 'u_person:default_language'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_i18n_i18ns_name' => UI18nI18n::model()->getAttributeLabel('name')
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
            $this->addError('email', Unitkit::t('backend', 'u_person_email_exist'));
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
        $criteria->alias = 'uPerson';
        $criteria->with = array(
            'uI18nI18ns' => array(
                'select' => 'name',
                'alias' => 'uI18nI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uPerson',
                'on' => 'uI18nI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uPerson.id', $this->id);
            $criteria->compare('uPerson.email', $this->email, true);
            $criteria->compare('uPerson.password', $this->password, true);
            $criteria->compare('uPerson.first_name', $this->first_name, true);
            $criteria->compare('uPerson.last_name', $this->last_name, true);
            $criteria->compare('uPerson.activated', $this->activated);
            $criteria->compare('uPerson.validated', $this->validated);
            $criteria->compare('uPerson.active_reset', $this->active_reset);
            $criteria->compare('uPerson.default_language', $this->default_language, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uPerson.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uPerson.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('uPerson.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('uPerson.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uPerson.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uPerson.id' => array('label' => $this->getAttributeLabel('id')),
                        'uPerson.email' => array('label' => $this->getAttributeLabel('email')),
                        'uPerson.password' => array('label' => $this->getAttributeLabel('password')),
                        'uPerson.first_name' => array('label' => $this->getAttributeLabel('first_name')),
                        'uPerson.last_name' => array('label' => $this->getAttributeLabel('last_name')),
                        'uPerson.activated' => array('label' => $this->getAttributeLabel('activated')),
                        'uPerson.validated' => array('label' => $this->getAttributeLabel('validated')),
                        'uPerson.active_reset' => array('label' => $this->getAttributeLabel('validated')),
                        'uPerson.default_language' => array('label' => $this->getAttributeLabel('default_language')),
                        'uPerson.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uPerson.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uI18nI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_i18n_i18ns_name'))
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