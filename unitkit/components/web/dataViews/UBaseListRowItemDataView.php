<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseListRowItemDataView extends CComponent
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
     * Data
     *
     * @var mixed
     */
    public $data;

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
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
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
}