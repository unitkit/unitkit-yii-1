<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerListRowDataView extends BListRowItemDataView
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
            isset($data->bCmsPageI18ns[0]) ? $data->bCmsPageI18ns[0]->slug : '',
            BHtml::activeCheckBox($data, 'activated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            $data->cache_duration,
            isset($data->bCmsPageI18ns[0]) ? $data->bCmsPageI18ns[0]->title : '',
            isset($data->bCmsLayoutI18ns[0]) ? $data->bCmsLayoutI18ns[0]->name : '',
        );
    }
}