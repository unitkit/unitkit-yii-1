<?php
$html = '<?php

/**
 * Data view of list row item
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'ListRowDataView extends UListRowItemDataView
{
    /**
     * Constructor
     *
     * @param CModel $data
     * @param array $pk
     */
    public function __construct($data, $pk)
    {';
if (! empty($datas['i18nColumns'])) {
    $html .= '
        $this->isTranslatable = true;';
}
$html .= '
        $this->pk = $pk;
        $this->items = array(';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && ! in_array($v['BB_TYPE'], array(
        unitkitGenerator::TYPE_PRIMARY_AUTO,
        unitkitGenerator::TYPE_DATE_AUTO
    ))) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);

        $columnName = $v['COLUMN_NAME'];
        if (isset($datas['relations'][$k]['BB_REF']) && isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            if ($info[1] != $datas['relations'][$k]['REFERENCED_COLUMN_NAME']) {
                $columnName = $info[0] . '_' . $info[1];
            }
        } elseif ($v['TABLE_NAME'] == $datas['table_i18n']) {
            $columnName = $v['TABLE_NAME'] . '_' . $v['COLUMN_NAME'];
        }

        if ($v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_INPUT) {
            $html .= '
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                $data->' . $v['COLUMN_NAME'] . ', \'yyyy-MM-dd hh:mm:ss\'
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '
            UHtml::activeCheckBox($data, \'' . $v['COLUMN_NAME'] . '\', array(
                \'class\' => \'form-control input-sm\',
                \'disabled\' => \'disabled\',
                \'id\' => false
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '
            $this->controller->getUploader(\'' . $class . '[' . $v['COLUMN_NAME'] . ']\')[\'uploader\']->htmlOverview(
                $data,
                \'' . $v['COLUMN_NAME'] . '\',
                array(
                    \'type\' => BUploader::OVERVIEW_IMAGE,
                    \'html_options\' => array(\'style\' => \'max-width:350px\')
                )
            ),';
        } else {
            $extra = '$data->' . $v['COLUMN_NAME'] . ',';
            if (isset($datas['relations'][$k]['BB_REF'])) {
                $info = explode('.', $datas['relations'][$k]['BB_REF']);
                if ($info[1] != $datas['relations'][$k]['REFERENCED_COLUMN_NAME']) {
                    $i18nTableR = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_i18ns');
                    $isI18nTable = ($i18nTableR == $info[0]);
                    if ($isI18nTable)
                        $extra = 'isset($data->' . $i18nTableR . '[0]) ? $data->' . $i18nTableR . '[0]->' . $info[1] . ' : \'\',';
                    else
                        $extra = '$data->' . unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) . '->' . $info[1] . ',';
                }
            } elseif ($v['TABLE_NAME'] == $datas['table_i18n']) {
                $extra = 'isset($data->' . unitkitGenerator::underscoredToLowerCamelcase($v['TABLE_NAME']) . 's[0]) ? $data->' . unitkitGenerator::underscoredToLowerCamelcase($v['TABLE_NAME']) . 's[0]->' . $v['COLUMN_NAME'] . ' : \'\',';
            }
            $html .= '
            ' . $extra;
        }
    }
}

$htmlDateAuto = '';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);

        $htmlDateAuto .= '
            Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                $data->' . $v['COLUMN_NAME'] . ', \'yyyy-MM-dd hh:mm:ss\'
            )),';
    }
}

$html .= $htmlDateAuto . '
        );
    }
}';

return $html;