<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuGroupController extends UAutoController
{
    protected $_model = 'UCmsMenuGroup';
    protected $_modelI18n = 'UCmsMenuGroupI18n';

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
                $menuGroup = $model::model()->findByPk(count($pk) == 1 ? reset($pk) : $pk, array('select' => 'id'));
                if($menuGroup !== null) {
                    UCmsMenu::clearMenuCache($menuGroup->id);
                    $menuGroup->delete();
                }
            }
            unset($model);
            $return['success'] = true;
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }

    /**
     * @see BBaseAutoController::_afterSaveEditModels()
     */
    protected function _afterSaveEditModels(&$models)
    {
        UCmsMenu::clearMenuCache($models[$this->_model]->id);
    }

    /**
     * @see BBaseAutoController::_afterSaveTranslationModels()
     */
    protected function _afterSaveTranslationModels(&$models)
    {
        $cmsMenuGroup = UCmsMenuGroup::model()->findByPk(
            $models[Yii::app()->language]->{$this->linkModels},
            array('select' => 'id')
        );
        UCmsMenu::clearMenuCache($cmsMenuGroup->id);
    }
}