<?php

/**
 * This is the model class for table "b_cms_image"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BCmsImage extends CActiveRecord
{
    /**
     * Upload attribute
     *
     * @var array
     */
    public static $upload = array(
		'file_path' => array(
            'types' => array('jpg', 'jpeg', 'gif', 'png'),
            'max' => 10485760, // 10MB = 1024x1024x10
        	'pathDest' => '',
			'urlDest' => '',
        ),
    );

    /**
     * Array of operations used from uploader component
     *
     * @var array
     */
    public $uploadOperations;

    // related attributes
	public $lk_b_cms_image_i18ns_title;

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
        return 'b_cms_image';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('file_path, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('file_path', 'length', 'max' => 255),
            array('file_path', 'type', 'type' => 'string', 'on' => array('insert', 'update', 'search')),
            array('file_path', 'file', 'types' => implode(',', static::$upload['file_path']['types']),
                'maxSize' => static::$upload['file_path']['max'], 'on'=> array('upload')),
            array('file_path', 'default', 'setOnEmpty' => true, 'value' => null),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, file_path, code, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_cms_image_i18ns_title',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bCmsImageI18ns' => array(self::HAS_MANY, 'BCmsImageI18n', 'b_cms_image_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => B::t('unitkit', 'model:id'),
            'file_path' => B::t('unitkit', $this->tableName().':file_path'),
            'code' => B::t('unitkit', $this->tableName().':code'),
            'created_at' => B::t('unitkit', 'model:created_at'),
            'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_cms_image_i18ns_title' => BCmsImageI18n::model()->getAttributeLabel('title'),
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
        $criteria->alias = 'bCmsImage';
        $criteria->with = array(
            'bCmsImageI18ns' => array(
                'select' => 'title',
                'alias' => 'bCmsImageI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'bCmsImage',
                'on' => 'bCmsImageI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('bCmsImage.id', $this->id);
            $criteria->compare('bCmsImage.file_path', $this->file_path, true);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('bCmsImage.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('bCmsImage.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('bCmsImage.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('bCmsImage.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bCmsImageI18ns.title', $this->lk_b_cms_image_i18ns_title, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('bCmsImage.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'bCmsImage.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'bCmsImage.file_path' => array(
                    	'label' => $this->getAttributeLabel('file_path'),
                    ),
                    'bCmsImage.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'bCmsImage.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'bCmsImageI18ns.title' => array(
                    	'label' => $this->getAttributeLabel('lk_b_cms_image_i18ns_title'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}