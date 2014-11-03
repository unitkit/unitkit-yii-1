<?php

/**
 * This is the model class for table "b_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BI18n extends CActiveRecord
{
    // related attributes
    public $lk_b_i18n_i18ns_name;

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
        return 'b_i18n';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('id', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'length', 'max' => 16),
            array('id', 'type', 'type' => 'string'),

            // search
            array('id, lk_b_i18n_i18ns_name', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bActionI18ns' => array(self::HAS_MANY, 'BActionI18n', 'i18n_id'),
            'bCmsContainerTypeI18ns' => array(self::HAS_MANY, 'BCmsContainerTypeI18n', 'i18n_id'),
            'bCmsEditoGroupI18ns' => array(self::HAS_MANY, 'BCmsEditoGroupI18n', 'i18n_id'),
            'bCmsEditoI18ns' => array(self::HAS_MANY, 'BCmsEditoI18n', 'i18n_id'),
            'bCmsLayoutI18ns' => array(self::HAS_MANY, 'BCmsLayoutI18n', 'i18n_id'),
            'bCmsPageI18ns' => array(self::HAS_MANY, 'BCmsPageI18n', 'i18n_id'),
            'bCmsWidgetI18ns' => array(self::HAS_MANY, 'BCmsWidgetI18n', 'i18n_id'),
            'bGroupI18ns' => array(self::HAS_MANY, 'BGroupI18n', 'i18n_id'),
            'bInterfaceI18ns' => array(self::HAS_MANY, 'BInterfaceI18n', 'i18n_id'),
            'bMailSendRoleI18ns' => array(self::HAS_MANY, 'BMailSendRoleI18n', 'i18n_id'),
            'bMailTemplateGroupI18ns' => array(self::HAS_MANY, 'BMailTemplateGroupI18n', 'i18n_id'),
            'bMailTemplateI18ns' => array(self::HAS_MANY, 'BMailTemplateI18n', 'i18n_id'),
            'bMessageGroupI18ns' => array(self::HAS_MANY, 'BMessageGroupI18n', 'i18n_id'),
            'bMessageI18ns' => array(self::HAS_MANY, 'BMessageI18n', 'i18n_id'),
            'bPersons' => array(self::HAS_MANY, 'BPerson', 'default_language'),
            'bRoleI18ns' => array(self::HAS_MANY, 'BRoleI18n', 'i18n_id'),
            'bSiteI18ns' => array(self::HAS_MANY, 'BSiteI18n', 'i18n_id'),
            'bVariableGroupI18ns' => array(self::HAS_MANY, 'BVariableGroupI18n', 'i18n_id'),
            'bVariableI18ns' => array(self::HAS_MANY, 'BVariableI18n', 'i18n_id'),
            'bI18nI18ns' => array(self::HAS_MANY, 'BI18nI18n', 'b_i18n_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),

            // related attributes
            'lk_b_i18n_i18ns_name' => BI18nI18n::model()->getAttributeLabel('name')
        );
    }

    /**
     * Get i18n label from id
     *
     * @param string $id i18n ID
     * @return string
     */
    public static function labelI18n($id)
    {
        return B::t('unitkit', 'b_i18n_' . $id);
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
        $criteria->alias = 'bI18n';
        $criteria->with = array(
            'bI18nI18ns' => array(
                'select' => 'name',
                'alias' => 'bI18nI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bI18n',
                'on' => 'bI18nI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bI18n.id', $this->id, true);
            $criteria->compare('bI18nI18ns.name', $this->lk_b_i18n_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bI18n.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bI18n.id' => array('label' => $this->getAttributeLabel('id')),
                        'bI18nI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_i18n_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}