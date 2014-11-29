<?php

/**
 * This is the model class for table "b_cms_news"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsNews extends CActiveRecord
{
    // related attributes
    public $lk_b_cms_news_i18ns_title;
    public $lk_b_cms_news_i18ns_content;

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
        return 'b_cms_news';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_news_group_id, created_at, updated_at, activated, published_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('b_cms_news_group_id', 'type', 'type' => 'integer'),
            array('published_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, b_cms_news_group_id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, activated, v_published_at_start, v_published_at_end, lk_b_cms_news_i18ns_title, lk_b_cms_news_i18ns_content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsNewsGroup' => array(self::BELONGS_TO, 'BCmsNewsGroup', 'b_cms_news_group_id'),
            'bCmsNewsGroupI18ns' => array(self::HAS_MANY, 'BCmsNewsGroupI18n', array('b_cms_news_group_id' => 'b_cms_news_group_id')),
            'bCmsNewsI18ns' => array(self::HAS_MANY, 'BCmsNewsI18n', 'b_cms_news_id'),
            'bCmsNewsI18n' => array(self::BELONGS_TO, 'BCmsNewsI18n', array('id' => 'b_cms_news_id'),
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
            'b_cms_news_group_id' => B::t('unitkit', $this->tableName().':b_cms_news_group_id'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),
            'activated' => B::t('unitkit', 'model:activated'),
            'published_at' => B::t('unitkit', $this->tableName().':published_at'),

            // related attributes
            'lk_b_cms_news_i18ns_title' => BCmsNewsI18n::model()->getAttributeLabel('title'),
            'lk_b_cms_news_i18ns_content' => BCmsNewsI18n::model()->getAttributeLabel('content'),
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
        $criteria->alias = 'bCmsNews';
        $criteria->with = array(
            'bCmsNewsI18n',
        );

        if ($this->validate()) {
            $criteria->compare('bCmsNews.id', $this->id);
            $criteria->compare('bCmsNews.b_cms_news_group_id', $this->b_cms_news_group_id);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('bCmsNews.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('bCmsNews.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('bCmsNews.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('bCmsNews.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsNews.activated', $this->activated);
            if($this->v_published_at_start != '')
            {
                $criteria->addCondition('bCmsNews.published_at >= :v_published_at_start');
                $criteria->params += array(':v_published_at_start' => $this->v_published_at_start);
            }
            if($this->v_published_at_end != '')
            {
                $criteria->addCondition('bCmsNews.published_at <= DATE_ADD(:v_published_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_published_at_end' => $this->v_published_at_end);
            }
            $criteria->compare('bCmsNewsI18ns.title', $this->lk_b_cms_news_i18ns_title, true);
            $criteria->compare('bCmsNewsI18ns.content', $this->lk_b_cms_news_i18ns_content, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsNews.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsNews.id' => array(
                        'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsNews.b_cms_news_group_id' => array(
                        'label' => $this->getAttributeLabel('b_cms_news_group_id'),
                    ),
                    'bCmsNews.created_at' => array(
                        'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsNews.updated_at' => array(
                        'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsNews.activated' => array(
                        'label' => $this->getAttributeLabel('activated'),
                    ),
                    'bCmsNews.published_at' => array(
                        'label' => $this->getAttributeLabel('published_at'),
                    ),
                    'bCmsNewsI18ns.title' => array(
                        'label' => $this->getAttributeLabel('lk_b_cms_news_i18ns_title'),
                    ),
                    'bCmsNewsI18ns.content' => array(
                        'label' => $this->getAttributeLabel('lk_b_cms_news_i18ns_content'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}