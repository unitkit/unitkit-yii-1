<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class CmsController extends UController
{
    /**
     * @see CController::filters()
     */
    public function filters()
    {
        return array(
            'accessControl',
            'cmsPage',
        );
    }

    public function actionIndex()
    {
        $this->dynamicRender($this->cmsView, array());
    }
}