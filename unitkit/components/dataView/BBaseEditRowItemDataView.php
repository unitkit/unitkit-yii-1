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
     * Related data
     *
     * @var mixed
     */
    public $relatedData;

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
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
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