<?php

/**
 * This is the model class for table "b_cms_page"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsPage extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_page_i18ns_title;
	public $lk_b_cms_page_i18ns_slug;
	public $lk_b_cms_page_i18ns_html_title;
	public $lk_b_cms_page_i18ns_html_description;
	public $lk_b_cms_page_i18ns_html_keywords;

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
        return 'b_cms_page';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('activated, cache_duration, b_cms_layout_id, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('cache_duration', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('activated', 'boolean', 'on' => array('insert', 'update')),
            array('b_cms_layout_id', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, activated, b_cms_layout_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_page_i18ns_title, lk_b_cms_page_i18ns_slug, lk_b_cms_page_i18ns_html_title, lk_b_cms_page_i18ns_html_description, lk_b_cms_page_i18ns_html_keywords',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsLayout' => array(self::BELONGS_TO, 'BCmsLayout', 'b_cms_layout_id', 'joinType' => 'INNER JOIN'),
            'bCmsLayoutI18ns' => array(self::HAS_MANY, 'BCmsLayoutI18n', array('b_cms_layout_id' => 'b_cms_layout_id')),
            'bCmsPageContents' => array(self::HAS_MANY, 'BCmsPageContent', 'b_cms_page_id'),
            'bCmsPageI18ns' => array(self::HAS_MANY, 'BCmsPageI18n', 'b_cms_page_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'activated' => B::t('unitkit', 'model:activated'),
            'cache_duration' => B::t('unitkit', $this->tableName().':cache_duration'),
            'b_cms_layout_id' => B::t('unitkit', $this->tableName().':b_cms_layout_id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_page_i18ns_title' => BCmsPageI18n::model()->getAttributeLabel('title'),
            'lk_b_cms_page_i18ns_slug' => BCmsPageI18n::model()->getAttributeLabel('slug'),
            'lk_b_cms_page_i18ns_html_title' => BCmsPageI18n::model()->getAttributeLabel('html_title'),
            'lk_b_cms_page_i18ns_html_description' => BCmsPageI18n::model()->getAttributeLabel('html_description'),
            'lk_b_cms_page_i18ns_html_keywords' => BCmsPageI18n::model()->getAttributeLabel('html_keywords'),
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
        $criteria->alias = 'bCmsPage';
        $criteria->with = array(
            'bCmsLayoutI18ns' => array(
                'select' => 'name',
                'alias' => 'bCmsLayoutI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsPage',
                'on' => 'bCmsLayoutI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId),
            ),
            'bCmsPageI18ns' => array(
                'select' => 'title,slug,html_title,html_description,html_keywords',
                'alias' => 'bCmsPageI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsPage',
                'on' => 'bCmsPageI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsPage.id', $this->id);
            $criteria->compare('bCmsPage.activated', $this->activated);
            $criteria->compare('bCmsPage.cache_duration', $this->activated);
            $criteria->compare('bCmsPage.b_cms_layout_id', $this->b_cms_layout_id);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('bCmsPage.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsPage.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('bCmsPage.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('bCmsPage.created_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsPageI18ns.title', $this->lk_b_cms_page_i18ns_title, true);
            $criteria->compare('bCmsPageI18ns.slug', $this->lk_b_cms_page_i18ns_slug, true);
            $criteria->compare('bCmsPageI18ns.html_title', $this->lk_b_cms_page_i18ns_html_title, true);
            $criteria->compare('bCmsPageI18ns.html_description', $this->lk_b_cms_page_i18ns_html_description, true);
            $criteria->compare('bCmsPageI18ns.html_keywords', $this->lk_b_cms_page_i18ns_html_keywords, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsPage.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsPage.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsPage.activated' => array(
                    	'label' => $this->getAttributeLabel('activated'),
                    ),
                    'bCmsPage.cache_duration' => array(
                        'label' => $this->getAttributeLabel('cache_duration'),
                    ),
                    'bCmsPage.b_cms_layout_id' => array(
                    	'label' => $this->getAttributeLabel('b_cms_layout_id'),
                    ),
                    'bCmsPage.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsPage.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsPageI18ns.title' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_i18ns_title'),
                    ),
                    'bCmsPageI18ns.slug' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_i18ns_slug'),
                    ),
                    'bCmsPageI18ns.html_title' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_i18ns_html_title'),
                    ),
                    'bCmsPageI18ns.html_description' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_i18ns_html_description'),
                    ),
                    'bCmsPageI18ns.html_keywords' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_i18ns_html_keywords'),
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