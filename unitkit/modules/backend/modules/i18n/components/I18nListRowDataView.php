<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class I18nListRowDataView extends UListRowItemDataView
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
            isset($data->uI18nI18ns[0]) ? $data->uI18nI18ns[0]->name : '',
            $data->id
        );
    }
}