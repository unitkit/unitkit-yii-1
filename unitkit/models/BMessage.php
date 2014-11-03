<?php

/**
 * This is the model class for table "b_message"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMessage extends CActiveRecord
{
    // search/sort attributes
    public $ss_bMessageI18ns_translation;

    /**
     * @see CModel::scopes()
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
     * @see CModel::tableName()
     */
    public function tableName()
    {
        return 'b_message';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_message_group_id, source, created_at, updated_at', 'required', 'on' => array('insert')),
            array('b_message_group_id, created_at, updated_at', 'required', 'on' => array('update')),
            array('created_at', 'unsafe'),
            array('source', 'unsafe', 'on' => array('update')),
            array('source', 'uniqueSource', 'on' => array('insert')),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('b_message_group_id', 'type', 'type' => 'integer'),
            array('source', 'length', 'max' => 65535),
            array('source', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, b_message_group_id, source, created_at, updated_at, ss_bMessageI18ns_translation', 'safe',
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
                'condition' => 'b_message_group_id = :b_message_group_id AND source = :source',
                'params' => array(
                    ':b_message_group_id' => $this->b_message_group_id,
                    ':source' => $this->source
                )
            )
        );

        if ($cmsPage !== null)
            $this->addError('name', B::t('unitkit', 'b_message_source_exist'));
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
            'bMessageGroup' => array(self::BELONGS_TO, 'BMessageGroup', 'b_message_group_id'),
            'bMessageGroupI18ns' => array(self::HAS_MANY, 'BMessageGroupI18n', array('b_message_group_id' => 'b_message_group_id')),
            'bMessageI18ns' => array(self::HAS_MANY, 'BMessageI18n', 'b_message_id')
        );
    }

    /**
     * @see CModel::relations()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'b_message_group_id' => B::t('unitkit', 'b_message:b_message_group_id'),
            'source' => B::t('unitkit', 'b_message:source'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // search/sort attributes
            'ss_bMessageI18ns_translation' => BMessageI18n::model()->getAttributeLabel('translation'),
            'ss_bMessageGroupI18ns_name' => BMessageGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'bMessage';
        $criteria->with = array(
            'bMessageGroupI18ns' => array('select' => 'name', 'alias' => 'bMessageGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'bMessage', 'on' => 'bMessageGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'bMessageI18ns' => array('select' => 'translation', 'alias' => 'bMessageI18ns', 'joinType' => 'LEFT JOIN',
                'together' => 'bMessage', 'on' => 'bMessageI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bMessage.id', $this->id);
            $criteria->compare('bMessage.b_message_group_id', $this->b_message_group_id);
            $criteria->compare('bMessage.source', $this->source, true);
            $criteria->compare('bMessage.created_at', $this->created_at, true);
            $criteria->compare('bMessage.updated_at', $this->updated_at, true);
            $criteria->compare('bMessageI18ns.translation', $this->ss_bMessageI18ns_translation, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array('sortVar' => 'sort',
                    'defaultOrder' => array('bMessage.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bMessage.id' => array('label' => $this->getAttributeLabel('id')),
                        'bMessage.b_message_group_id' => array('label' => $this->getAttributeLabel('b_message_group_id')),
                        'bMessage.source' => array('label' => $this->getAttributeLabel('source')),
                        'bMessage.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bMessage.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bMessageI18ns.translation' => array('label' => $this->getAttributeLabel('ss_bMessageI18ns_translation')),
                        'bMessageGroupI18ns.name' => array('label' => $this->getAttributeLabel('ss_bMessageGroupI18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}