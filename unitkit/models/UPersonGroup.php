<?php

/**
 * This is the model class for table "u_person_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UPersonGroup extends CActiveRecord
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
        return 'u_person_group';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_person_id, u_group_id', 'required', 'on' => array('insert', 'update')),
            array('u_person_id', 'type', 'type' => 'integer'),
            array('u_group_id', 'type', 'type' => 'integer'),

            // search
            array('u_person_id, u_group_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uGroup' => array(self::BELONGS_TO, 'UGroup', 'u_group_id'),
            'uGroupI18ns' => array(self::HAS_MANY, 'UGroupI18n', array('u_group_id' => 'u_group_id')),
            'uPerson' => array(self::BELONGS_TO, 'UPerson', 'u_person_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'u_person_id' => Unitkit::t('unitkit', 'u_person_group:u_person_id'),
            'u_group_id' => Unitkit::t('unitkit', 'u_person_group:u_group_id'),

            // search/sort attributes
            'ss_uGroupI18ns_name' => UGroupI18n::model()->getAttributeLabel('name'),
            'ss_uPerson_email' => UPerson::model()->getAttributeLabel('email')
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
        $criteria->alias = 'uPersonGroup';
        $criteria->with = array(
            'uGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uPersonGroup', 'on' => 'uGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'uPerson' => array(
                'select' => 'email',
                'alias' => 'uPerson',
                'joinType' => 'LEFT JOIN',
                'together' => 'u_person_group'
            )
        );

        if ($this->validate()) {
            $criteria->compare('uPersonGroup.u_person_id', $this->u_person_id);
            $criteria->compare('uPersonGroup.u_group_id', $this->u_group_id);
        }

        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'uPersonGroup.u_person_id' => array('label' => $this->getAttributeLabel('u_person_id')),
                        'uPersonGroup.u_group_id' => array('label' => $this->getAttributeLabel('u_group_id')),
                        'uGroupI18ns.name' => array('label' => $this->getAttributeLabel('ss_uGroupI18ns_name')),
                        'uPerson.email' => array('label' => $this->getAttributeLabel('ss_uPerson_email'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}