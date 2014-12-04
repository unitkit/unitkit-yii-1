<?php

/**
 * This is the model class for table "u_cms_page_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsPageI18n extends CActiveRecord
{
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
        return 'u_cms_page_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('u_cms_page_id, i18n_id, title, slug, html_title', 'required', 'on' => array('insert', 'update')),
			array('title, slug, html_title', 'required', 'on' => 'preInsert'),
            array('u_cms_page_id', 'unsafe', 'on' => array('insert', 'update')),
            array('u_cms_page_id', 'type', 'type' => 'integer'),
            array('i18n_id', 'unsafe', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('title', 'length', 'max' => 255),
            array('title', 'type', 'type' => 'string'),
            array('slug', 'length', 'max' => 130),
            array('slug', 'type', 'type' => 'string'),
            array('slug', 'uniqueSlug', 'on' => array('preInsert', 'insert', 'update')),
            array('slug', 'filter', 'filter' => function($string) {
                    $slug = preg_replace('/[^A-Za-z0-9-.]+/', '-', $string);
                    return $slug;
                }, 'on' => array('preInsert', 'insert', 'update')),
            array('html_title', 'length', 'max' => 255),
            array('html_title', 'type', 'type' => 'string'),
            array('html_description', 'length', 'max' => 65535),
            array('html_description', 'type', 'type' => 'string'),
            array('html_keywords', 'length', 'max' => 65535),
            array('html_keywords', 'type', 'type' => 'string'),

            // search
            array('u_cms_page_id, i18n_id, title, slug, html_title, html_description, html_keywords',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * Verify if slug already exist
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function uniqueSlug($attribute, $params)
    {
        $criteria = array(
            'select' => '1',
            'condition' => 'slug = :slug AND i18n_id = :i18n_id',
            'params' => array(
                ':slug' => $this->slug,
                ':i18n_id' => $this->i18n_id
            )
        );

        if($this->u_cms_page_id !== null) {
            $criteria['condition'] .= ' AND u_cms_page_id <> :u_cms_page_id';
            $criteria['params'] += array(
                ':u_cms_page_id' => $this->u_cms_page_id
            );
        }

        $cmsPage = $this->find($criteria);

        if ($cmsPage !== null)
            $this->addError('slug', Unitkit::t('unitkit', 'u_cms_page_i18n_slug_exist'));
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsPage' => array(self::BELONGS_TO, 'UCmsPage', 'u_cms_page_id'),
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'u_cms_page_id' => Unitkit::t('unitkit', $this->tableName().':u_cms_page_id'),
            'i18n_id' => Unitkit::t('unitkit', $this->tableName().':i18n_id'),
            'title' => Unitkit::t('unitkit', $this->tableName().':title'),
            'slug' => Unitkit::t('unitkit', $this->tableName().':slug'),
            'html_title' => Unitkit::t('unitkit', $this->tableName().':html_title'),
            'html_description' => Unitkit::t('unitkit', $this->tableName().':html_description'),
            'html_keywords' => Unitkit::t('unitkit', $this->tableName().':html_keywords'),
        );
    }
}