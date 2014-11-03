<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseDateRangeItemField extends CComponent
{

    /**
     * Start date
     *
     * @var BItemField
     */
    protected $_startDate;

    /**
     * End date
     *
     * @var BItemField
     */
    protected $_endDate;

    /**
     * Model
     *
     * @var CModel
     */
    protected $_model;

    /**
     * Attribute
     *
     * @var BItemField
     */
    protected $_attribute;

    /**
     *
     * @param CModel $model
     * @param string $attribute;
     * @param BItemField $start
     * @param BItemField $end
     */
    public function __construct($model, $attribute, $start, $end)
    {
        $this->_model = $model;
        $this->_attribute = $attribute;
        $this->_startDate = $start;
        $this->_endDate = $end;
    }

    /**
     * Get date start item
     *
     * @return BItemField
     */
    public function getStart()
    {
        return $this->_startDate;
    }

    /**
     * Get date end item
     *
     * @return BItemField
     */
    public function getEnd()
    {
        return $this->_endDate;
    }

    /**
     * Get Model
     *
     * @return CModel
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Get Attribute
     *
     * @return BItemField|string
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
}
