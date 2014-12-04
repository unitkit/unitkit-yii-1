<?php

/**
 * This is the model class for table "u_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UI18n extends CActiveRecord
{
    // related attributes
    public $lk_u_i18n_i18ns_name;

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
        return 'u_i18n';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('id', 'required', 'on' => array('insert', 'update')),
            array('id', 'length', 'max' => 16),
            array('id', 'type', 'type' => 'string'),
            array('id', 'filter', 'filter' => function($string) {
                    $string = preg_replace('/[^A-Za-z]+/', '', $string);
                    return $string;
                }, 'on' => array('insert', 'update')
            ),
            // search
            array('id, lk_u_i18n_i18ns_name', 'safe', 'on' => 'search')
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
            'uCmsLayoutI18ns' => array(self::HAS_MANY, 'UCmsLayoutI18n', 'i18n_id'),
            'uCmsPageI18ns' => array(self::HAS_MANY, 'UCmsPageI18n', 'i18n_id'),
            'uCmsWidgetI18ns' => array(self::HAS_MANY, 'UCmsWidgetI18n', 'i18n_id'),
            'uGroupI18ns' => array(self::HAS_MANY, 'UGroupI18n', 'i18n_id'),
            'uInterfaceI18ns' => array(self::HAS_MANY, 'UInterfaceI18n', 'i18n_id'),
            'uMailSendRoleI18ns' => array(self::HAS_MANY, 'UMailSendRoleI18n', 'i18n_id'),
            'uMailTemplateGroupI18ns' => array(self::HAS_MANY, 'UMailTemplateGroupI18n', 'i18n_id'),
            'uMailTemplateI18ns' => array(self::HAS_MANY, 'UMailTemplateI18n', 'i18n_id'),
            'uMessageGroupI18ns' => array(self::HAS_MANY, 'UMessageGroupI18n', 'i18n_id'),
            'uMessageI18ns' => array(self::HAS_MANY, 'UMessageI18n', 'i18n_id'),
            'uPersons' => array(self::HAS_MANY, 'UPerson', 'default_language'),
            'uRoleI18ns' => array(self::HAS_MANY, 'URoleI18n', 'i18n_id'),
            'uSiteI18ns' => array(self::HAS_MANY, 'USiteI18n', 'i18n_id'),
            'uVariableGroupI18ns' => array(self::HAS_MANY, 'UVariableGroupI18n', 'i18n_id'),
            'uVariableI18ns' => array(self::HAS_MANY, 'UVariableI18n', 'i18n_id'),
            'uI18nI18ns' => array(self::HAS_MANY, 'UI18nI18n', 'u_i18n_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),

            // related attributes
            'lk_u_i18n_i18ns_name' => UI18nI18n::model()->getAttributeLabel('name')
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
        return Unitkit::t('unitkit', 'u_i18n_' . $id);
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
        $criteria->alias = 'uI18n';
        $criteria->with = array(
            'uI18nI18ns' => array(
                'select' => 'name',
                'alias' => 'uI18nI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uI18n',
                'on' => 'uI18nI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uI18n.id', $this->id, true);
            $criteria->compare('uI18nI18ns.name', $this->lk_u_i18n_i18ns_name, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uI18n.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uI18n.id' => array('label' => $this->getAttributeLabel('id')),
                        'uI18nI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_i18n_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}