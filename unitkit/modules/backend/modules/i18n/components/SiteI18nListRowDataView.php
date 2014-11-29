<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nListRowDataView extends BListRowItemDataView
{

    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {
        $this->pk = $pk;
        $this->items = array(
            isset($data->bI18nI18ns[0]) ? $data->bI18nI18ns[0]->name : '',
            BHtml::activeCheckBox($data, 'activated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
        );
    }
}