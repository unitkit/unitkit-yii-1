<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class ContactController extends BController
{
    /**
     * @see CController::filters()
     */
    public function filters()
    {
        return array(
            'cmsPage',
        );
    }

    /**
     * Display form
     */
    public function actionIndex()
    {
        $models['ContactForm'] = new ContactForm();
        $isSent = false;
        if (Yii::app()->request->isPostRequest && isset($_POST['ContactForm'])) {
            $models['ContactForm']->attributes = $_POST['ContactForm'];
            if ($models['ContactForm']->validate()) {
                $isSent = $models['ContactForm']->sendEmail();
            }
        }

        $this->dynamicRender($this->cmsView, array('models' => $models, 'isSent' => $isSent));
    }
}
