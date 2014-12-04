<?php

/**
 * This is the model class for table "u_variable_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UVariableGroup extends CActiveRecord
{
    // related attributes
    public $lk_u_variable_group_i18ns_name;

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
        return 'u_variable_group';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('code, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('code', 'length', 'max' => 50),
            array('code', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array(
                'id, code, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_variable_group_i18ns_name',
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
            'uVariables' => array(self::HAS_MANY, 'UVariable', 'u_variable_group_id'),
            'uVariableGroupI18ns' => array(self::HAS_MANY, 'UVariableGroupI18n', 'u_variable_group_id')
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'code' => Unitkit::t('unitkit', 'u_variable_group:code'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
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
        $criteria->alias = 'uVariableGroup';
        $criteria->with = array(
            'uVariableGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uVariableGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uVariableGroup',
                'on' => 'uVariableGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uVariableGroup.id', $this->id);
            $criteria->compare('uVariableGroup.code', $this->code, true);

            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uVariableGroup.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uVariableGroup.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('uVariableGroup.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('uVariableGroup.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uVariableGroupI18ns.name', $this->lk_u_variable_group_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uVariableGroup.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uVariableGroup.id' => array('label' => $this->getAttributeLabel('id')),
                        'uVariableGroup.code' => array('label' => $this->getAttributeLabel('code')),
                        'uVariableGroup.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uVariableGroup.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uVariableGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_variable_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}