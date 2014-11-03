<?php

/**
 * This is the model class for table "b_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BRole extends CActiveRecord
{
    // related attributes
    public $lk_b_role_i18ns_name;

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
        return 'b_role';
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
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, operation, business_rule, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_role_i18ns_name',
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
            'bGroupRoles' => array(self::HAS_MANY, 'BGroupRole', 'b_role_id'),
            'bRoleI18ns' => array(self::HAS_MANY, 'BRoleI18n', 'b_role_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'operation' => B::t('unitkit', 'b_role:operation'),
            'business_rule' => B::t('unitkit', 'b_role:business_rule'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_role_i18ns_name' => BRoleI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bRole';
        $criteria->with = array(
            'bRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'bRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bRole',
                'on' => 'bRoleI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bRole.id', $this->id);
            $criteria->compare('bRole.operation', $this->operation, true);
            $criteria->compare('bRole.business_rule', $this->business_rule, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bRole.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bRole.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('bRole.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bRole.created_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bRoleI18ns.name', $this->lk_b_role_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array('sortVar' => 'sort',
                    'defaultOrder' => array('bRole.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bRole.id' => array('label' => $this->getAttributeLabel('id')),
                        'bRole.operation' => array('label' => $this->getAttributeLabel('operation')),
                        'bRole.business_rule' => array('label' => $this->getAttributeLabel('business_rule')),
                        'bRole.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bRole.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bRoleI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_role_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}