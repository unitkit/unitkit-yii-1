<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseSettingsDataView extends CComponent
{
    /**
     * Data view ID
     *
     * @var string
     */
    public $id;

    /**
     * Related datas
     *
     * @var array
     */
    public $relatedDatas;

    /**
     * Saved satus
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
     * Array of datas
     *
     * @var array
     */
    public $datas;

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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Related datas
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $isSaved)
    {
        // datas
        $this->datas = $datas;

        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach ($datas as $data)
            if ($this->hasErrors = $data->hasErrors())
                break;

            // items
        $this->items = array(
            new BItemField(array(
                'model' => $datas['BInterfaceSetting'],
                'attribute' => 'page_size',
                'type' => 'activeTextField',
                'htmlOptions' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => $datas['BInterfaceSetting']->getAttributeLabel('page_size'),
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
        return ($this->_title !== null) ? $this->_title : B::t('unitkit', 'settings_title');
    }
}