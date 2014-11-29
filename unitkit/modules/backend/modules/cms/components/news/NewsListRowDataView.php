<?php

/**
 * Data view of list row item
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewsListRowDataView extends BListRowItemDataView
{
    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {
        $this->isTranslatable = true;
        $this->pk = $pk;
        $this->items = array(
            isset($data->bCmsNewsGroupI18ns[0]) ? $data->bCmsNewsGroupI18ns[0]->name : '',
            isset($data->bCmsNewsI18ns[0]) ? $data->bCmsNewsI18ns[0]->title : '',
            BHtml::activeCheckBox($data, 'activated', array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => false
            )),
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                $data->published_at, 'yyyy-MM-dd hh:mm:ss'
            )),
        );
    }
}