<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsGroupController extends BAutoController
{
    protected $_model = 'BCmsNewsGroup';
    protected $_modelI18n = 'BCmsNewsGroupI18n';

    /**
     * (non-PHPdoc)
     *
     * @see BBaseAutoController::uploader()
     */
    protected function _uploader()
    {
        return array(
        );
    }

    /**
     * (non-PHPdoc)
     *
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedConbobox()
    {
        return array(
        );
    }
}