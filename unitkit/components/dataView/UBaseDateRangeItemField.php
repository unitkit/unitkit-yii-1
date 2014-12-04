<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseDateRangeItemField extends CComponent
{

    /**
     * Start date
     *
     * @var UItemField
     */
    protected $_startDate;

    /**
     * End date
     *
     * @var UItemField
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
     * @var UItemField
     */
    protected $_attribute;

    /**
     *
     * @param CModel $model
     * @param string $attribute;
     * @param UItemField $start
     * @param UItemField $end
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
     * @return UItemField
     */
    public function getStart()
    {
        return $this->_startDate;
    }

    /**
     * Get date end item
     *
     * @return UItemField
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
     * @return UItemField|string
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
}
