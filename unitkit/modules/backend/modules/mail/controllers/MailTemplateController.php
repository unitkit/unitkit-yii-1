<?php

/**
 * Controller of mail template
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailTemplateController extends BAutoController
{
    protected $_model = 'BMailTemplate';
    protected $_modelI18n = 'BMailTemplateI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedConbobox()
    {
        return array(
            'BMailTemplateGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BMailTemplateGroupI18n',
                'select' => array(
                    'id' => 'b_mail_template_group_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                    'condition' => 'i18n_id = :i18nId',
                    'params' => array(
                        ':i18nId' => $_GET['language']
                    ),
                    'order' => 'name ASC',
                    'limit' => 10
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0
            )
        );
    }
}