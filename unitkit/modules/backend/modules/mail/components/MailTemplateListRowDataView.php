<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateListRowDataView extends UListRowItemDataView
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
            isset($data->uMailTemplateGroupI18ns[0]) ? $data->uMailTemplateGroupI18ns[0]->name : '',
            UHtml::activeCheckBox($data, 'html_mode', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            isset($data->uMailTemplateI18ns[0]) ? $data->uMailTemplateI18ns[0]->object : '',
            isset($data->uMailTemplateI18ns[0]) ? $data->uMailTemplateI18ns[0]->message : ''
        );
    }
}