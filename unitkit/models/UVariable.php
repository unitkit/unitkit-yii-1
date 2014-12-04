<?php

/**
 * This is the model class for table "u_variable"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UVariable extends CActiveRecord
{
    // related attributes
    public $lk_u_variable_i18ns_description;

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
        return 'u_variable';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_variable_group_id, param, val, created_at, updated_at', 'required', 'on' => array('insert', 'update')), array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('u_variable_group_id', 'type', 'type' => 'integer'),
            array('param', 'length', 'max' => 50),
            array('param', 'type', 'type' => 'string'),
            array('val', 'length', 'max' => 65535),
            array('val', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, u_variable_group_id, param, val, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_variable_i18ns_description',
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
            'uVariableGroup' => array(self::BELONGS_TO, 'UVariableGroup', 'u_variable_group_id'),
            'uVariableGroupI18ns' => array(self::HAS_MANY, 'UVariableGroupI18n', array('u_variable_group_id' => 'u_variable_group_id')),
            'uVariableI18ns' => array(self::HAS_MANY, 'UVariableI18n', 'u_variable_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'u_variable_group_id' => Unitkit::t('unitkit', 'u_variable:u_variable_group_id'),
            'param' => Unitkit::t('unitkit', 'u_variable:param'),
            'val' => Unitkit::t('unitkit', 'u_variable:val'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_variable_i18ns_description' => UVariableI18n::model()->getAttributeLabel('description'),
            'lk_u_variable_group_i18ns_name' => UVariableGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uVariable';
        $criteria->with = array(
            'uVariableGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uVariableGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'uVariable', 'on' => 'uVariableGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'uVariableI18ns' => array(
                'select' => 'description',
                'alias' => 'uVariableI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uVariable', 'on' => 'uVariableI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uVariable.id', $this->id);
            $criteria->compare('uVariable.u_variable_group_id', $this->u_variable_group_id);
            $criteria->compare('uVariable.param', $this->param, true);
            $criteria->compare('uVariable.val', $this->val, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uVariable.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uVariable.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('uVariable.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('uVariable.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uVariableI18ns.description', $this->lk_u_variable_i18ns_description, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uVariable.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uVariable.id' => array('label' => $this->getAttributeLabel('id')),
                        'uVariable.u_variable_group_id' => array('label' => $this->getAttributeLabel('u_variable_group_id')),
                        'uVariable.param' => array('label' => $this->getAttributeLabel('param')),
                        'uVariable.val' => array('label' => $this->getAttributeLabel('val')),
                        'uVariable.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uVariable.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uVariableI18ns.description' => array('label' => $this->getAttributeLabel('lk_u_variable_i18ns_description')),
                        'uVariableGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_variable_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}