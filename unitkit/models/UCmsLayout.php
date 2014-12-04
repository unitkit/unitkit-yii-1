<?php

/**
 * This is the model class for table "u_cms_layout"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsLayout extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_layout_i18ns_name;

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
        return 'u_cms_layout';
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
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, view, max_container, path, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_layout_i18ns_name',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsPages' => array(self::HAS_MANY, 'UCmsPage', 'u_cms_layout_id'),
            'uCmsLayoutI18ns' => array(self::HAS_MANY, 'UCmsLayoutI18n', 'u_cms_layout_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'max_container' => Unitkit::t('unitkit', $this->tableName().':max_container'),
            'path' => Unitkit::t('unitkit', $this->tableName().':path'),
            'view' => Unitkit::t('unitkit', $this->tableName().':view'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_layout_i18ns_name' => UCmsLayoutI18n::model()->getAttributeLabel('name'),
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
        $criteria->alias = 'uCmsLayout';
        $criteria->with = array(
            'uCmsLayoutI18ns' => array(
                'select' => 'name',
                'alias' => 'uCmsLayoutI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsLayout',
                'on' => 'uCmsLayoutI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsLayout.id', $this->id);
            $criteria->compare('uCmsLayout.max_container', $this->max_container);
            $criteria->compare('uCmsLayout.path', $this->path, true);
            $criteria->compare('uCmsLayout.path', $this->view, true);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('uCmsLayout.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('uCmsLayout.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('uCmsLayout.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('uCmsLayout.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsLayoutI18ns.name', $this->lk_u_cms_layout_i18ns_name, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsLayout.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsLayout.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsLayout.max_container' => array(
                    	'label' => $this->getAttributeLabel('max_container'),
                    ),
                    'uCmsLayout.path' => array(
                    	'label' => $this->getAttributeLabel('path'),
                    ),
                    'uCmsLayout.view' => array(
                        'label' => $this->getAttributeLabel('view'),
                    ),
                    'uCmsLayout.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsLayout.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsLayoutI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_layout_i18ns_name'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}