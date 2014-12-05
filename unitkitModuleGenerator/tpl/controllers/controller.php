<?php
$html = '<?php

/**
 * Controller
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'Controller extends UAutoController
{
    protected $_model = \'' . $datas['class'] . '\';';

if (! empty($datas['i18nColumns'])) {
    $html .= '
    protected $_modelI18n = \'' . $datas['classI18n'] . '\';
';
}

$html .= '
    /**
     * @see UBaseAutoController::uploader()
     */
    protected function _uploader()
    {
        return array(';

foreach ($datas['columns'] as $k => $c) {
    if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
        $html .= '
            \'' . $datas['class'] . '[' . $c['COLUMN_NAME'] . ']\' => array(
                \'model\' => \'' . $datas['class'] . '\',
                \'field\' => \'' . $c['COLUMN_NAME'] . '\',
                \'uploader\' => Yii::app()->uploader
            ),';
    }
}
$html .= '
        );
    }

    /**
     * @see UBaseAutoController::_advancedComboBox()
     */
    protected function _advancedComboBox()
    {
        return array(';
foreach ($datas['columns'] as $k => $c) {
    if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_SELECT) {
        $relation = $datas['relations'][$k]['BB_REF'];
        $info = explode('.', $relation);
        $model = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);
        $html .= '
            \'' . $model . '[' . $info[1] . ']\' => array(
                \'search\' => $_GET[\'search\'],
                \'model\' => \'' . $model . '\',
                \'select\' => array(
                    \'id\' => \'' . (unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) == $info[0] ? $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] : $datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_' . $datas['relations'][$k]['REFERENCED_COLUMN_NAME']) . '\',
                    \'text\' => \'' . $info[1] . '\'
                ),
                \'criteria\' => array(' . "\n";
        if (unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0]) {
            $html .= '                  \'condition\' => \'i18n_id = :i18nId\',
                    \'params\' => array(\':i18nId\' => $_GET[\'language\']),' . "\n";
        }
        $html .= '                  \'order\' => \'' . $info[1] . ' ASC\',
                    \'limit\' => 10,
                ),
                \'cache\' => isset($_GET[\'cache\']) ? 10 : 0,
            ),';
    }
}
$html .= '
        );
    }';

$htmlRelated = '';
foreach($datas['columns'] as $k => $c)
{
    if(isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_SELECT)
    {
        $relation = $datas['relations'][$k]['BB_REF'];
        $info = explode('.', $relation);
        $model = unitkitGenerator::underscoredToUpperCamelcase( ($info[0][strlen($info[0])-1] == 's') ? substr($info[0], 0, -1) : $info[0]);
        $htmlRelated .= '        $relatedDatas[\''.$model.'['.$info[1].']\'] = array(\'\' => Unitkit::t(\'unitkit\', \'input_select\')) +
            UHtml::listDatasCombobox(\''.$model.'\', array(\''.(unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) == $info[0] ? $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] : $datas['relations'][$k]['REFERENCED_TABLE_NAME'].'_'.$datas['relations'][$k]['REFERENCED_COLUMN_NAME']).'\', \''.$info[1].'\')';
        if( unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0] )
        {
            $htmlRelated .= ', array(
            	\'condition\' => \'i18n_id = :i18nId\', \'params\' => array(\':i18nId\' => Yii::app()->language)
            )';
        }
        $htmlRelated .= ');'."\n";
    }
}

if($htmlRelated != '')
{
$html .= '

    /**
     * @see BBaseAutoController::_loadRelatedData()
     */
    protected function _loadRelatedData()
    {
        $relatedData = array();
'.$htmlRelated.'
        return $relatedData;
    }';
}

$html .= '
}';
return $html;