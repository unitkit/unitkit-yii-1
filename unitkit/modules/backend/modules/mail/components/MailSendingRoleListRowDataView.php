<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailSendingRoleListRowDataView extends BListRowItemDataView
{

    /**
     * Constructor
     *
     * @param CModel $data
     * @param mixed $pk
     */
    public function __construct($data, $pk)
    {
        $this->pk = $pk;
        $this->items = array(
            isset($data->bMailSendRoleI18ns[0]) ? $data->bMailSendRoleI18ns[0]->name : '',
            $data->bPerson->fullName
        );
    }
}