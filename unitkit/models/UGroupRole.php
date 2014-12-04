<?php

/**
 * This is the model class for table "u_group_role"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UGroupRole extends CActiveRecord
{

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
        return 'u_group_role';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_group_id, u_role_id', 'required',
                'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            // search
            array('u_group_id, u_role_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uRole' => array(self::BELONGS_TO, 'URole', 'u_role_id'),
            'uRoleI18ns' => array(self::HAS_MANY, 'URoleI18n', array('u_role_id' => 'u_role_id')),
            'uGroup' => array(self::BELONGS_TO, 'UGroup', 'u_group_id'),
            'uGroupI18ns' => array(self::HAS_MANY, 'UGroupI18n', array('u_group_id' => 'u_group_id')),
            'uPersonGroups' => array(self::HAS_MANY, 'UPersonGroup', 'u_group_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_group_id' => Unitkit::t('unitkit', 'u_group_role:u_group_id'),
            'u_role_id' => Unitkit::t('unitkit', 'u_group_role:u_role_id'),

            // search/sort attributes
            'ss_uRoleI18ns_name' => URoleI18n::model()->getAttributeLabel('name'),
            'ss_uGroupI18ns_name' => UGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uGroupRole';
        $criteria->with = array(
            'uRoleI18ns' => array(
                'select' => 'name',
                'alias' => 'uRoleI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uGroupRole',
                'on' => 'uRoleI18ns.i18n_id=:lang',
                'params' => array(':lang' => $i18nId)
            ),
            'uGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uGroupRole',
                'on' => 'uGroupI18ns.i18n_id=:lang',
                'params' => array(':lang' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uGroupRole.u_group_id', $this->u_group_id);
            $criteria->compare('uGroupRole.u_role_id', $this->u_role_id);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uGroupRole.u_role_id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uGroupRole.u_group_id' => array('label' => $this->getAttributeLabel('u_group_id')),
                        'uGroupRole.u_role_id' => array('label' => $this->getAttributeLabel('u_role_id')),
                        'uRoleI18ns.name' => array('label' => $this->getAttributeLabel('ss_uRoleI18ns_name')),
                        'uGroupI18ns.name' => array('label' => $this->getAttributeLabel('ss_uGroupI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}