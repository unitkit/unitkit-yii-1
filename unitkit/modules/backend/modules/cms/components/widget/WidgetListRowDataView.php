<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class WidgetListRowDataView extends BListRowItemDataView
{
    /**
     * Constructor
     *
     * @param CModel $data
     * @param mixed $pk
     */
    public function __construct($data, $pk)
    {
        $this->isTranslatable = true;
        $this->pk = $pk;
        $this->items = array(
            isset($data->bCmsWidgetI18ns[0]) ? $data->bCmsWidgetI18ns[0]->name : '',
            $data->path,
            $data->arg
        );
    }
}