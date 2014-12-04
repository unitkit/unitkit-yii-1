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
    public $lk_uMessageI18ns_translation = array();

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
        return 'u_message';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // save
            array('u_message_group_id, source, created_at, updated_at', 'required', 'on' => array('insert')),
            array('u_message_group_id, created_at, updated_at', 'required', 'on' => array('update')),
            array('u_message_group_id', 'type', 'type' => 'integer'),
            array('source', 'unsafe', 'on' => array('update')),
            array('source', 'uniqueSource', 'on' => array('insert')),
            array('id', 'type', 'type' => 'integer'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('source', 'length', 'max' => 65535),
            array('source', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),
            // search
            array(
                'id, u_message_group_id, source, created_at, updated_at, lk_uMessageI18ns_translation',
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
     *
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'uMessageGroupI18ns' => array(
                self::HAS_MANY,
                'UMessageGroupI18n',
                array(
                    'u_message_group_id' => 'u_message_group_id'
                )
            )
        );

        $i18nIds = USiteI18n::model()->getI18nIds();
        foreach ($i18nIds as $id) {
            $relations['uMessageI18n_' . $id] = array(
                self::HAS_MANY,
                'UMessageI18n',
                'u_message_id',
                'on' => 'uMessageI18n_' . $id . '.i18n_id = :uMessageI18n_' . $id . '_i18n_id',
                'params' => array(
                    ':uMessageI18n_' . $id . '_i18n_id' => $id
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
            'id' => Unitkit::t('unitkit', 'u_message:id'),
            'u_message_group_id' => Unitkit::t('unitkit', 'u_message:u_message_group_id'),
            'source' => Unitkit::t('unitkit', 'u_message:source'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // search/sort attributes
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
            'uMessageGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uMessageGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uMessage',
                'on' => 'uMessageGroupI18ns.i18n_id = :id18nId',
                'params' => array(
                    ':id18nId' => $i18nId
                )
            )
        );

        $i18nIds = USiteI18n::model()->getI18nIds();
        foreach ($i18nIds as $id) {
            $criteria->with['uMessageI18n_' . $id] = array(
                'select' => 'translation',
                'alias' => 'uMessageI18n_' . $id,
                'joinType' => 'LEFT JOIN',
                'together' => 'uMessage'
            );
        }

        if ($this->validate()) {
            $criteria->compare('uMessage.id', $this->id);
            $criteria->compare('uMessage.u_message_group_id', $this->u_message_group_id);
            $criteria->compare('uMessage.source', $this->source, true);
            $criteria->compare('uMessage.created_at', $this->created_at, true);
            $criteria->compare('uMessage.updated_at', $this->updated_at, true);
            foreach ($i18nIds as $id)
                if (isset($this->lk_uMessageI18ns_translation[$id]))
                    $criteria->compare('uMessageI18n_' . $id . '.translation', $this->lk_uMessageI18ns_translation[$id], true);
        }

        $config = array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array(
                    'uMessage.id' => CSort::SORT_DESC
                ),
                'attributes' => array(
                    'uMessage.id' => array(
                        'label' => $this->getAttributeLabel('id')
                    ),
                    'uMessage.u_message_group_id' => array(
                        'label' => $this->getAttributeLabel('u_message_group_id')
                    ),
                    'uMessage.source' => array(
                        'label' => $this->getAttributeLabel('source')
                    ),
                    'uMessage.created_at' => array(
                        'label' => $this->getAttributeLabel('created_at')
                    ),
                    'uMessage.updated_at' => array(
                        'label' => $this->getAttributeLabel('updated_at')
                    ),
                    'uMessageGroupI18ns.name' => array(
                        'label' => $this->getAttributeLabel('lk_uMessageGroupI18ns_name')
                    )
                )
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        );

        foreach ($i18nIds as $id)
            $config['sort']['attributes']['uMessageI18n_' . $id . '.translation'] = array();

        return new CActiveDataProvider($this, $config);
    }
}