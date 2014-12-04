<?php

/**
 * This is the model class for table "u_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class URole extends CActiveRecord
{
    // related attributes
    public $lk_u_role_i18ns_name;

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
        return 'u_role';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('operation, created_at, updated_at', 'required', 'on' => array('insert', 'update')), array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('operation', 'length', 'max' => 64),
            array('operation', 'type', 'type' => 'string'),
            array('business_rule', 'length', 'max' => 65535),
            array('business_rule', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, operation, business_rule, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_role_i18ns_name',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uGroupRoles' => array(self::HAS_MANY, 'UGroupRole', 'u_role_id'),
            'uRoleI18ns' => array(self::HAS_MANY, 'URoleI18n', 'u_role_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'operation' => Unitkit::t('unitkit', 'u_role:operation'),
            'business_rule' => Unitkit::t('unitkit', 'u_role:business_rule'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_role_i18ns_name' => URoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uRole';
        $criteria->with = array(
            'uRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'uRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uRole',
                'on' => 'uRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uRole.id', $this->id);
            $criteria->compare('uRole.operation', $this->operation, true);
            $criteria->compare('uRole.business_rule', $this->business_rule, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uRole.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uRole.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('uRole.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('uRole.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uRoleI18ns.name', $this->lk_u_role_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array('sortVar' => 'sort',
                    'defaultOrder' => array('uRole.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uRole.id' => array('label' => $this->getAttributeLabel('id')),
                        'uRole.operation' => array('label' => $this->getAttributeLabel('operation')),
                        'uRole.business_rule' => array('label' => $this->getAttributeLabel('business_rule')),
                        'uRole.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uRole.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uRoleI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_role_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}