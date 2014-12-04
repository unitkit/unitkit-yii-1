<?php

/**
 * This is the model class for table "u_mail_template"
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UMailTemplate extends CActiveRecord
{
    // related attributes
    public $lk_u_mail_template_i18ns_object;
    public $lk_u_mail_template_i18ns_message;

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
        return 'u_mail_template';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            // save
            array('u_mail_template_group_id, html_mode, created_at, updated_at', 'required', 'on' => array('insert', 'update')), array('created_at', 'unsafe'),
            array('id', 'unsafe', 'on' => array('insert', 'update')),
            array('id', 'type', 'type' => 'integer'),
            array('u_mail_template_group_id', 'type', 'type' => 'integer'),
            array('html_mode', 'boolean', 'on' => array('insert', 'update')),
            array('sql_request', 'length', 'max' => 65535),
            array('sql_request', 'type', 'type' => 'string'),
            array('sql_param', 'length', 'max' => 65535),
            array('sql_param', 'type', 'type' => 'string'),
            array('created_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => UTools::now(), 'setOnEmpty' => false, 'on' => array('update', 'insert')),

            // search
            array('id, u_mail_template_group_id, html_mode, sql_request, sql_param, v_created_at_start, v_created_at_end, v_updated_at_start, v_updated_at_end, lk_u_mail_template_i18ns_object, lk_u_mail_template_i18ns_message',
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
            'uMailTemplateGroup' => array(self::BELONGS_TO, 'UMailTemplateGroup', 'u_mail_template_group_id'),
            'uMailTemplateGroupI18ns' => array(self::HAS_MANY, 'UMailTemplateGroupI18n', array('u_mail_template_group_id' => 'u_mail_template_group_id')),
            'uMailSendingRoles' => array(self::HAS_MANY, 'UMailSendingRole', 'u_mail_template_id'),
            'uMailTemplateI18ns' => array(self::HAS_MANY, 'UMailTemplateI18n', 'u_mail_template_id')
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array('id' => Unitkit::t('unitkit', 'model:id'),
            'u_mail_template_group_id' => Unitkit::t('unitkit', 'u_mail_template:u_mail_template_group_id'),
            'html_mode' => Unitkit::t('unitkit', 'u_mail_template:html_mode'),
            'sql_request' => Unitkit::t('unitkit', 'u_mail_template:sql_request'),
            'sql_param' => Unitkit::t('unitkit', 'u_mail_template:sql_param'),
            'created_at' => Unitkit::t('unitkit', 'model:created_at'), 'updated_at' => Unitkit::t('unitkit', 'model:updated_at'),

            // related attributes
            'lk_u_mail_template_i18ns_object' => UMailTemplateI18n::model()->getAttributeLabel('object'),
            'lk_u_mail_template_i18ns_message' => UMailTemplateI18n::model()->getAttributeLabel('message'),
            'lk_u_mail_template_group_i18ns_name' => UMailTemplateGroupI18n::model()->getAttributeLabel('name')
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
        $criteria->alias = 'uMailTemplate';
        $criteria->with = array(
            'uMailTemplateGroupI18ns' => array('select' => 'name', 'alias' => 'uMailTemplateGroupI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'uMailTemplate',
                'on' => 'uMailTemplateGroupI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            ),
            'uMailTemplateI18ns' => array('select' => 'object,message', 'alias' => 'uMailTemplateI18ns',
                'joinType' => 'LEFT JOIN', 'together' => 'uMailTemplate',
                'on' => 'uMailTemplateI18ns.i18n_id = :id18nId',
                'params' => array(':id18nId' => $i18nId)
            )
        );

        if ($this->validate()) {
            $criteria->compare('uMailTemplate.id', $this->id);
            $criteria->compare('uMailTemplate.u_mail_template_group_id', $this->u_mail_template_group_id);
            $criteria->compare('uMailTemplate.html_mode', $this->html_mode);
            $criteria->compare('uMailTemplate.sql_request', $this->sql_request, true);
            $criteria->compare('uMailTemplate.sql_param', $this->sql_param, true);
            if ($this->v_created_at_start != '') {
                $criteria->addCondition('uMailTemplate.created_at >= :v_created_at_start');
                $criteria->params += array(':v_created_at_start' => $this->v_created_at_start);
            }
            if ($this->v_created_at_end != '') {
                $criteria->addCondition('uMailTemplate.created_at <= DATE_ADD(:v_created_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_created_at_end' => $this->v_created_at_end);
            }
            if ($this->v_updated_at_start != '') {
                $criteria->addCondition('uMailTemplate.updated_at >= :v_updated_at_start');
                $criteria->params += array(':v_updated_at_start' => $this->v_updated_at_start);
            }
            if ($this->v_updated_at_end != '') {
                $criteria->addCondition('uMailTemplate.updated_at <= DATE_ADD(:v_updated_at_end, INTERVAL 1 DAY)');
                $criteria->params += array(':v_updated_at_end' => $this->v_updated_at_end);
            }
            $criteria->compare('uMailTemplateI18ns.object', $this->lk_u_mail_template_i18ns_object, true);
            $criteria->compare('uMailTemplateI18ns.message', $this->lk_u_mail_template_i18ns_message, true);
        }

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'sort' => array(
                    'sortVar' => 'sort',
                    'defaultOrder' => array('uMailTemplate.id' => CSort::SORT_DESC),
                    'attributes' => array(
                        'uMailTemplate.id' => array('label' => $this->getAttributeLabel('id')),
                        'uMailTemplate.u_mail_template_group_id' => array('label' => $this->getAttributeLabel('u_mail_template_group_id')),
                        'uMailTemplate.html_mode' => array('label' => $this->getAttributeLabel('html_mode')),
                        'uMailTemplate.sql_request' => array('label' => $this->getAttributeLabel('sql_request')),
                        'uMailTemplate.sql_param' => array('label' => $this->getAttributeLabel('sql_param')),
                        'uMailTemplate.created_at' => array('label' => $this->getAttributeLabel('created_at')),
                        'uMailTemplate.updated_at' => array('label' => $this->getAttributeLabel('updated_at')),
                        'uMailTemplateI18ns.object' => array('label' => $this->getAttributeLabel('lk_u_mail_template_i18ns_object')),
                        'uMailTemplateI18ns.message' => array('label' => $this->getAttributeLabel('lk_u_mail_template_i18ns_message')),
                        'uMailTemplateGroupI18ns.name' => array('label' => $this->getAttributeLabel('lk_u_mail_template_group_i18ns_name'))
                    )
                ),
                'pagination' => array('pageVar' => 'page')
            )
        );
    }
}