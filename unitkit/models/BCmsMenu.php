<?php

/**
 * This is the model class for table "b_cms_menu"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsMenu extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_menu_i18ns_name;
	public $lk_b_cms_menu_i18ns_url;

    // virtual attributes
	public $v_created_at_start;
	public $v_created_at_end;
	public $v_updated_at_start;
	public $v_updated_at_end;

	/**
	 * Cache duration
	 *
	 * @var int
	 */
	public static $menuCacheDuration = 86400;

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
        return 'b_cms_menu';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_menu_group_id, rank, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('b_cms_menu_group_id', 'type', 'type' => 'integer'),
            array('rank', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, b_cms_menu_group_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_menu_i18ns_name, lk_b_cms_menu_i18ns_url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsMenuGroup' => array(self::BELONGS_TO, 'BCmsMenuGroup', 'b_cms_menu_group_id'),
            'bCmsMenuGroupI18ns' => array(self::HAS_MANY, 'BCmsMenuGroupI18n', array('b_cms_menu_group_id' => 'b_cms_menu_group_id')),
            'bCmsMenuI18ns' => array(self::HAS_MANY, 'BCmsMenuI18n', 'b_cms_menu_id'),
            'bCmsMenuI18n' => array(self::BELONGS_TO, 'BCmsMenuI18n', array('id' => 'b_cms_menu_id'),
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
            'id' => B::t('unitkit', 'model:id'),
            'b_cms_menu_group_id' => B::t('unitkit', $this->tableName().':b_cms_menu_group_id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_menu_i18ns_name' => BCmsMenuI18n::model()->getAttributeLabel('name'),
            'lk_b_cms_menu_i18ns_url' => BCmsMenuI18n::model()->getAttributeLabel('url'),
            'lk_b_cms_menu_group_i18ns_name' => BCmsMenuGroupI18n::model()->getAttributeLabel('name'),
        );
    }

    /**
     * Get prefix of dynamic menu key
     *
     * @param int $groupId ID of menu group
     * @return string
     */
    public static function getPrefixDynMenuKey($groupId)
    {
        return 'cms_menu_gid_'.$groupId;
    }

    /**
     * Dynamic Cache key of menu
     *
     * @param int $groupId ID of menu group
     * @return string
     */
    public static function getDynMenuCacheKey($groupId)
    {
        $prefixKey = Yii::app()->cmsCache->get(self::getPrefixDynMenuKey($groupId));
        if ($prefixKey === false) {
	       $prefixKey = uniqid(mt_rand(), true);
	       Yii::app()->cmsCache->set(self::getPrefixDynMenuKey($groupId), $prefixKey, self::$menuCacheDuration);
        }

        return $prefixKey;
    }

    /**
     * Cache key of menu
     *
     * @param int $groupId Menu group ID
     * @param string $lang Language ID
     * @return string
     */
    public static function getMenuCacheKey($groupId, $lang)
    {
        return 'cms_menu_gid_'.$groupId.'_'.$lang.'_'.self::getDynMenuCacheKey($groupId);
    }

    /**
     * Delete cache of menu
     *
     * @param int $groupId Menu group ID
     */
    public static function clearMenuCache($groupId)
    {
       Yii::app()->cmsCache->delete(self::getPrefixDynMenuKey($groupId));
    }

    /**
     * Retrieves menu from group ID
     *
     * @param int $groupId Menu group ID
     * @return array of models
     */
    public function findMenuCache($groupId, $lang)
    {
        $models = Yii::app()->cmsCache->get(self::getMenuCacheKey($groupId, $lang));
        if (false === $models) {
            $models = $this
                ->with(array(
                    'bCmsMenuI18ns' => array(
                        'on' => 'i18n_id = :i18n_id',
                        'params' => array(':i18n_id' => $lang),
                        'joinType' => 'INNER JOIN'
                    )
                ))
                ->findAllByAttributes(
                    array('b_cms_menu_group_id' => $groupId),
                    array('order' => 'rank ASC')
                );
            Yii::app()->cmsCache->set(self::getMenuCacheKey($groupId, $lang), $models, self::$menuCacheDuration);
        }

        return $models;
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
        $criteria->alias = 'bCmsMenu';
        $criteria->with = array(
            'bCmsMenuGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'bCmsMenuGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsMenu',
                'on' => 'bCmsMenuGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId),
            ),
            'bCmsMenuI18ns' => array(
                'select' => 'name,url',
                'alias' => 'bCmsMenuI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsMenu',
                'on' => 'bCmsMenuI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsMenu.id', $this->id);
            $criteria->compare('bCmsMenu.rank', $this->rank);
            $criteria->compare('bCmsMenu.b_cms_menu_group_id', $this->b_cms_menu_group_id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('bCmsMenu.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsMenu.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('bCmsMenu.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('bCmsMenu.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsMenuI18ns.name', $this->lk_b_cms_menu_i18ns_name, true);
            $criteria->compare('bCmsMenuI18ns.url', $this->lk_b_cms_menu_i18ns_url, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsMenu.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsMenu.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsMenu.rank' => array(
                        'label' => $this->getAttributeLabel('rank'),
                    ),
                    'bCmsMenu.b_cms_menu_group_id' => array(
                    	'label' => $this->getAttributeLabel('b_cms_menu_group_id'),
                    ),
                    'bCmsMenu.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsMenu.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsMenuI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_menu_i18ns_name'),
                    ),
                    'bCmsMenuI18ns.url' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_menu_i18ns_url'),
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