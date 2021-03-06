<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsController extends UController
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

    public function actionIndex()
    {
        // get model
        $model = new UCmsNews('search');
        $model->unsetAttributes();

        // set filter
        if (isset($_GET['UCmsNews'])) {
            $model->attributes = $_GET['UCmsNews'];
        }
        $model->u_cms_news_group_id = Unitkit::v('frontend', 'u_cms_news_group_id:main');

        // search
        $dataProvider = $model->search(Yii::app()->language);

        // pagination parameters
        $pagination = $dataProvider->getPagination();
        $pagination->route = $this->id.'/index';
        $pagination->pageSize = 10;
        $pagination->itemCount = $dataProvider->totalItemCount;

        // data
        $data = $dataProvider->getData();

        $this->dynamicRender($this->cmsView, array('data' => $data, 'pagination' => $pagination));
    }
}
