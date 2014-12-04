<?php

/**
 * This is the model class for table "u_mail_send_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMailSendRole extends CActiveRecord
{
    // search/sort attributes
    public $lk_uMailSendRoleI18ns_name;

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
        return 'u_mail_send_role';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('created_at', 'unsafe'),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, created_at, updated_at, ss_uMailSendRoleI18ns_name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uMailSendingRoles' => array(self::HAS_MANY, 'UMailSendingRole', 'u_mail_send_role_id'),
            'uMailSendRoleI18ns' => array(self::HAS_MANY, 'UMailSendRoleI18n', 'u_mail_send_role_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // search/sort attributes
            'ss_uMailSendRoleI18ns_name' => UMailSendRoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uMailSendRole';
        $criteria->with = array(
            'uMailSendRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'uMailSendRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uMailSendRole',
                'on' => 'uMailSendRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uMailSendRole.id', $this->id);
            $criteria->compare('uMailSendRole.created_at', $this->created_at, true);
            $criteria->compare('uMailSendRole.updated_at', $this->updated_at, true);
            $criteria->compare('uMailSendRoleI18ns.name', $this->ss_uMailSendRoleI18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uMailSendRole.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uMailSendRole.id' => array('label' => $this->getAttributeLabel('id')),
                        'uMailSendRole.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uMailSendRole.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uMailSendRoleI18ns.name' => array('label' => $this->getAttributeLabel('ss_uMailSendRoleI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}