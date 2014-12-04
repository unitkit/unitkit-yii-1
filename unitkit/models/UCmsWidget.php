<?php

/**
 * This is the model class for table "u_cms_widget"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UCmsWidget extends CActiveRecord
{
    // related attributes
	public $lk_u_cms_widget_i18ns_name;

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
        return 'u_cms_widget';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save
            array('path, created_at, updated_at', 'required', 'on' => array('insert', 'update')),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('path', 'length', 'max' => 255),
            array('path', 'type', 'type' => 'string'),
            array('arg', 'length', 'max' => 65535),
            array('arg', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, path, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_cms_widget_i18ns_name',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uCmsPageContentWidgets' => array(self::HAS_MANY, 'UCmsPageContentWidget', 'u_cms_widget_id'),
            'uCmsWidgetI18ns' => array(self::HAS_MANY, 'UCmsWidgetI18n', 'u_cms_widget_id'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'id' => Unitkit::t('unitkit', 'model:id'),
            'path' => Unitkit::t('unitkit', $this->tableName().':path'),
            'arg' => Unitkit::t('unitkit', $this->tableName().':arg'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'),
            'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_cms_widget_i18ns_name' => UCmsWidgetI18n::model()->getAttributeLabel('name'),
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
        $criteria->alias = 'uCmsWidget';
        $criteria->with = array(
            'uCmsWidgetI18ns' => array(
                'select' => 'name',
                'alias' => 'uCmsWidgetI18ns',
                'joinType' => 'LEFT JOIN',
                'together' => 'uCmsWidget',
                'on' => 'uCmsWidgetI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
        );

        if ($this->validate()) {
            $criteria->compare('uCmsWidget.id', $this->id);
            $criteria->compare('uCmsWidget.path', $this->path, true);
            $criteria->compare('uCmsWidget.arg', $this->arg, true);
            if($this->v_created_at_start != '') {
                $criteria->addCondition('uCmsWidget.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if($this->v_created_at_end != '') {
                $criteria->addCondition('uCmsWidget.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if($this->v_updated_at_start != '') {
                $criteria->addCondition('uCmsWidget.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if($this->v_updated_at_end != '') {
                $criteria->addCondition('uCmsWidget.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uCmsWidgetI18ns.name', $this->lk_u_cms_widget_i18ns_name, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'sortVar' => 'sort',
                'defaultOrder' => array('uCmsWidget.id' => CSort::SORT_DESC),
                'attributes' => array(
                    'uCmsWidget.id' => array(
                    	'label' => $this->getAttributeLabel('id'),
                    ),
                    'uCmsWidget.path' => array(
                    	'label' => $this->getAttributeLabel('path'),
                    ),
                    'uCmsWidget.arg' => array(
                        'label' => $this->getAttributeLabel('arg'),
                    ),
                    'uCmsWidget.created_at' => array(
                    	'label' => $this->getAttributeLabel('created_at'),
                    ),
                    'uCmsWidget.updated_at' => array(
                    	'label' => $this->getAttributeLabel('updated_at'),
                    ),
                    'uCmsWidgetI18ns.name' => array(
                    	'label' => $this->getAttributeLabel('lk_u_cms_widget_i18ns_name'),
                    ),
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page'
            )
        ));
    }
}