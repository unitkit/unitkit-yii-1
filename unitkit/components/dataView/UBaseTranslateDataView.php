<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseTranslateDataView extends CComponent
{
    /**
     * Data view ID
     *
     * @var string
     */
    public $id;

    /**
     * Primary keys
     *
     * @var mixed
     */
    public $pk;

    /**
     * Array of BItemField
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
     * Saved status
     *
     * @var bool
     */
    public $isSaved;

    /**
     * Model
     *
     * @var CModel
     */
    public $model;

    /**
     * Array of data
     *
     * @var mixed
     */
    public $data;

    /**
     * Page title
     *
     * @var string
     */
    protected $_title;

    /**
     * Form action
     *
     * @var string
     */
    protected $_action;

    /**
     * Close action
     *
     * @var string
     */
    protected $_closeAction;

    /**
     * Controller
     *
     * @var CController
     */
    protected $_controller;

    /**
     * Constructor
     *
     * @param array $data Array of CModels
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {}

    /**
     * Get close action attribute
     *
     * @return string
     */
    public function getCloseAction()
    {
        if ($this->_closeAction === null) {
            $this->_closeAction = $this->controller->createUrl($this->controller->id . '/list');
        }
        return $this->_closeAction;
    }

    /**
     * Set closeAction attribute
     *
     * @param string $action
     */
    public function setCloseAction($action)
    {
        $this->_closeAction = $action;
    }

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

    /**
     * Get action attribute
     *
     * @return string
     */
    public function getAction()
    {
        if ($this->_action === null) {
            $this->_action = $this->controller->createUrl($this->controller->id . '/translate', $this->pk);
        }
        return $this->_action;
    }

    /**
     * Set action attribute
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
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
            $this->title = Unitkit::t('unitkit', 'translate_title');
        return $this->_title;
    }
}