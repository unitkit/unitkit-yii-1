<?php

/**
 * This is the model class for table "b_cms_social"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsSocial extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_social_i18ns_url;

    // virtual attributes
	public $v_created_at_start;
	public $v_created_at_end;
	public $v_updated_at_start;
	public $v_updated_at_end;

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
        return 'b_cms_social';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id, name', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('name', 'length', 'max' => 255),
            array('name', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, name, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_social_i18ns_url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsSocialI18ns' => array(self::HAS_MANY, 'BCmsSocialI18n', 'b_cms_social_id'),
            'bCmsSocialI18n' => array(self::BELONGS_TO, 'BCmsSocialI18n', array('id' => 'b_cms_social_id'),
                'on' => 'i18n_id = :i18n_id', 'params' => array(':i18n_id' => Yii::app()->language),
                'joinType' => 'INNER JOIN'
            ),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', $this->tableName().':id'),
            'name' => B::t('unitkit', $this->tableName().':name'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_social_i18ns_url' => BCmsSocialI18n::model()->getAttributeLabel('url'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions
     *
     * @param string i18n ID
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($i18nId)
    {
        $criteria = $this->getDbCriteria();
        $criteria->alias = 'bCmsSocial';
        $criteria->with = array(
            'bCmsSocialI18ns' => array(
                'select' => 'url',
                'alias' => 'bCmsSocialI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsSocial',
                'on' => 'bCmsSocialI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsSocial.id', $this->id);
            $criteria->compare('bCmsSocial.name', $this->name, true);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('bCmsSocial.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsSocial.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('bCmsSocial.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsSocial.created_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsSocialI18ns.url', $this->lk_b_cms_social_i18ns_url, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsSocial.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsSocial.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsSocial.name' => array(
                    	'label' => $this->getAttributeLabel('name'),
                    ),
                    'bCmsSocial.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsSocial.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsSocialI18ns.url' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_social_i18ns_url'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}