<?php

/**
 * This is the model class for table "b_person_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BPersonGroup extends CActiveRecord
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
        return 'b_person_group';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_person_id, b_group_id', 'required', 'on' => array('insert', 'update')),
            array('b_person_id', 'type', 'type' => 'integer'),
            array('b_group_id', 'type', 'type' => 'integer'),

            // search
            array('b_person_id, b_group_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bGroup' => array(self::BELONGS_TO, 'BGroup', 'b_group_id'),
            'bGroupI18ns' => array(self::HAS_MANY, 'BGroupI18n', array('b_group_id' => 'b_group_id')),
            'bPerson' => array(self::BELONGS_TO, 'BPerson', 'b_person_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'b_person_id' => B::t('unitkit', 'b_person_group:b_person_id'),
            'b_group_id' => B::t('unitkit', 'b_person_group:b_group_id'),

            // search/sort attributes
            'ss_bGroupI18ns_name' => BGroupI18n::model()->getAttributeLabel('name'),
            'ss_bPerson_email' => BPerson::model()->getAttributeLabel('email')
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
        $criteria->alias = 'bPersonGroup';
        $criteria->with = array(
            'bGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bPersonGroup', 'on' => 'bGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'bPerson' => array(
                'select' => 'email',
                'alias' => 'bPerson',
                'joinType' => 'LEFT JOIN',
                'together' => 'b_person_group'
            )
        );

        if ($this->validate()) {
            $criteria->compare('bPersonGroup.b_person_id', $this->b_person_id);
            $criteria->compare('bPersonGroup.b_group_id', $this->b_group_id);
        }

        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'bPersonGroup.b_person_id' => array('label' => $this->getAttributeLabel('b_person_id')),
                        'bPersonGroup.b_group_id' => array('label' => $this->getAttributeLabel('b_group_id')),
                        'bGroupI18ns.name' => array('label' => $this->getAttributeLabel('ss_bGroupI18ns_name')),
                        'bPerson.email' => array('label' => $this->getAttributeLabel('ss_bPerson_email'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}