<?php

/**
 * This is the model class for table "b_mail_sending_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMailSendingRole extends CActiveRecord
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
        return 'b_mail_sending_role';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_person_id, b_mail_template_id, b_mail_send_role_id', 'required',
                'on' => array('insert', 'update')),
            array('b_person_id', 'type', 'type' => 'integer'),
            array('b_mail_template_id', 'unsafe',
                'on' => array('insert', 'update')),
            array('b_mail_template_id', 'type', 'type' => 'integer'),
            array('b_mail_send_role_id', 'type', 'type' => 'integer'),

            // search
            array('b_person_id, b_mail_template_id, b_mail_send_role_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bPerson' => array(self::BELONGS_TO, 'BPerson', 'b_person_id'),
            'bMailTemplate' => array(self::BELONGS_TO, 'BMailTemplate', 'b_mail_template_id'),
            'bMailSendRole' => array(self::BELONGS_TO, 'BMailSendRole', 'b_mail_send_role_id'),
            'bMailSendRoleI18ns' => array(self::HAS_MANY, 'BMailSendRoleI18n', array('b_mail_send_role_id' => 'b_mail_send_role_id'))
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_person_id' => B::t('unitkit', 'b_person:fullName'),
            'b_mail_template_id' => B::t('unitkit', 'b_mail_sending_role:b_mail_template_id'),
            'b_mail_send_role_id' => B::t('unitkit', 'b_mail_sending_role:b_mail_send_role_id'),

            // related attributes
            'lk_b_person_first_name' => BPerson::model()->getAttributeLabel('first_name'),
            'lk_b_mail_send_role_i18ns_name' => BMailSendRoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bMailSendingRole';
        $criteria->with = array(
            'bPerson' => array(
                'select' => 'first_name, last_name',
                'alias' => 'bPerson',
                'joinType' => 'LEFT JOIN',
                'together' => 'bMailSendingRole'
            ),
            'bMailSendRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'bMailSendRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bMailSendingRole',
                'on' => 'bMailSendRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bMailSendingRole.b_person_id', $this->b_person_id);
            $criteria->compare('bMailSendingRole.b_mail_template_id', $this->b_mail_template_id);
            $criteria->compare('bMailSendingRole.b_mail_send_role_id', $this->b_mail_send_role_id);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'bMailSendingRole.b_person_id' => array('label' => $this->getAttributeLabel('b_person_id')),
                        'bMailSendingRole.b_mail_template_id' => array('label' => $this->getAttributeLabel('b_mail_template_id')),
                        'bMailSendingRole.b_mail_send_role_id' => array('label' => $this->getAttributeLabel('b_mail_send_role_id')),
                        'bPerson.first_name' => array('label' => $this->getAttributeLabel('lk_b_person_first_name')),
                        'bMailSendRoleI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_mail_send_role_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}