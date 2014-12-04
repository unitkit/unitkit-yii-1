<?php

/**
 * This is the model class for table "u_message"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMessage extends CActiveRecord
{
    // search/sort attributes
    public $lk_uMessageI18ns_translation;
    public $lk_uMessageGroupI18ns_name;

    /**
     * @see CModel::scopes()
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
     * @see CModel::tableName()
     */
    public function tableName()
    {
        return 'u_message';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_message_group_id, source, created_at, updated_at', 'required', 'on' => array('insert')),
            array('u_message_group_id, created_at, updated_at', 'required', 'on' => array('update')),
            array('created_at', 'unsafe'),
            array('source', 'unsafe', 'on' => array('update')),
            array('source', 'uniqueSource', 'on' => array('insert')),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_message_group_id', 'type', 'type' => 'integer'),
            array('source', 'length', 'max' => 65535),
            array('source', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, u_message_group_id, source, created_at, updated_at, lk_uMessageI18ns_translation', 'safe',
                'on' => 'search'
            )
        );
    }

    /**
     * Verify if source already exist
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function uniqueSource($attribute, $params)
    {
        $cmsPage = $this->find(
            array(
                'select' => '1',
                'condition' => 'u_message_group_id = :u_message_group_id AND source = :source',
                'params' => array(
                    ':u_message_group_id' => $this->u_message_group_id,
                    ':source' => $this->source
                )
            )
        );

        if ($cmsPage !== null) {
            $this->addError('name', Unitkit::t('unitkit', 'u_message_source_exist'));
        }
    }

    /**
     * @see CActiveRecord::beforeSave()
     */
    public function beforeSave()
    {
        $this->source = trim($this->source);
        parent::beforeSave();
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uMessageGroup' => array(self::BELONGS_TO, 'UMessageGroup', 'u_message_group_id'),
            'uMessageGroupI18ns' => array(self::HAS_MANY, 'UMessageGroupI18n', array('u_message_group_id' => 'u_message_group_id')),
            'uMessageI18ns' => array(self::HAS_MANY, 'UMessageI18n', 'u_message_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'u_message_group_id' => Unitkit::t('unitkit', 'u_message:u_message_group_id'),
            'source' => Unitkit::t('unitkit', 'u_message:source'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // search/sort attributes
            'lk_uMessageI18ns_translation' => UMessageI18n::model()->getAttributeLabel('translation'),
            'lk_uMessageGroupI18ns_name' => UMessageGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uMessage';
        $criteria->with = array(
            'uMessageGroupI18ns' => array('select' => 'name', 'alias' => 'uMessageGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'uMessage', 'on' => 'uMessageGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'uMessageI18ns' => array('select' => 'translation', 'alias' => 'uMessageI18ns', 'joinType' => 'LEFT JOIN',
                'together' => 'uMessage', 'on' => 'uMessageI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uMessage.id', $this->id);
            $criteria->compare('uMessage.u_message_group_id', $this->u_message_group_id);
            $criteria->compare('uMessage.source', $this->source, true);
            $criteria->compare('uMessage.created_at', $this->created_at, true);
            $criteria->compare('uMessage.updated_at', $this->updated_at, true);
            $criteria->compare('uMessageI18ns.translation', $this->lk_uMessageI18ns_translation, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array('sortVar' => 'sort',
                    'defaultOrder' => array('uMessage.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uMessage.id' => array('label' => $this->getAttributeLabel('id')),
                        'uMessage.u_message_group_id' => array('label' => $this->getAttributeLabel('u_message_group_id')),
                        'uMessage.source' => array('label' => $this->getAttributeLabel('source')),
                        'uMessage.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uMessage.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uMessageI18ns.translation' => array('label' => $this->getAttributeLabel('lk_uMessageI18ns_translation')),
                        'uMessageGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_uMessageGroupI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}