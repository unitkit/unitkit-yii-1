<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableListRowDataView extends UListRowItemDataView
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
            isset($data->uVariableGroupI18ns[0]) ? $data->uVariableGroupI18ns[0]->name : '',
            $data->param,
            $data->val,
            isset($data->uVariableI18ns[0]) ? $data->uVariableI18ns[0]->description : ''
        );
    }
}