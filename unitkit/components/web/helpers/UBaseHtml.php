<?php

/**
 * @see CHttpRequest
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseHtml extends CHtml
{
    /**
     * Slugify a string
     *
     * @param $text Text to slugify
     * @return string
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


    /**
     * Get i18n label from id
     *
     * @param string $id I18n ID
     * @param bool $flag Display flag
     * @param bool $text Display text
     * @return string HTML
     */
    public static function labelI18n($id, $flag = true, $text = true)
    {
        return '<span class="label-i18n">'.($flag ? '<img src="' . Yii::app()->baseUrl . '/unitkit/images/i18n/' . $id . '.png" alt="" /> ' : '') .($text ? UI18n::labelI18n($id) : ''). '</span>';
    }

    /**
     * Reduce a string
     *
     * @param string $string string to be transform
     * @param int $length number of maximum displayed characters
     * @return string
     */
    public static function textReduce($string, $length)
    {
        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
        return (strlen($string) > $length) ? htmlentities(mb_substr($string, 0, $length, 'UTF-8'), ENT_COMPAT, 'UTF-8') . '...' : $string;
    }

    /**
     * List data of advanced combobox
     *
     * @param string $modelName name of model
     * @param mixed $select array(text => , id =>, compare => true)
     * @param string $search search value
     * @param mixed $criteria array of criteria
     * @param int $cache cache duration (in seconds)
     * @return mixed
     */
    public static function listDataAdvCombobox($modelName, $select, $search, $criteria = array(), $cache = 0)
    {
        $model = new $modelName();
        $dbCriteria = $model->getDbCriteria();
        if (! isset($select['compare']) || $select['compare'] === true)
            $dbCriteria->compare($select['text'], $search, true);

        $tmp = $model->cache($cache/* cache duration */)->findAll(array_merge(array(
            'select' => $select['text'] . ', ' . $select['id']
        ), $criteria));

        $data = array();
        foreach ($tmp as $d)
            $data[] = array(
                'text' => $d->$select['text'],
                'id' => $d->$select['id']
            );

        return $data;
    }

    /**
     * List data of comboBox
     *
     * @param string $modelName name of model
     * @param mixed $select array(0 => id, 1 => text)
     * @param mixed $criteria array of criteria
     * @param int $cache cache duration (in seconds)
     * @return array
     */
    public static function listDataComboBox($modelName, $select, $criteria = array(), $cache = 0)
    {
        // init model
        $model = new $modelName();
        // get all data
        $data = $model->cache($cache/* cache duration */)->findAll(array_merge(array(
            'select' => implode(',', $select)
        ), $criteria));

        $result = array();
        foreach (CHtml::listData($data, $select[0], $select[1]) as $k => $v) {
            $result[$k] = $v;
        }

        return $result;
    }

    /**
     * Generates a text area input for a model attribute.
     * If the attribute has input error, the input field's CSS class will
     * be appended with {@link errorCss}.
     *
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
     *        attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
     * @return string the generated text area
     * @see clientChange
     */
    public static function activeTextArea($model, $attribute, $htmlOptions = array())
    {
        if (! isset($htmlOptions['maxlength'])) {
            foreach ($model->getValidators($attribute) as $validator) {
                if ($validator instanceof CStringValidator && $validator->max !== null) {
                    $htmlOptions['maxlength'] = $validator->max;
                    break;
                }
            }
        } elseif ($htmlOptions['maxlength'] === false)
            unset($htmlOptions['maxlength']);

        self::resolveNameID($model, $attribute, $htmlOptions);
        self::clientChange('change', $htmlOptions);
        if ($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        if (isset($htmlOptions['value'])) {
            $text = $htmlOptions['value'];
            unset($htmlOptions['value']);
        } else {
            $text = self::resolveValue($model, $attribute);
        }

        return self::tag('textarea', $htmlOptions, isset($htmlOptions['encode']) && ! $htmlOptions['encode'] ? $text : self::encode($text));
    }

    /**
     * Displays a summary of validation errors for one or several models.
     *
     * @param mixed $model the models whose input errors are to be displayed. This can be either
     *        a single model or an array of models.
     * @param string $header a piece of HTML code that appears in front of the errors
     * @param string $footer a piece of HTML code that appears at the end of the errors
     * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
     *        A special option named 'firstError' is recognized, which when set true, will
     *        make the error summary to show only the first error message of each attribute.
     *        If this is not set or is false, all error messages will be displayed.
     *        This option has been available since version 1.1.3.
     * @return string the error summary. Empty if no errors are found.
     * @see CModel::getErrors
     * @see errorSummaryCss
     */
    public static function errorSummary($model, $header = null, $footer = null, $htmlOptions = array())
    {
        if ($header == null) {
            $header = '<h4>' . Yii::t('yii', 'Please fix the following input errors:') . '</h4>';
        }

        $modelClean = $model;

        // clean model
        if (is_array($modelClean)) {
            foreach($modelClean as $k => $m) {
                if( is_array($m)) {
                    unset($modelClean[$k]);
                }
            }
        }

        return parent::errorSummary($modelClean, $header, $footer, $htmlOptions);
    }

    /**
     * Generates a hyperlink that can be clicked to cause sorting.
     *
     * @param CSort $sort the current CSort instance
     * @param string $attribute the attribute name
     * @param string $label the attribute label
     * @return string
     */
    public static function createBSortLink(CSort $sort, $attribute, $label = null)
    {
        $class['link'] = '';
        $class['icon'] = 'glyphicon-sort-by-alphabet';

        $directions = $sort->getDirections();
        if (isset($directions[$attribute])) {
            $class['link'] = 'current-sort';
            if ($directions[$attribute])
                $class['icon'] = 'glyphicon-sort-by-alphabet-alt';
            $directions[$attribute] = ! $directions[$attribute];
        } else
            $directions[$attribute] = false;

        if ($label === null)
            $label = $sort->resolveLabel($attribute);

        return '<a class="' . $class['link'] . '" href="' . $sort->createUrl(Yii::app()->getController(), array(
            $attribute => $directions[$attribute]
        )) . '">
			<span class="glyphicon ' . $class['icon'] . '"></span>
			' . $label . '
		</a>';
    }
}