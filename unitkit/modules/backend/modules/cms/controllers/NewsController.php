<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsController extends BAutoController
{
    protected $_model = 'BCmsNews';
    protected $_modelI18n = 'BCmsNewsI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BCmsNewsGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsNewsGroupI18n',
                'select' => array(
                    'id' => 'b_cms_news_group_id',
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