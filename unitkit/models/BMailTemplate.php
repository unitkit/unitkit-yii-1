<?php

/**
 * This is the model class for table "b_mail_template"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BMailTemplate extends CActiveRecord
{
    // related attributes
    public $lk_b_mail_template_i18ns_object;
    public $lk_b_mail_template_i18ns_message;

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
        return 'b_mail_template';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('b_mail_template_group_id, html_mode, created_at, updated_at', 'required', 'on' => array('insert', 'update')), array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('b_mail_template_group_id', 'type', 'type' => 'integer'),
            array('html_mode', 'boolean', 'on' => array('insert', 'update')),
            array('sql_request', 'length', 'max' => 65535),
            array('sql_request', 'type', 'type' => 'string'),
            array('sql_param', 'length', 'max' => 65535),
            array('sql_param', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => BTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, b_mail_template_group_id, html_mode, sql_request, sql_param, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_b_mail_template_i18ns_object, lk_b_mail_template_i18ns_message',
                'safe', 'on' => 'search'
            )
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'bMailTemplateGroup' => array(self::BELONGS_TO, 'BMailTemplateGroup', 'b_mail_template_group_id'),
            'bMailTemplateGroupI18ns' => array(self::HAS_MANY, 'BMailTemplateGroupI18n', array('b_mail_template_group_id' => 'b_mail_template_group_id')),
            'bMailSendingRoles' => array(self::HAS_MANY, 'BMailSendingRole', 'b_mail_template_id'),
            'bMailTemplateI18ns' => array(self::HAS_MANY, 'BMailTemplateI18n', 'b_mail_template_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array('id' => B::t('unitkit', 'model:id'),
            'b_mail_template_group_id' => B::t('unitkit', 'b_mail_template:b_mail_template_group_id'),
            'html_mode' => B::t('unitkit', 'b_mail_template:html_mode'),
            'sql_request' => B::t('unitkit', 'b_mail_template:sql_request'),
            'sql_param' => B::t('unitkit', 'b_mail_template:sql_param'),
            'created_at' => B::t('unitkit', 'model:created_at'), 'updated_at' => B::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_b_mail_template_i18ns_object' => BMailTemplateI18n::model()->getAttributeLabel('object'),
            'lk_b_mail_template_i18ns_message' => BMailTemplateI18n::model()->getAttributeLabel('message'),
            'lk_b_mail_template_group_i18ns_name' => BMailTemplateGroupI18n::model()->getAttributeLabel('name')
        );
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
        $criteria->alias = 'bMailTemplate';
        $criteria->with = array(
            'bMailTemplateGroupI18ns' => array('select' => 'name', 'alias' => 'bMailTemplateGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'bMailTemplate',
                'on' => 'bMailTemplateGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'bMailTemplateI18ns' => array('select' => 'object,message', 'alias' => 'bMailTemplateI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'bMailTemplate',
                'on' => 'bMailTemplateI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('bMailTemplate.id', $this->id);
            $criteria->compare('bMailTemplate.b_mail_template_group_id', $this->b_mail_template_group_id);
            $criteria->compare('bMailTemplate.html_mode', $this->html_mode);
            $criteria->compare('bMailTemplate.sql_request', $this->sql_request, true);
            $criteria->compare('bMailTemplate.sql_param', $this->sql_param, true);
            if ($this->v_created_at_start != '') {
                $criteria->addCondition('bMailTemplate.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('bMailTemplate.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('bMailTemplate.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('bMailTemplate.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('bMailTemplateI18ns.object', $this->lk_b_mail_template_i18ns_object, true);
            $criteria->compare('bMailTemplateI18ns.message', $this->lk_b_mail_template_i18ns_message, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('bMailTemplate.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'bMailTemplate.id' => array('label' => $this->getAttributeLabel('id')),
                        'bMailTemplate.b_mail_template_group_id' => array('label' => $this->getAttributeLabel('b_mail_template_group_id')),
                        'bMailTemplate.html_mode' => array('label' => $this->getAttributeLabel('html_mode')),
                        'bMailTemplate.sql_request' => array('label' => $this->getAttributeLabel('sql_request')),
                        'bMailTemplate.sql_param' => array('label' => $this->getAttributeLabel('sql_param')),
                        'bMailTemplate.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'bMailTemplate.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'bMailTemplateI18ns.object' => array('label' => $this->getAttributeLabel('lk_b_mail_template_i18ns_object')),
                        'bMailTemplateI18ns.message' => array('label' => $this->getAttributeLabel('lk_b_mail_template_i18ns_message')),
                        'bMailTemplateGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_b_mail_template_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}