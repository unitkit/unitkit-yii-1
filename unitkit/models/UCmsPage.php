<?php

/**
 * This is the model class for table "u_cms_page"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsPage extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_page_i18ns_title;
	public $lk_u_cms_page_i18ns_slug;
	public $lk_u_cms_page_i18ns_html_title;
	public $lk_u_cms_page_i18ns_html_description;
	public $lk_u_cms_page_i18ns_html_keywords;

    // virtual attributes
	public $v_created_at_start;
	public $v_created_at_end;
	public $v_updated_at_start;
	public $v_updated_at_end;

	public $cache_duration = 3600;

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
        return 'u_cms_page';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('activated, cache_duration, u_cms_layout_id, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('cache_duration', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('activated', 'boolean', 'on' => array('insert', 'update')),
            array('u_cms_layout_id', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, activated, u_cms_layout_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_page_i18ns_title, lk_u_cms_page_i18ns_slug, lk_u_cms_page_i18ns_html_title, lk_u_cms_page_i18ns_html_description, lk_u_cms_page_i18ns_html_keywords',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsLayout' => array(self::BELONGS_TO, 'UCmsLayout', 'u_cms_layout_id', 'joinType' => 'INNER JOIN'),
            'uCmsLayoutI18ns' => array(self::HAS_MANY, 'UCmsLayoutI18n', array('u_cms_layout_id' => 'u_cms_layout_id')),
            'uCmsPageContents' => array(self::HAS_MANY, 'UCmsPageContent', 'u_cms_page_id'),
            'uCmsPageI18ns' => array(self::HAS_MANY, 'UCmsPageI18n', 'u_cms_page_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'activated' => Unitkit::t('unitkit', 'model:activated'),
            'cache_duration' => Unitkit::t('unitkit', $this->tableName().':cache_duration'),
            'u_cms_layout_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_layout_id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_page_i18ns_title' => UCmsPageI18n::model()->getAttributeLabel('title'),
            'lk_u_cms_page_i18ns_slug' => UCmsPageI18n::model()->getAttributeLabel('slug'),
            'lk_u_cms_page_i18ns_html_title' => UCmsPageI18n::model()->getAttributeLabel('html_title'),
            'lk_u_cms_page_i18ns_html_description' => UCmsPageI18n::model()->getAttributeLabel('html_description'),
            'lk_u_cms_page_i18ns_html_keywords' => UCmsPageI18n::model()->getAttributeLabel('html_keywords'),
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
        $criteria->alias = 'uCmsPage';
        $criteria->with = array(
            'uCmsLayoutI18ns' => array(
                'select' => 'name',
                'alias' => 'uCmsLayoutI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsPage',
                'on' => 'uCmsLayoutI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId),
            ),
            'uCmsPageI18ns' => array(
                'select' => 'title,slug,html_title,html_description,html_keywords',
                'alias' => 'uCmsPageI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsPage',
                'on' => 'uCmsPageI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsPage.id', $this->id);
            $criteria->compare('uCmsPage.activated', $this->activated);
            $criteria->compare('uCmsPage.cache_duration', $this->activated);
            $criteria->compare('uCmsPage.u_cms_layout_id', $this->u_cms_layout_id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('uCmsPage.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('uCmsPage.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('uCmsPage.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('uCmsPage.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsPageI18ns.title', $this->lk_u_cms_page_i18ns_title, true);
            $criteria->compare('uCmsPageI18ns.slug', $this->lk_u_cms_page_i18ns_slug, true);
            $criteria->compare('uCmsPageI18ns.html_title', $this->lk_u_cms_page_i18ns_html_title, true);
            $criteria->compare('uCmsPageI18ns.html_description', $this->lk_u_cms_page_i18ns_html_description, true);
            $criteria->compare('uCmsPageI18ns.html_keywords', $this->lk_u_cms_page_i18ns_html_keywords, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsPage.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsPage.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsPage.activated' => array(
                    	'label' => $this->getAttributeLabel('activated'),
                    ),
                    'uCmsPage.cache_duration' => array(
                        'label' => $this->getAttributeLabel('cache_duration'),
                    ),
                    'uCmsPage.u_cms_layout_id' => array(
                    	'label' => $this->getAttributeLabel('u_cms_layout_id'),
                    ),
                    'uCmsPage.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsPage.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsPageI18ns.title' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_i18ns_title'),
                    ),
                    'uCmsPageI18ns.slug' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_i18ns_slug'),
                    ),
                    'uCmsPageI18ns.html_title' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_i18ns_html_title'),
                    ),
                    'uCmsPageI18ns.html_description' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_i18ns_html_description'),
                    ),
                    'uCmsPageI18ns.html_keywords' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_i18ns_html_keywords'),
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