<?php

/**
 * This is the model class for table "u_site_i18n"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class USiteI18n extends CActiveRecord
{
    /**
     * Cache duration
     *
     * @var int
     */
    const CACHE_DURATION = 0 /* no limit */;

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
        return 'u_site_i18n';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('i18n_id, activated', 'required', 'on' => array('insert', 'update')),
            array('i18n_id', 'length', 'max' => 16),
            array('i18n_id', 'type', 'type' => 'string'),
            array('activated', 'boolean', 'on' => array('insert', 'update')),
            // search
            array('i18n_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'uI18n' => array(self::BELONGS_TO, 'UI18n', 'i18n_id'),
            'uI18nI18ns' => array(self::HAS_MANY, 'UI18nI18n', array('u_i18n_id' => 'i18n_id'))
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'i18n_id' => Unitkit::t('unitkit', 'u_site_i18n:i18n_id'),
            'activated' => Unitkit::t('unitkit', 'u_site_i18n:activated'),

            // related attributes
            'lk_u_i18n_i18ns_name' => UI18nI18n::model()->getAttributeLabel('name')
        );
    }

    /**
     * Get key name used in the cache
     *
     * @return string
     */
    protected static function getCacheKeyNameI18nIds()
    {
        return 'u_site_i18n_list';
    }

    /**
     * Get the list of i18n ID
     *
     * @param bool $refresh Refresh cache
     * @param int $activated If true get activated languages only. If null get all website languages. If false get disabled languages.
     * @return array
     */
    public function getI18nIds($refresh = false, $activated = null)
    {
        $strActivated = 'null';
        if ($activated === true) {
            $strActivated = '1';
        } elseif ($activated === false) {
            $strActivated = '0';
        }

        $key = self::getCacheKeyNameI18nIds().':activated:'.$strActivated;
        $i18ns = $refresh ? false : Yii::app()->i18nCache->get($key);
        if ($i18ns === false) {
            $args = ($activated === null) ? array() : array('activated' => $activated);
            foreach ($this->findAllByAttributes($args) as $model) {
                $i18ns[$model->i18n_id] = $model->i18n_id;
            }
            Yii::app()->i18nCache->set($key, $i18ns, self::CACHE_DURATION);
        }
        return $i18ns;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @param string i18n ID
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($i18nId)
    {
        $criteria = $this->getDbCriteria();
        $criteria->alias = 'uSiteI18n';
        $criteria->with = array(
            'uI18nI18ns' => array(
                'select' => 'name',
                'alias' => 'uI18nI18ns',
                'joinType' => 'INNER JOIN',
                'together' => 'uSiteI18n', 'on' => 'uI18nI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uSiteI18n.i18n_id', $this->i18n_id, true);
            $criteria->compare('uPerson.activated', $this->activated);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uSiteI18n.i18n_id' => CSort::SORT_ASC),
                    'attributes' => array(
                        'uSiteI18n.i18n_id' => array('label' => $this->getAttributeLabel('i18n_id')),
                        'uSiteI18n.activated' => array('label' => $this->getAttributeLabel('activated')),
                        'uI18nI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_i18n_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}