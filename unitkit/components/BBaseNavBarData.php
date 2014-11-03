<?php

/**
 * This class contains datas needed to build a navigation bar
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseNavBarData
{

    /**
     * Instance of BBControler
     *
     * @var BBControler
     */
    protected $_controller;

    /**
     * Constructor
     *
     * @param BController $controller
     */
    public function __construct()
    {
        $this->_controller = Yii::app()->controller;
    }
}