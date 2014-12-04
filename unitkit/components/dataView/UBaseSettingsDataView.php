<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseSettingsDataView extends CComponent
{
    /**
     * Data view ID
     *
     * @var string
     */
    public $id;

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
     * Has errors status
     *
     * @var bool
     */
    public $hasErrors = false;

    /**
     * Array of data
     *
     * @var array
     */
    public $data;

    /**
     * Array of BItemField
     *
     * @var array
     */
    public $items;

    /**
     * Page title
     *
     * @var string
     */
    protected $_title;

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
     * Data view of settings component
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related data
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        // data
        $this->data = $data;

        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($data as $d) {
            if ($this->hasErrors = $d->hasErrors()) {
                break;
            }
        }

            // items
        $this->items = array(
            new UItemField(array(
                'model' => $data['BInterfaceSetting'],
                'attribute' => 'page_size',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => $data['BInterfaceSetting']->getAttributeLabel('page_size'),
                    'id' => false
                )
            ))
        );
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
     * Get close action attribute
     *
     * @return string
     */
    public function getCloseAction()
    {
        if ($this->_closeAction === null) {
            // controller
            $controller = Yii::app()->controller;
            // action
            $this->_closeAction = $controller->createUrl($controller->id . '/list');
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
            // controller
            $controller = Yii::app()->controller;
            // action
            $this->_action = $controller->createUrl($controller->id . '/settings');
        }
        return $this->_action;
    }

    /**
     * Set title attribute
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Get title attribute
     *
     * @return string
     */
    public function getTitle()
    {
        return ($this->_title !== null) ? $this->_title : Unitkit::t('unitkit', 'settings_title');
    }
}