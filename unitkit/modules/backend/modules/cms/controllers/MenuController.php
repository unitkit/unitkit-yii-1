<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuController extends BAutoController
{
    protected $_model = 'BCmsMenu';
    protected $_modelI18n = 'BCmsMenuI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'BCmsMenuGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'BCmsMenuGroupI18n',
                'select' => array(
                    'id' => 'b_cms_menu_group_id',
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

    /**
     * Delete list of rows (Action)
     */
    public function actionDeleteRows()
    {
        $return = array('success' => false);

        if (Yii::app()->request->isPostRequest && isset($_POST['rows']) && is_array($_POST['rows'])) {
            $model = $this->_model;
            foreach ($_POST['rows'] as $tmp) {
                parse_str($tmp, $pk);
                $menu = $model::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk, array('select' => 'id, b_cms_menu_group_id'));
                if ($menu !== null) {
                    BCmsMenu::clearMenuCache($menu->b_cms_menu_group_id);
                    $menu->delete();
                }
            }
            unset($model);
            $return['success'] = true;
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    /**
     * @see BBaseAutoController::_afterSaveTranslationModels()
     */
    protected function _afterSaveTranslationModels(&$models)
    {
        $cmsMenu = BCmsMenu::model()->findByPk(
            $models[Yii::app()->language]->{$this->linkModels},
            array('select' => 'b_cms_menu_group_id')
        );
        BCmsMenu::clearMenuCache($cmsMenu->b_cms_menu_group_id);
    }

    /**
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        BCmsMenu::clearMenuCache($models[$this->_model]->b_cms_menu_group_id);
    }
}