<?php

/**
 * This is the model class for table "b_cms_layout"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsLayout extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_layout_i18ns_name;

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
        return 'b_cms_layout';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('max_container, path, view, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('path', 'length', 'max' => 255),
            array('path', 'type', 'type' => 'string'),
            array('view', 'length', 'max' => 255),
            array('view', 'type', 'type' => 'string'),
            array('max_container', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 20),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, view, max_container, path, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_layout_i18ns_name',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsPages' => array(self::HAS_MANY, 'BCmsPage', 'b_cms_layout_id'),
            'bCmsLayoutI18ns' => array(self::HAS_MANY, 'BCmsLayoutI18n', 'b_cms_layout_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'max_container' => B::t('unitkit', $this->tableName().':max_container'),
            'path' => B::t('unitkit', $this->tableName().':path'),
            'view' => B::t('unitkit', $this->tableName().':view'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_layout_i18ns_name' => BCmsLayoutI18n::model()->getAttributeLabel('name'),
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
        $criteria->alias = 'bCmsLayout';
        $criteria->with = array(
            'bCmsLayoutI18ns' => array(
                'select' => 'name',
                'alias' => 'bCmsLayoutI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsLayout',
                'on' => 'bCmsLayoutI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsLayout.id', $this->id);
            $criteria->compare('bCmsLayout.max_container', $this->max_container);
            $criteria->compare('bCmsLayout.path', $this->path, true);
            $criteria->compare('bCmsLayout.path', $this->view, true);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('bCmsLayout.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('bCmsLayout.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('bCmsLayout.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('bCmsLayout.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsLayoutI18ns.name', $this->lk_b_cms_layout_i18ns_name, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsLayout.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsLayout.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsLayout.max_container' => array(
                    	'label' => $this->getAttributeLabel('max_container'),
                    ),
                    'bCmsLayout.path' => array(
                    	'label' => $this->getAttributeLabel('path'),
                    ),
                    'bCmsLayout.view' => array(
                        'label' => $this->getAttributeLabel('view'),
                    ),
                    'bCmsLayout.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsLayout.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsLayoutI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_layout_i18ns_name'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}