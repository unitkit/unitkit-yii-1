<?php

/**
 * BActiveRecordExportCsv convert an active record to csv file
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BActiveRecordExportCsv
{

    /**
     * List of header's label
     *
     * @var array
     */
    private $_header = array();

    /**
     * List of rows
     *
     * @var array
     */
    protected $_rows = array();

    /**
     * List of models (array of CActiveRecord)
     *
     * @var mixed
     */
    protected $_models = array();

    /**
     * Name of the class model
     *
     * @var string
     */
    protected $_modelClass;

    /**
     * Delimiter used in csv file
     *
     * @var string
     */
    public static $delimiter = ';';

    /**
     * Instantiate a BActiveRecordExportCsv
     *
     * @param string $modelName
     * @param array of model $models
     * @param array of header labels $header
     */
    public function __construct($modelName, $models, $header = array())
    {
        $this->_header = $header;
        $this->_models = $models;
        $this->_modelClass = $modelName::model();
    }

    /**
     * Underscored to lower-camelcase
     * e.g.
     * "this_method_name" -> "thisMethodName"
     *
     * @param unknown_type $string string to transform
     */
    public static function underscoredToLowerCamelcase($string)
    {
        $prefix = strtolower(substr($string, 0, 1));
        $string = ($prefix == 'b') ? $prefix . substr($string, 1) : $string;
        return preg_replace('/_(.?)/e', "strtoupper('$1')", $string);
    }

    /**
     * Camelcase (lower or upper) to underscored
     * e.g.
     * "thisMethodName" -> "this_method_name"
     * e.g. "ThisMethodName" -> "this_method_name"
     *
     * @param string $string String to transform
     * @return string
     */
    public static function camelcaseToUnderscored($string)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $string));
    }

    /**
     * Build the header
     */
    protected function buildHeader()
    {
        if (! empty($this->_header)) {
            foreach ($this->_header as $attribute) {
                $this->_rows[0][] = BTools::utf8Decode($this->_modelClass->getAttributeLabel($attribute));
            }
        } else {
            foreach ($this->_modelClass->attributeLabels() as $attr => $label) {
                $this->_rows[0][] = BTools::utf8Decode($label);
                $this->_header[] = $attr;
            }
        }
    }

    /**
     * Build the content
     */
    protected function buildContent()
    {
        foreach ($this->_models as $index => $model) {
            $i = $index + 1;
            foreach ($this->_header as $attribute) {
                $this->_rows[$i][] = BTools::utf8Decode($this->getAttributeValue($attribute, $index));
            }
        }
    }

    /**
     * Build the array
     */
    protected function build()
    {
        $this->buildHeader();
        if (! empty($this->_models)) {
            $this->buildContent();
        }
    }

    /**
     * Build the csv file
     *
     * @param string $pathFile
     */
    public function save($pathFile)
    {
        $this->build();

        $handle = @fopen($pathFile, 'w');
        if ($handle) {
            foreach ($this->_rows as $row) {
                fputcsv($handle, $row, static::$delimiter);
            }
            fclose($handle);
        }
    }

    /**
     * Download csv file
     */
    public function download()
    {
        $pathFile = tempnam(sys_get_temp_dir(), 'exp');
        $this->save($pathFile);
        Yii::app()->getRequest()->sendFile(basename('export.csv'), file_get_contents($pathFile));
    }

    /**
     * Find the value of the attribute
     *
     * @param string $attribute
     * @param int $index
     * @return string
     */
    protected function getAttributeValue(&$attribute, &$index)
    {

        /**
         * In case of joint
         */
        if (substr($attribute, 0, 3) === 'lk_') {

            $table = null;
            $colName = null;

            /**
             * Find the table name
             */
            foreach($this->_models[$index]->relations() as $relation => $inf) {
                $relationUnder = self::camelcaseToUnderscored($relation);
                if(strpos($attribute, $relationUnder) !== false) {
                    $table = $relation;
                    $parts = explode('lk_'.$relationUnder.'_', $attribute);
                    if(count($parts) == 2) {
                        $colName = $parts[1];
                    }
                }
            }

            $hasMany = $table[strlen($table) - 1] === 's';

            if($table !== null && $colName !== null) {
                if ($hasMany) {
                    $tabJoin = $this->_models[$index]->{$table};
                    return isset($tabJoin[0]) ? $tabJoin[0]->$colName : '';
                } else {
                    return $this->_models[$index]->{$table}->$colName;
                }
            } else {
                return '';
            }
        } else {
            return $this->_models[$index]->$attribute;
        }
    }
}