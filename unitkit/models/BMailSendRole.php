<?php

/**
 * This is the model class for table "b_mail_send_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMailSendRole extends CActiveRecord
{
    // search/sort attributes
    public $ss_bMailSendRoleI18ns_name;

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
        return 'b_mail_send_role';
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
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, created_at, updated_at, ss_bMailSendRoleI18ns_name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bMailSendingRoles' => array(self::HAS_MANY, 'BMailSendingRole', 'b_mail_send_role_id'),
            'bMailSendRoleI18ns' => array(self::HAS_MANY, 'BMailSendRoleI18n', 'b_mail_send_role_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // search/sort attributes
            'ss_bMailSendRoleI18ns_name' => BMailSendRoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bMailSendRole';
        $criteria->with = array(
            'bMailSendRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'bMailSendRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bMailSendRole',
                'on' => 'bMailSendRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bMailSendRole.id', $this->id);
            $criteria->compare('bMailSendRole.created_at', $this->created_at, true);
            $criteria->compare('bMailSendRole.updated_at', $this->updated_at, true);
            $criteria->compare('bMailSendRoleI18ns.name', $this->ss_bMailSendRoleI18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bMailSendRole.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bMailSendRole.id' => array('label' => $this->getAttributeLabel('id')),
                        'bMailSendRole.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bMailSendRole.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bMailSendRoleI18ns.name' => array('label' => $this->getAttributeLabel('ss_bMailSendRoleI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}