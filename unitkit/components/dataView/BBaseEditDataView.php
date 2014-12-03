<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseEditDataView extends CComponent
{

    /**
     *
     * @var string Data view ID
     */
    public $id;

    /**
     * Primary keys
     *
     * @var array
     */
    public $pk;

    /**
     * Array of BItemField
     *
     * @var array
     */
    public $items = array();

    /**
     * Related data
     *
     * @var array
     */
    public $relatedData;

    /**
     * Saved status
     *
     * @var bool
     */
    public $isSaved;

    /**
     * New record status
     *
     * @var bool
     */
    public $isNewRecord;

    /**
     * Has errors status
     *
     * @var bool
     */
    public $hasErrors = false;

    /**
     * Model
     *
     * @var CModel
     */
    public $model;

    /**
     * Array of data
     *
     * @var array
     */
    public $data;

    /**
     * Create page title
     *
     * @var string
     */
    protected $_createTitle;

    /**
     * Update page title
     *
     * @var string
     */
    protected $_updateTitle;

    /**
     * Get form action
     *
     * @var string
     */
    protected $_action;

    /**
     * Get close action
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
     * @param array $data Array of CModel
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
     * Get action attribute
     *
     * @return string
     */
    public function getAction()
    {
        if ($this->_action === null) {
            $this->_action = $this->controller->createUrl($this->controller->id . '/' . ($this->isNewRecord ? 'create' : 'update'), $this->pk);
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
     * Set createTitle attribute
     *
     * @param string $title
     */
    public function setCreateTitle($title)
    {
        $this->_createTitle = $title;
    }

    /**
     * Get createTitle attribute
     *
     * @return string
     */
    public function getCreateTitle()
    {
        return ($this->_createTitle !== null) ? $this->_createTitle : B::t('unitkit', 'edit_create_title');
    }

    /**
     * Set updateTitle attribute
     *
     * @param string $title
     */
    public function setUpdateTitle($title)
    {
        $this->_updateTitle = $title;
    }

    /**
     * Get updateTitle attribute
     *
     * @return string
     */
    public function getUpdateTitle()
    {
        return ($this->_updateTitle !== null) ? $this->_updateTitle : B::t('unitkit', 'edit_update_title');
    }

    /**
     * Set page title
     */
    public function refreshPageTitle()
    {
        $this->controller->pageTitle = $this->isNewRecord ? $this->createTitle : $this->updateTitle;
    }
}