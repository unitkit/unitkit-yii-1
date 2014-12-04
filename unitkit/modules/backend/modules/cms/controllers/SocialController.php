<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SocialController extends UAutoController
{
    protected $_model = 'UCmsSocial';
    protected $_modelI18n = 'UCmsSocialI18n';

    /**
     * @see BBaseController::setDefaultRoles()
     */
    public function setDefaultRoles()
    {
        parent::setDefaultRoles();
        unset($this->_defaultRoles['create']);
        unset($this->_defaultRoles['delete']);
    }
}