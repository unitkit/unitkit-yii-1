<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuListRowDataView extends BListRowItemDataView
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
            isset($data->bCmsMenuGroupI18ns[0]) ? $data->bCmsMenuGroupI18ns[0]->name : '',
            $data->rank,
            isset($data->bCmsMenuI18ns[0]) ? $data->bCmsMenuI18ns[0]->name : '',
            isset($data->bCmsMenuI18ns[0]) ? $data->bCmsMenuI18ns[0]->url : '',
        );
    }
}