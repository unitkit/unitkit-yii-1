<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableListRowDataView extends BListRowItemDataView
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
            isset($data->bVariableGroupI18ns[0]) ? $data->bVariableGroupI18ns[0]->name : '',
            $data->param,
            $data->val,
            isset($data->bVariableI18ns[0]) ? $data->bVariableI18ns[0]->description : ''
        );
    }
}