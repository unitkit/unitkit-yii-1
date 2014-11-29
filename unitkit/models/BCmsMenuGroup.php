<?php

/**
 * This is the model class for table "b_cms_menu_group"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsMenuGroup extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_menu_group_i18ns_name;

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
        return 'b_cms_menu_group';
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
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_menu_group_i18ns_name',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsMenus' => array(self::HAS_MANY, 'BCmsMenu', 'b_cms_menu_group_id'),
            'bCmsMenuGroupI18ns' => array(self::HAS_MANY, 'BCmsMenuGroupI18n', 'b_cms_menu_group_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_menu_group_i18ns_name' => BCmsMenuGroupI18n::model()->getAttributeLabel('name'),
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
        $criteria->alias = 'bCmsMenuGroup';
        $criteria->with = array(
            'bCmsMenuGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bCmsMenuGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsMenuGroup',
                'on' => 'bCmsMenuGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsMenuGroup.id', $this->id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('bCmsMenuGroup.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsMenuGroup.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('bCmsMenuGroup.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('bCmsMenuGroup.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsMenuGroupI18ns.name', $this->lk_b_cms_menu_group_i18ns_name, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsMenuGroup.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsMenuGroup.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsMenuGroup.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsMenuGroup.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsMenuGroupI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_menu_group_i18ns_name'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}