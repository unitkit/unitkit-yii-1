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
    public $ss_bMessageI18ns_translation = array();

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
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'b_message';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // save
            array('b_message_group_id, source, created_at, updated_at', 'required', 'on' => array('insert')),
            array('b_message_group_id, created_at, updated_at', 'required', 'on' => array('update')),
            array('b_message_group_id', 'type', 'type' => 'integer'),
            array('source', 'unsafe', 'on' => array('update')),
            array('source', 'uniqueSource', 'on' => array('insert')),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('source', 'length', 'max' => 65535),
            array('source', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),
            // search
            array(
                'id, b_message_group_id, source, created_at, updated_at, ss_bMessageI18ns_translation',
                'safe',
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
     *
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'bMessageGroupI18ns' => array(
                self::HAS_MANY,
                'BMessageGroupI18n',
                array(
                    'b_message_group_id' => 'b_message_group_id'
                )
            )
        );

        $i18nIds = BSiteI18n::model()->getI18nIds();
        foreach ($i18nIds as $id) {
            $relations['bMessageI18n_' . $id . ''] = array(
                self::HAS_MANY,
                'BMessageI18n',
                'b_message_id',
                'on' => 'bMessageI18n_' . $id . '.i18n_id = :bMessageI18n_' . $id . '_i18n_id',
                'params' => array(
                    ':bMessageI18n_' . $id . '_i18n_id' => $id
                )
            );
        }

        return $relations;
    }

    public function beforeSave()
    {
        $this->source = trim($this->source);
        return parent::beforeSave();
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'b_message:id'),
            'b_message_group_id' => B::t('unitkit', 'b_message:b_message_group_id'),
            'source' => B::t('unitkit', 'b_message:source'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // search/sort attributes
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
            'bMessageGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bMessageGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bMessage',
                'on' => 'bMessageGroupI18ns.i18n_id = :id18nId',
                'params' => array(
                    ':id18nId' => $i18nId
                )
            )
        );

        $i18nIds = BSiteI18n::model()->getI18nIds();
        foreach ($i18nIds as $id) {
            $criteria->with['bMessageI18n_' . $id] = array(
                'select' => 'translation',
                'alias' => 'bMessageI18n_' . $id,
                'joinType' => 'LEFT JOIN',
                'together' => 'bMessage'
            );
        }

        if ($this->validate()) {
            $criteria->compare('bMessage.id', $this->id);
            $criteria->compare('bMessage.b_message_group_id', $this->b_message_group_id);
            $criteria->compare('bMessage.source', $this->source, true);
            $criteria->compare('bMessage.created_at', $this->created_at, true);
            $criteria->compare('bMessage.updated_at', $this->updated_at, true);
            foreach ($i18nIds as $id)
                if (isset($this->ss_bMessageI18ns_translation[$id]))
                    $criteria->compare('bMessageI18n_' . $id . '.translation', $this->ss_bMessageI18ns_translation[$id], true);
        }

        $config = array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array(
                    'bMessage.id' => CSort::SORT_DESC
                ),
                'attributes' => array(
                    'bMessage.id' => array(
                        'label' => $this->getAttributeLabel('id')
                    ),
                    'bMessage.b_message_group_id' => array(
                        'label' => $this->getAttributeLabel('b_message_group_id')
                    ),
                    'bMessage.source' => array(
                        'label' => $this->getAttributeLabel('source')
                    ),
                    'bMessage.created_at' => array(
                        'label' => $this->getAttributeLabel('created_at')
                    ),
                    'bMessage.updated_at' => array(
                        'label' => $this->getAttributeLabel('updated_at')
                    ),
                    'bMessageGroupI18ns.name' => array(
                        'label' => $this->getAttributeLabel('ss_bMessageGroupI18ns_name')
                    )
                )
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        );

        foreach ($i18nIds as $id)
            $config['sort']['attributes']['bMessageI18n_' . $id . '.translation'] = array();

        return new CActiveDataProvider($this, $config);
    }
}