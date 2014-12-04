<?php

/**
 * Controller of site
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteController extends UController
{
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
}