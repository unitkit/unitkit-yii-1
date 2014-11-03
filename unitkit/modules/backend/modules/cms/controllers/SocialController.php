<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SocialController extends BAutoController
{
    protected $_model = 'BCmsSocial';
    protected $_modelI18n = 'BCmsSocialI18n';

    /**
     * (non-PHPdoc)
     *
     * @see BBaseController::setDefaultRoles()
     */
    public function setDefaultRoles()
    {
        parent::setDefaultRoles();
        unset($this->_defaultRoles['create']);
        unset($this->_defaultRoles['delete']);
    }
}