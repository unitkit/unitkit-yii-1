<?php

/**
 * Controller
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class AlbumController extends UAutoController
{
    protected $_model = 'UCmsAlbum';
    protected $_modelI18n = 'UCmsAlbumI18n';

    public function actionSettings()
    {
        throw new CHttpException(404);
    }

    /**
     * Delete list of rows (Action)
     */
    public function actionDeleteRows()
    {
        $return = array('success' => false);

        if (Yii::app()->request->isPostRequest && isset($_POST['rows']) && is_array($_POST['rows'])) {
            $model = $this->_model;

            $albums = array();
            $albumID = array();
            foreach ($_POST['rows'] as $tmp) {
                parse_str($tmp, $pk);
                $id = reset($pk);
                if (is_numeric($id)) {
                    $albumID[] = (int) $id;
                }
            }
            if (! empty($albumID)) {
                $albums = UCmsAlbumPhoto::model()->findAllByAttributes(
                    array('u_cms_album_id' => $albumID), array('select' => 'file_path')
                );
                foreach ($albums as $album) {
                    @unlink(UCmsAlbumPhoto::$upload['file_path']['pathDest'] . '/' . $album->file_path);
                }
            }

            foreach ($_POST['rows'] as $tmp) {
                parse_str($tmp, $pk);
                $model::model()->deleteByPk(count($pk) == 1 ? reset($pk) : $pk);
            }
            unset($model);

            $this->_afterDeleteModels();

            $return['success'] = true;
        }

        echo CJSON::encode($return);
        Yii::app()->end();
    }
}