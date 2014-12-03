<?php

/**
 * Controller of auto login
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AutoLoginController extends BAutoController
{
    protected $_model = 'BAutoLogin';

    /**
     * (non-PHPdoc)
     *
     * @see BBaseController::setDefaultRoles()
     */
    public function setDefaultRoles()
    {
        parent::setDefaultRoles();
        unset($this->_defaultRoles['create']);
        unset($this->_defaultRoles['update']);
    }

    protected function _advancedComboBox()
    {
        return array(
            'BPerson[fullname]' => array(
                'search' => $_GET['search'],
                'model' => 'BPerson',
                'select' => array(
                    'id' => 'id',
                    'text' => 'fullname'
                ),
                'criteria' => array(
                    'select' => 'first_name, last_name, id',
                    'limit' => 10,
                    'order' => 'email ASC'
                ),
                'cache' => 10
            )
        );
    }
}