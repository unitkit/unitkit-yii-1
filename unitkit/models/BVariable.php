<?php

/**
 * This is the model class for table "b_variable"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BVariable extends CActiveRecord
{
    // related attributes
    public $lk_b_variable_i18ns_description;

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
        return 'b_variable';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_variable_group_id, param, val, created_at, updated_at', 'required', 'on' => array('insert', 'update')), array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('b_variable_group_id', 'type', 'type' => 'integer'),
            array('param', 'length', 'max' => 50),
            array('param', 'type', 'type' => 'string'),
            array('val', 'length', 'max' => 65535),
            array('val', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, b_variable_group_id, param, val, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_variable_i18ns_description',
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
            'bVariableGroup' => array(self::BELONGS_TO, 'BVariableGroup', 'b_variable_group_id'),
            'bVariableGroupI18ns' => array(self::HAS_MANY, 'BVariableGroupI18n', array('b_variable_group_id' => 'b_variable_group_id')),
            'bVariableI18ns' => array(self::HAS_MANY, 'BVariableI18n', 'b_variable_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'b_variable_group_id' => B::t('unitkit', 'b_variable:b_variable_group_id'),
            'param' => B::t('unitkit', 'b_variable:param'),
            'val' => B::t('unitkit', 'b_variable:val'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_variable_i18ns_description' => BVariableI18n::model()->getAttributeLabel('description'),
            'lk_b_variable_group_i18ns_name' => BVariableGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bVariable';
        $criteria->with = array(
            'bVariableGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bVariableGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'bVariable', 'on' => 'bVariableGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'bVariableI18ns' => array(
                'select' => 'description',
                'alias' => 'bVariableI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bVariable', 'on' => 'bVariableI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bVariable.id', $this->id);
            $criteria->compare('bVariable.b_variable_group_id', $this->b_variable_group_id);
            $criteria->compare('bVariable.param', $this->param, true);
            $criteria->compare('bVariable.val', $this->val, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bVariable.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bVariable.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('bVariable.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('bVariable.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bVariableI18ns.description', $this->lk_b_variable_i18ns_description, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bVariable.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bVariable.id' => array('label' => $this->getAttributeLabel('id')),
                        'bVariable.b_variable_group_id' => array('label' => $this->getAttributeLabel('b_variable_group_id')),
                        'bVariable.param' => array('label' => $this->getAttributeLabel('param')),
                        'bVariable.val' => array('label' => $this->getAttributeLabel('val')),
                        'bVariable.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bVariable.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bVariableI18ns.description' => array('label' => $this->getAttributeLabel('lk_b_variable_i18ns_description')),
                        'bVariableGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_variable_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}