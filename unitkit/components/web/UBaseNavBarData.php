<?php

/**
 * This class contains data needed to build a navigation bar
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseNavBarData
{

    /**
     * Instance of BBController
     *
     * @var BBController
     */
    protected $_controller;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_controller = Yii::app()->controller;
    }
}