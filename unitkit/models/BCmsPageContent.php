<?php

/**
 * This is the model class for table "b_cms_page_content"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsPageContent extends CActiveRecord
{
    // related attributes
	public $lk_b_cms_page_content_i18ns_content;

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
        return 'b_cms_page_content';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('b_cms_page_id, index', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('b_cms_page_id', 'type', 'type' => 'integer'),
            array('index', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 20),
            // search
            array('id, b_cms_page_id, b_cms_container_type_id, index, lk_b_cms_page_content_i18ns_content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsPage' => array(self::BELONGS_TO, 'BCmsPage', 'b_cms_page_id'),
            'bCmsPageContentI18ns' => array(self::HAS_MANY, 'BCmsPageContentI18n', 'b_cms_page_content_id'),
            'bCmsPageContentI18n' => array(self::BELONGS_TO, 'BCmsPageContentI18n', array('id' => 'b_cms_page_content_id'),
                'alias' => 'bCmsPageContentI18n', 'on' => 'bCmsPageContentI18n.i18n_id = :i18n_id', 'params' => array(':i18n_id' => Yii::app()->language)
            ),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('openBlob', 'model:id'),
            'b_cms_page_id' => B::t('unitkit', $this->tableName().':b_cms_page_id'),
            'b_cms_container_type_id' => B::t('unitkit', $this->tableName().':b_cms_container_type_id'),
            'index' => B::t('unitkit', $this->tableName().':index'),

            // related attributes
            'lk_b_cms_page_content_i18ns_content' => BCmsPageContentI18n::model()->getAttributeLabel('content'),
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
        $criteria->alias = 'bCmsPageContent';
        $criteria->with = array(
            'bCmsPageContentI18ns' => array(
                'select' => 'content',
                'alias' => 'bCmsPageContentI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsPageContent',
                'on' => 'bCmsPageContentI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsPageContent.id', $this->id);
            $criteria->compare('bCmsPageContent.b_cms_page_id', $this->b_cms_page_id);
            $criteria->compare('bCmsPageContent.b_cms_container_type_id', $this->b_cms_container_type_id);
            $criteria->compare('bCmsPageContent.index', $this->index);
            $criteria->compare('bCmsPageContentI18ns.content', $this->lk_b_cms_page_content_i18ns_content, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsPageContent.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsPageContent.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsPageContent.b_cms_page_id' => array(
                    	'label' => $this->getAttributeLabel('b_cms_page_id'),
                    ),
                    'bCmsPageContent.b_cms_container_type_id' => array(
                    	'label' => $this->getAttributeLabel('b_cms_container_type_id'),
                    ),
                    'bCmsPageContent.index' => array(
                    	'label' => $this->getAttributeLabel('index'),
                    ),
                    'bCmsPageContentI18ns.content' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_page_content_i18ns_content'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}