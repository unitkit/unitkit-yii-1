<?php

/**
 * This is the model class for table "u_cms_menu"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsMenu extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_menu_i18ns_name;
	public $lk_u_cms_menu_i18ns_url;

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
        return 'u_cms_menu';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_menu_group_id, rank, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('u_cms_menu_group_id', 'type', 'type' => 'integer'),
            array('rank', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, u_cms_menu_group_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_menu_i18ns_name, lk_u_cms_menu_i18ns_url',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsMenuGroup' => array(self::BELONGS_TO, 'UCmsMenuGroup', 'u_cms_menu_group_id'),
            'uCmsMenuGroupI18ns' => array(self::HAS_MANY, 'UCmsMenuGroupI18n', array('u_cms_menu_group_id' => 'u_cms_menu_group_id')),
            'uCmsMenuI18ns' => array(self::HAS_MANY, 'UCmsMenuI18n', 'u_cms_menu_id'),
            'uCmsMenuI18n' => array(self::BELONGS_TO, 'UCmsMenuI18n', array('id' => 'u_cms_menu_id'),
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
            'id' => Unitkit::t('unitkit', 'model:id'),
            'u_cms_menu_group_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_menu_group_id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_menu_i18ns_name' => UCmsMenuI18n::model()->getAttributeLabel('name'),
            'lk_u_cms_menu_i18ns_url' => UCmsMenuI18n::model()->getAttributeLabel('url'),
            'lk_u_cms_menu_group_i18ns_name' => UCmsMenuGroupI18n::model()->getAttributeLabel('name'),
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
                    'uCmsMenuI18ns' => array(
                        'on' => 'i18n_id = :i18n_id',
                        'params' => array(':i18n_id' => $lang),
                        'joinType' => 'INNER JOIN'
                    )
                ))
                ->findAllByAttributes(
                    array('u_cms_menu_group_id' => $groupId),
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
        $criteria->alias = 'uCmsMenu';
        $criteria->with = array(
            'uCmsMenuGroupI18ns' => array(
                'select' => 'name',
                'alias' => 'uCmsMenuGroupI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsMenu',
                'on' => 'uCmsMenuGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId),
            ),
            'uCmsMenuI18ns' => array(
                'select' => 'name,url',
                'alias' => 'uCmsMenuI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsMenu',
                'on' => 'uCmsMenuI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsMenu.id', $this->id);
            $criteria->compare('uCmsMenu.rank', $this->rank);
            $criteria->compare('uCmsMenu.u_cms_menu_group_id', $this->u_cms_menu_group_id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('uCmsMenu.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('uCmsMenu.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('uCmsMenu.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('uCmsMenu.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsMenuI18ns.name', $this->lk_u_cms_menu_i18ns_name, true);
            $criteria->compare('uCmsMenuI18ns.url', $this->lk_u_cms_menu_i18ns_url, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsMenu.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsMenu.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsMenu.rank' => array(
                        'label' => $this->getAttributeLabel('rank'),
                    ),
                    'uCmsMenu.u_cms_menu_group_id' => array(
                    	'label' => $this->getAttributeLabel('u_cms_menu_group_id'),
                    ),
                    'uCmsMenu.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsMenu.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsMenuI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_menu_i18ns_name'),
                    ),
                    'uCmsMenuI18ns.url' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_menu_i18ns_url'),
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