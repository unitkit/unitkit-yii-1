<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseItemField extends CComponent
{
    /**
     * Model
     *
     * @var CModel
     */
    public $model;

    /**
     * Attribute name
     *
     * @var string
     */
    public $attribute;

    /**
     * Label value
     *
     * @var string
     */
    public $label;

    /**
     * Display attribute
     *
     * @var string
     */
    public $displayAttribute;

    /**
     * Type of field
     *
     * @var string
     */
    public $type;

    /**
     * Field value
     *
     * @var string
     */
    public $value;

    /**
     * Data
     *
     * @var mixed
     */
    public $data;

    /**
     * Html options
     *
     * @var array
     */
    public $htmlOptions;

    /**
     * Constructor
     *
     * @param array $args Arguments
     */
    public function __construct($args)
    {
        if (isset($args['model'])) {
            $this->model = $args['model'];
        }
        if (isset($args['attribute'])) {
            $this->attribute = $args['attribute'];
        }
        if (isset($args['label'])) {
            $this->label = $args['label'];
        }
        if (isset($args['displayAttribute'])) {
            $this->displayAttribute = $args['displayAttribute'];
        }
        if (isset($args['data'])) {
            $this->data = $args['data'];
        }
        if (isset($args['value'])) {
            $this->value = $args['value'];
        }
        if (isset($args['type'])) {
            $this->type = $args['type'];
        }
        if (isset($args['htmlOptions'])) {
            $this->htmlOptions = $args['htmlOptions'];
        }
    }
}