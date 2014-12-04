<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerListRowDataView extends UListRowItemDataView
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
            isset($data->uCmsPageI18ns[0]) ? $data->uCmsPageI18ns[0]->title : '',
            isset($data->uCmsLayoutI18ns[0]) ? $data->uCmsLayoutI18ns[0]->name : '',
            isset($data->uCmsPageI18ns[0]) ? $data->uCmsPageI18ns[0]->slug : '',
            UHtml::activeCheckBox($data, 'activated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            $data->cache_duration,
        );
    }
}