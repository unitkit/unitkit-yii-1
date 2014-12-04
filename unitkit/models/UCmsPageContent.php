<?php

/**
 * This is the model class for table "u_cms_page_content"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsPageContent extends CActiveRecord
{
    /**
     * Maximum number of container
     */
    const MAX_CONTAINER = 20;

    // related attributes
	public $lk_u_cms_page_content_i18ns_content;

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
        return 'u_cms_page_content';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_page_id, index', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('u_cms_page_id', 'type', 'type' => 'integer'),
            array('index', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => self::MAX_CONTAINER),
            // search
            array('id, u_cms_page_id, b_cms_container_type_id, index, lk_u_cms_page_content_i18ns_content',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsPage' => array(self::BELONGS_TO, 'UCmsPage', 'u_cms_page_id'),
            'uCmsPageContentI18ns' => array(self::HAS_MANY, 'UCmsPageContentI18n', 'u_cms_page_content_id'),
            'uCmsPageContentI18n' => array(self::BELONGS_TO, 'UCmsPageContentI18n', array('id' => 'u_cms_page_content_id'),
                'alias' => 'uCmsPageContentI18n', 'on' => 'uCmsPageContentI18n.i18n_id = :i18n_id', 'params' => array(':i18n_id' => Yii::app()->language)
            ),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('openBlob', 'model:id'),
            'u_cms_page_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_page_id'),
            'b_cms_container_type_id' => Unitkit::t('unitkit', $this->tableName().':b_cms_container_type_id'),
            'index' => Unitkit::t('unitkit', $this->tableName().':index'),

            // related attributes
            'lk_u_cms_page_content_i18ns_content' => UCmsPageContentI18n::model()->getAttributeLabel('content'),
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
        $criteria->alias = 'uCmsPageContent';
        $criteria->with = array(
            'uCmsPageContentI18ns' => array(
                'select' => 'content',
                'alias' => 'uCmsPageContentI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsPageContent',
                'on' => 'uCmsPageContentI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsPageContent.id', $this->id);
            $criteria->compare('uCmsPageContent.u_cms_page_id', $this->u_cms_page_id);
            $criteria->compare('uCmsPageContent.b_cms_container_type_id', $this->b_cms_container_type_id);
            $criteria->compare('uCmsPageContent.index', $this->index);
            $criteria->compare('uCmsPageContentI18ns.content', $this->lk_u_cms_page_content_i18ns_content, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsPageContent.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsPageContent.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsPageContent.u_cms_page_id' => array(
                    	'label' => $this->getAttributeLabel('u_cms_page_id'),
                    ),
                    'uCmsPageContent.b_cms_container_type_id' => array(
                    	'label' => $this->getAttributeLabel('b_cms_container_type_id'),
                    ),
                    'uCmsPageContent.index' => array(
                    	'label' => $this->getAttributeLabel('index'),
                    ),
                    'uCmsPageContentI18ns.content' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_page_content_i18ns_content'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}