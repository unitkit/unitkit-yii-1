<?php

/**
 * This is the model class for table "u_cms_album"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsAlbum extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_album_i18ns_title;

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
        return 'u_cms_album';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_album_i18ns_title',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsAlbumImages' => array(self::HAS_MANY, 'UCmsAlbumImage', 'u_cms_album_id'),
            'uCmsAlbumI18ns' => array(self::HAS_MANY, 'UCmsAlbumI18n', 'u_cms_album_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_album_i18ns_title' => UCmsAlbumI18n::model()->getAttributeLabel('title'),
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
        $criteria->alias = 'uCmsAlbum';
        $criteria->with = array(
            'uCmsAlbumI18ns' => array(
                'select' => 'title',
                'alias' => 'uCmsAlbumI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsAlbum',
                'on' => 'uCmsAlbumI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsAlbum.id', $this->id);
            if($this->v_created_at_start != '')
            {
                $criteria->addCondition('uCmsAlbum.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '')
            {
                $criteria->addCondition('uCmsAlbum.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '')
            {
                $criteria->addCondition('uCmsAlbum.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '')
            {
                $criteria->addCondition('uCmsAlbum.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsAlbumI18ns.title', $this->lk_u_cms_album_i18ns_title, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsAlbum.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsAlbum.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsAlbum.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsAlbum.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsAlbumI18ns.title' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_album_i18ns_title'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}