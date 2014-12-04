<?php

/**
 * This is the model class for table "u_cms_menu_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsMenuGroup extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_menu_group_i18ns_name;

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
        return 'u_cms_menu_group';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_menu_group_i18ns_name',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsMenus' => array(self::HAS_MANY, 'UCmsMenu', 'u_cms_menu_group_id'),
            'uCmsMenuGroupI18ns' => array(self::HAS_MANY, 'UCmsMenuGroupI18n', 'u_cms_menu_group_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_menu_group_i18ns_name' => UCmsMenuGroupI18n::model()->getAttributeLabel('name'),
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
        $criteria->alias = 'uCmsMenuGroup';
        $criteria->with = array(
            'uCmsMenuGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uCmsMenuGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsMenuGroup',
                'on' => 'uCmsMenuGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsMenuGroup.id', $this->id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('uCmsMenuGroup.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('uCmsMenuGroup.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('uCmsMenuGroup.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('uCmsMenuGroup.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsMenuGroupI18ns.name', $this->lk_u_cms_menu_group_i18ns_name, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsMenuGroup.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsMenuGroup.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsMenuGroup.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsMenuGroup.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsMenuGroupI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_menu_group_i18ns_name'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}