<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseListDataView extends CComponent
{
    /**
     * @var string Data view ID
     */
    public $id;

    /**
     *
     * @var string Data view title
     */
    protected $_title;

    /**
     * @var mixed Array of BListRowItemDataView
     */
    public $rows;

    /**
     * @var CPagination instance of CPagination
     */
    public $pagination;

    /**
     * @var CSort Instance of CSort
     */
    public $sort;

    /**
     * @var mixed Sort attributes
     */
    public $sortAttributes;

    /**
     * @var mixed Grid search
     */
    public $gridSearch;

    /**
     * @var mixed Advanced search
     */
    public $advancedSearch;

    /**
     * @var mixed Related datas
     */
    public $relatedDatas;

    /**
     * @var mixed Datas
     */
    public $datas;

    /**
     * Controller
     *
     * @var CController
     */
    protected $_controller;

    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$datas, &$relatedDatas, &$model, &$sort, &$pagination)
    {}

    /**
     * Get controller
     *
     * @return CController
     */
    public function getController()
    {
        if ($this->_controller === null) {
            $this->_controller = Yii::app()->controller;
        }
        return $this->_controller;
    }

    /**
     * Set title attribute
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
        $this->controller->pageTitle = $title;
    }

    /**
     * Get title attribute
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->_title === null)
            $this->title = B::t('unitkit', 'translate_title');
        return $this->_title;
    }
}