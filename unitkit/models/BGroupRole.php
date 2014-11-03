<?php

/**
 * This is the model class for table "b_group_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BGroupRole extends CActiveRecord
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
        return 'b_group_role';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_group_id, b_role_id', 'required',
                'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            // search
            array('b_group_id, b_role_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bRole' => array(self::BELONGS_TO, 'BRole', 'b_role_id'),
            'bRoleI18ns' => array(self::HAS_MANY, 'BRoleI18n', array('b_role_id' => 'b_role_id')),
            'bGroup' => array(self::BELONGS_TO, 'BGroup', 'b_group_id'),
            'bGroupI18ns' => array(self::HAS_MANY, 'BGroupI18n', array('b_group_id' => 'b_group_id')),
            'bPersonGroups' => array(self::HAS_MANY, 'BPersonGroup', 'b_group_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'b_group_id' => B::t('unitkit', 'b_group_role:b_group_id'),
            'b_role_id' => B::t('unitkit', 'b_group_role:b_role_id'),

            // search/sort attributes
            'ss_bRoleI18ns_name' => BRoleI18n::model()->getAttributeLabel('name'),
            'ss_bGroupI18ns_name' => BGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bGroupRole';
        $criteria->with = array(
            'bRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'bRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bGroupRole',
                'on' => 'bRoleI18ns.i18n_id=:lang',
                'params' => array(':lang' => $i18nId)
            ),
            'bGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bGroupRole',
                'on' => 'bGroupI18ns.i18n_id=:lang',
                'params' => array(':lang' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bGroupRole.b_group_id', $this->b_group_id);
            $criteria->compare('bGroupRole.b_role_id', $this->b_role_id);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bGroupRole.b_role_id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bGroupRole.b_group_id' => array('label' => $this->getAttributeLabel('b_group_id')),
                        'bGroupRole.b_role_id' => array('label' => $this->getAttributeLabel('b_role_id')),
                        'bRoleI18ns.name' => array('label' => $this->getAttributeLabel('ss_bRoleI18ns_name')),
                        'bGroupI18ns.name' => array('label' => $this->getAttributeLabel('ss_bGroupI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}