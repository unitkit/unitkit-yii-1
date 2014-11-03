<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateListRowDataView extends BListRowItemDataView
{

    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {
        $this->isTranslatable = true;
        $this->pk = $pk;
        $this->items = array(
            isset($data->bMailTemplateGroupI18ns[0]) ? $data->bMailTemplateGroupI18ns[0]->name : '',
            BHtml::activeCheckBox($data, 'html_mode', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            // $data->sql_request,
            // $data->sql_param,
            isset($data->bMailTemplateI18ns[0]) ? $data->bMailTemplateI18ns[0]->object : '',
            isset($data->bMailTemplateI18ns[0]) ? $data->bMailTemplateI18ns[0]->message : ''
        // Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $data->created_at, 'yyyy-MM-dd hh:mm:ss'
        // )),
        // Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
        // $data->updated_at, 'yyyy-MM-dd hh:mm:ss'
        // )),
                );
    }
}