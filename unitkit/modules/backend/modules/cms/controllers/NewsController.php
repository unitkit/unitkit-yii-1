<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsController extends UAutoController
{
    protected $_model = 'UCmsNews';
    protected $_modelI18n = 'UCmsNewsI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UCmsNewsGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UCmsNewsGroupI18n',
                'select' => array(
                    'id' => 'u_cms_news_group_id',
                    'text' => 'name'
                ),
                'criteria' => array(
                  'condition' => 'i18n_id = :i18nId',
                    'params' => array(':i18nId' => $_GET['language']),
                  'order' => 'name ASC',
                    'limit' => 10,
                ),
                'cache' => isset($_GET['cache']) ? 10 : 0,
            ),
        );
    }
}