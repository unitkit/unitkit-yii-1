<?php

/**
 * Model of person profil
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PersonProfile extends CActiveRecord
{
    public $repeat_password;
    public $old_password;

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
        return 'u_person';
    }

    /**
     * @see UPerson::rules()
     */
    public function rules()
    {
        return array(
            // save
            array(
                'email, first_name, last_name, default_language, created_at, updated_at',
                'required'
            ),
            array(
                'activated, validated, active_reset, created_at',
                'unsafe'
            ),
            array(
                'old_password, repeat_password',
                'safe'
            ),
            array(
                'email',
                'emailExist'
            ),
            array(
                'old_password',
                'verifyOldPassword'
            ),
            array(
                'password',
                'comparePassword'
            ),
            array(
                'id',
                'type',
                'type' => 'integer'
            ),
            array(
                'email',
                'length',
                'max' => 255
            ),
            array(
                'email',
                'type',
                'type' => 'string'
            ),
            array(
                'email',
                'email',
                'allowEmpty' => false,
                'checkMX' => true
            ),
            array(
                'password',
                'length',
                'min' => 6,
                'max' => 200
            ),
            array(
                'password',
                'type',
                'type' => 'string'
            ),
            array(
                'first_name',
                'length',
                'max' => 50,
                'min' => 2
            ),
            array(
                'first_name',
                'type',
                'type' => 'string'
            ),
            array(
                'last_name',
                'length',
                'max' => 50
            ),
            array(
                'last_name',
                'type',
                'type' => 'string'
            ),
            array(
                'activated',
                'boolean'
            ),
            array(
                'default_language',
                'length',
                'max' => 16
            ),
            array(
                'default_language',
                'type',
                'type' => 'string'
            ),
            array(
                'created_at',
                'default',
                'value' => UTools::now(),
                'setOnEmpty' => false,
                'on' => 'insert'
            ),
            array(
                'updated_at',
                'default',
                'value' => UTools::now(),
                'setOnEmpty' => false,
                'on' => array(
                    'update',
                    'insert'
                )
            ),
            array(
                'first_name, last_name, email',
                'filter',
                'filter' => function ($v)
                {
                    return strip_tags($v);
                }
            ),
            // search
            array(
                'id, email, password, first_name, last_name, activated, default_language, created_at, updated_at',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array();
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'email' => Unitkit::t('unitkit', 'u_person:email'),
            'first_name' => Unitkit::t('unitkit', 'u_person:first_name'),
            'last_name' => Unitkit::t('unitkit', 'u_person:last_name'),
            'activated' => Unitkit::t('unitkit', 'u_person:activated'),
            'validated' => Unitkit::t('unitkit', 'u_person:validated'),
            'default_language' => Unitkit::t('unitkit', 'u_person:default_language'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            'password' => Unitkit::t('backend', 'person_profile:password'),
            'repeat_password' => Unitkit::t('backend', 'person_profile:repeat_password'),
            'old_password' => Unitkit::t('backend', 'person_profile:old_password'),

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
        $model = $this->find(array(
            'select' => 'id',
            'condition' => 'email = :email AND id <> :id',
            'params' => array(
                ':email' => $this->email,
                ':id' => $this->id
            )
        ));

        if ($model !== null) {
            $this->addError('email', Unitkit::t('backend', 'u_person_email_exist'));
        }
    }

    /**
     * @see UPerson::beforeSave()
     */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->old_password == '' || $this->repeat_password == '' || $this->password == '') {
                unset($this->password);
            } else {
                $this->password = CPasswordHelper::hashPassword($this->password, 13);
            }

            return true;
        } else
            return false;
    }

    /**
     * Compare passwords fields to update
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function comparePassword($attribute, $params)
    {
        if ($this->old_password != '' || $this->repeat_password != '' || $this->password != '') {
            if ($this->repeat_password === '' || $this->password === '') {
                $this->addError('repeat_password', null);
                $this->addError('password', null);
                $this->addError('old_password', null);
                $this->addError('', Unitkit::t('backend', 'profile_password_is_required'));
            }

            $compare = new CCompareValidator();
            $compare->attributes[] = 'repeat_password';
            $compare->compareAttribute = 'password';
            $compare->validate($this);
        }
    }

    /**
     * Verify old password
     *
     * @param mixed $attribute
     * @param mixed $params
     * @throws Exception
     */
    public function verifyOldPassword($attribute, $params)
    {
        if ($this->old_password != '' || $this->repeat_password != '' || $this->password != '') {
            $model = $this->findByPk($this->id);
            if ($model === null) {
                throw new Exception();
            } elseif (! CPasswordHelper::verifyPassword($this->old_password, $model->password)) {
                $this->addError('old_password', Unitkit::t('backend', 'profile_old_password_not_valid'));
            }
        }
    }
}