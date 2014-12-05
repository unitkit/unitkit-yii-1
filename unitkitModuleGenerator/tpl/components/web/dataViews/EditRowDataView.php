<?php
$html = '<?php

/**
 * Data view of edit inline interface
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'EditRowDataView extends UEditRowItemDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     */
    public function __construct($data, $relatedData, $pk)
    {
        // primary key
        $this->pk = $pk;

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // items
        $this->items = array(';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && ! in_array($v['BB_TYPE'], array(
        unitkitGenerator::TYPE_PRIMARY_AUTO,
        unitkitGenerator::TYPE_DATE_AUTO
    ))) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);

        if ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => $data[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'value\' => $this->controller->getUploader(\'' . $class . '[' . $v['COLUMN_NAME'] . ']\')[\'uploader\']->htmlUploader(
                    $data[\'' . $class . '\'],
                    \'' . $v['COLUMN_NAME'] . '\',
                    $this->controller->createUrl($this->controller->id.\'/upload\'),
                    array(
                        \'type\' => BUploader::OVERVIEW_IMAGE,
                        \'route\' => $this->controller->id.\'/upload\',
                        \'html_options\' => array(\'style\' => \'max-width:350px\'),
                    )
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_' . $v['COLUMN_NAME'] . '_edit') . '\',
                    \'class\' => \'form-control input-sm jui-datePicker\',
                    \'placeholder\' => $data[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeCheckBox\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => $data[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXTAREA || $v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA) {
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextArea\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm' . ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA ? ' advanced-textarea' : '') . '\',
                    \'placeholder\' => $data[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);
            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeDropDownList\',
                \'data\' => $relatedData[\'' . $classR . '[' . $info[1] . ']\'],
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm' . ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA ? ' advanced-textarea' : '') . '\',
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);

            $dataText = $classR . '::model()->findByPk(' . ($isI18nTable ? 'array(
                                    \'' . $datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_' . $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] . '\' => $data[\'' . $class . '\']->' . $v['COLUMN_NAME'] . ',
                                    \'i18n_id\' => Yii::app()->language
                                )' : '$data[\'' . $class . '\']->' . $v['COLUMN_NAME'] . '') . ')->' . $info[1];

            $html .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeHiddenField\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm input-ajax-select' . ($v['IS_NULLABLE'] == 'YES' ? ' allow-clear' : '') . '\',
                    \'data-action\' => $this->controller->createUrl(
                        $this->controller->id.\'/advComboBox/\',
                        array(\'name\' => \'' . $classR . '[' . $info[1] . ']\'' . ($isI18nTable ? ', \'language\' => Yii::app()->language' : '') . ')
                    ),
                    \'data-placeholder\' => Unitkit::t(\'unitkit\', \'input_select\'),
                    \'data-text\' => ! empty($data[\'' . $class . '\']->' . $v['COLUMN_NAME'] . ') ? ' . $dataText . ' : \'\',
                )
            )),';
        }
    }
}
$htmlDateAuto = '';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);

        $htmlDateAuto .= '
            new UItemField(array(
                \'model\' => $data[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'value\' => Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(
                    $data[\'' . $class . '\']->' . $v['COLUMN_NAME'] . ', \'yyyy-MM-dd hh:mm:ss\'
                ))
            )),';
    }
}

$html .= $htmlDateAuto;
$html .= '
        );
    }
}';

return $html;