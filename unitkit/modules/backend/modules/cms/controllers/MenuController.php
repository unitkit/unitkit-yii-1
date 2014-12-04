<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuController extends UAutoController
{
    protected $_model = 'UCmsMenu';
    protected $_modelI18n = 'UCmsMenuI18n';

    /**
     * @see BBaseAutoController::advancedConbobox()
     */
    protected function _advancedComboBox()
    {
        return array(
            'UCmsMenuGroupI18n[name]' => array(
                'search' => $_GET['search'],
                'model' => 'UCmsMenuGroupI18n',
                'select' => array(
                    'id' => 'u_cms_menu_group_id',
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
                $menu = $model::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk, array('select' => 'id, u_cms_menu_group_id'));
                if ($menu !== null) {
                    UCmsMenu::clearMenuCache($menu->u_cms_menu_group_id);
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
        $cmsMenu = UCmsMenu::model()->findByPk(
            $models[Yii::app()->language]->{$this->linkModels},
            array('select' => 'u_cms_menu_group_id')
        );
        UCmsMenu::clearMenuCache($cmsMenu->u_cms_menu_group_id);
    }

    /**
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        UCmsMenu::clearMenuCache($models[$this->_model]->u_cms_menu_group_id);
    }
}