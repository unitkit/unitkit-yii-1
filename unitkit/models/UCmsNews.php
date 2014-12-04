<?php

/**
 * This is the model class for table "u_cms_news"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsNews extends CActiveRecord
{
    // related attributes
    public $lk_u_cms_news_i18ns_title;
    public $lk_u_cms_news_i18ns_content;

    // virtual attributes
    public $v_created_at_start;
    public $v_created_at_end;
    public $v_updated_at_start;
    public $v_updated_at_end;
    public $v_published_at_start;
    public $v_published_at_end;

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
        return 'u_cms_news';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_news_group_id, created_at, updated_at, activated, published_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('u_cms_news_group_id', 'type', 'type' => 'integer'),
            array('published_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, u_cms_news_group_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, activated, v_published_at_start, v_published_at_end, lk_u_cms_news_i18ns_title, lk_u_cms_news_i18ns_content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsNewsGroup' => array(self::BELONGS_TO, 'UCmsNewsGroup', 'u_cms_news_group_id'),
            'uCmsNewsGroupI18ns' => array(self::HAS_MANY, 'UCmsNewsGroupI18n', array('u_cms_news_group_id' => 'u_cms_news_group_id')),
            'uCmsNewsI18ns' => array(self::HAS_MANY, 'UCmsNewsI18n', 'u_cms_news_id'),
            'uCmsNewsI18n' => array(self::BELONGS_TO, 'UCmsNewsI18n', array('id' => 'u_cms_news_id'),
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
            'u_cms_news_group_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_news_group_id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),
            'activated' => Unitkit::t('unitkit', 'model:activated'),
            'published_at' => Unitkit::t('unitkit', $this->tableName().':published_at'),

            // related attributes
            'lk_u_cms_news_i18ns_title' => UCmsNewsI18n::model()->getAttributeLabel('title'),
            'lk_u_cms_news_i18ns_content' => UCmsNewsI18n::model()->getAttributeLabel('content'),
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
        $criteria->alias = 'uCmsNews';
        $criteria->with = array(
            'uCmsNewsI18n',
        );

        if ($this->validate()) {
            $criteria->compare('uCmsNews.id', $this->id);
            $criteria->compare('uCmsNews.u_cms_news_group_id', $this->u_cms_news_group_id);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('uCmsNews.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('uCmsNews.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('uCmsNews.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('uCmsNews.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsNews.activated', $this->activated);
            if($this->v_published_at_start != '')
            {
                $criteria->addCondition('uCmsNews.published_at >= :v_published_at_start');
                $criteria->params += array(':v_published_at_start' => $this->v_published_at_start);
            }
            if($this->v_published_at_end != '')
            {
                $criteria->addCondition('uCmsNews.published_at <= DATE_ADD(:v_published_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_published_at_end' => $this->v_published_at_end);
            }
            $criteria->compare('uCmsNewsI18ns.title', $this->lk_u_cms_news_i18ns_title, true);
            $criteria->compare('uCmsNewsI18ns.content', $this->lk_u_cms_news_i18ns_content, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsNews.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsNews.id' => array(
                        'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsNews.u_cms_news_group_id' => array(
                        'label' => $this->getAttributeLabel('u_cms_news_group_id'),
                    ),
                    'uCmsNews.created_at' => array(
                        'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsNews.updated_at' => array(
                        'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsNews.activated' => array(
                        'label' => $this->getAttributeLabel('activated'),
                    ),
                    'uCmsNews.published_at' => array(
                        'label' => $this->getAttributeLabel('published_at'),
                    ),
                    'uCmsNewsI18ns.title' => array(
                        'label' => $this->getAttributeLabel('lk_u_cms_news_i18ns_title'),
                    ),
                    'uCmsNewsI18ns.content' => array(
                        'label' => $this->getAttributeLabel('lk_u_cms_news_i18ns_content'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}