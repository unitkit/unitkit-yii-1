<?php

/**
 * This is the model class for table "b_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BGroup extends CActiveRecord
{
    // related attributes
    public $lk_b_group_i18ns_name;

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
        return 'b_group';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_group_i18ns_name',
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
            'bGroupRoles' => array(self::HAS_MANY, 'BGroupRole', 'b_group_id'),
            'bPersonGroups' => array(self::HAS_MANY, 'BPersonGroup', 'b_group_id'),
            'bGroupI18ns' => array(self::HAS_MANY, 'BGroupI18n', 'b_group_id')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_group_i18ns_name' => BGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bGroup';
        $criteria->with = array(
            'bGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bGroup', 'on' => 'bGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bGroup.id', $this->id);
            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bGroup.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bGroup.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('bGroup.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('bGroup.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bGroupI18ns.name', $this->lk_b_group_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bGroup.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bGroup.id' => array('label' => $this->getAttributeLabel('id')),
                        'bGroup.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bGroup.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}