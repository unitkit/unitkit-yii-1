<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseEditRowItemDataView extends CComponent
{
    /**
     * Primary key
     *
     * @var mixed
     */
    public $pk;

    /**
     * Items
     *
     * @var mixed
     */
    public $items;

    /**
     * Related datas
     *
     * @var mixed
     */
    public $relatedDatas;

    /**
     * Datas
     *
     * @var mixed
     */
    public $datas;

    /**
     * Is translatable
     *
     * @var boolean
     */
    public $isTranslatable;

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
     * @param array $pk Primary key
     */
    public function __construct($datas, $relatedDatas, $pk)
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
        return $this->_controller = Yii::app()->controller;
    }
}