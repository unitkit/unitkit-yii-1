<?php

/**
 * This is the model class for table "u_mail_sending_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMailSendingRole extends CActiveRecord
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
        return 'u_mail_sending_role';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_person_id, u_mail_template_id, u_mail_send_role_id', 'required',
                'on' => array('insert', 'update')),
            array('u_person_id', 'type', 'type' => 'integer'),
            array('u_mail_template_id', 'unsafe',
                'on' => array('insert', 'update')),
            array('u_mail_template_id', 'type', 'type' => 'integer'),
            array('u_mail_send_role_id', 'type', 'type' => 'integer'),

            // search
            array('u_person_id, u_mail_template_id, u_mail_send_role_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uPerson' => array(self::BELONGS_TO, 'UPerson', 'u_person_id'),
            'uMailTemplate' => array(self::BELONGS_TO, 'UMailTemplate', 'u_mail_template_id'),
            'uMailSendRole' => array(self::BELONGS_TO, 'UMailSendRole', 'u_mail_send_role_id'),
            'uMailSendRoleI18ns' => array(self::HAS_MANY, 'UMailSendRoleI18n', array('u_mail_send_role_id' => 'u_mail_send_role_id'))
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_person_id' => Unitkit::t('unitkit', 'u_person:fullName'),
            'u_mail_template_id' => Unitkit::t('unitkit', 'u_mail_sending_role:u_mail_template_id'),
            'u_mail_send_role_id' => Unitkit::t('unitkit', 'u_mail_sending_role:u_mail_send_role_id'),

            // related attributes
            'lk_u_person_first_name' => UPerson::model()->getAttributeLabel('first_name'),
            'lk_u_mail_send_role_i18ns_name' => UMailSendRoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uMailSendingRole';
        $criteria->with = array(
            'uPerson' => array(
                'select' => 'first_name, last_name',
                'alias' => 'uPerson',
                'joinType' => 'LEFT JOIN',
                'together' => 'uMailSendingRole'
            ),
            'uMailSendRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'uMailSendRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uMailSendingRole',
                'on' => 'uMailSendRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uMailSendingRole.u_person_id', $this->u_person_id);
            $criteria->compare('uMailSendingRole.u_mail_template_id', $this->u_mail_template_id);
            $criteria->compare('uMailSendingRole.u_mail_send_role_id', $this->u_mail_send_role_id);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'uMailSendingRole.u_person_id' => array('label' => $this->getAttributeLabel('u_person_id')),
                        'uMailSendingRole.u_mail_template_id' => array('label' => $this->getAttributeLabel('u_mail_template_id')),
                        'uMailSendingRole.u_mail_send_role_id' => array('label' => $this->getAttributeLabel('u_mail_send_role_id')),
                        'uPerson.first_name' => array('label' => $this->getAttributeLabel('lk_u_person_first_name')),
                        'uMailSendRoleI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_mail_send_role_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}