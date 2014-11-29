<?php
$html = '<?php

/**
 * Data view of edit interface
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'EditDataView extends BEditDataView
{
    /**
     * Constructor
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Array of related datas
     * @param array $pk Primary key
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $pk, $isSaved)
    {
        // data view id
        $this->id = \'' . lcfirst($datas['class']) . $datas['controller'] . 'Edit\';

        // component title
        $this->createTitle = B::t(\'unitkit\', \'create_title\');
        $this->updateTitle = B::t(\'unitkit\', \'update_title\');

        // primary key
        $this->pk = $pk;

        // datas
        $this->datas = $datas;

        // related datas
        $this->relatedDatas = $relatedDatas;

        // saved status
        $this->isSaved = $isSaved;

        // error status
        foreach($datas as $data)
        	if($this->hasErrors = $data->hasErrors())
        		break;

        // new record status
        $this->isNewRecord = $datas[\'' . $datas['class'] . '\']->isNewRecord;

        // page title
        $this->refreshPageTitle();

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
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => $datas[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'value\' => Yii::app()->uploader->htmlUploader(
                    $datas[\'' . $class . '\'],
                    \'' . $v['COLUMN_NAME'] . '\',
                    $this->controller->getUploader(\'' . $class . '[' . $v['COLUMN_NAME'] . ']\')[\'uploader\']->createUrl($this->controller->id.\'/upload\'),
                    array(
                        \'type\' => BUploader::OVERVIEW_IMAGE,
                        \'route\' => $this->controller->id.\'/upload\',
                        \'html_options\' => array(\'style\' => \'max-width:350px\'),
                    )
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_INPUT) {
            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_' . $v['COLUMN_NAME'] . '_edit') . '\',
                    \'class\' => \'form-control input-sm jui-datePicker\',
                    \'placeholder\' => $datas[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeCheckBox\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => $datas[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXTAREA || $v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA) {
            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextArea\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm' . ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA ? ' advanced-textarea' : '') . '\',
                    \'placeholder\' => $datas[\'' . $class . '\']->getAttributeLabel(\'' . $v['COLUMN_NAME'] . '\'),
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);
            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeDropDownList\',
                \'datas\' => $relatedDatas[\'' . $classR . '[' . $info[1] . ']\'],
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
                                    \'' . $datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_' . $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] . '\' => $datas[\'' . $class . '\']->' . $v['COLUMN_NAME'] . ',
                                    \'i18n_id\' => Yii::app()->language
                                )' : '$datas[\'' . $class . '\']->' . $v['COLUMN_NAME'] . '') . ')->' . $info[1];

            $html .= '
            new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeHiddenField\',
                \'htmlOptions\' => array(
                    \'id\' => false,
                    \'class\' => \'form-control input-sm input-ajax-select' . ($v['IS_NULLABLE'] == 'YES' ? ' allow-clear' : '') . '\',
                    \'data-action\' => $this->controller->createUrl(
                        $this->controller->id.\'/advCombobox/\',
                        array(\'name\' => \'' . $classR . '[' . $info[1] . ']\'' . ($isI18nTable ? ', \'language\' => Yii::app()->language' : '') . ')
                    ),
                    \'data-placeholder\' => B::t(\'unitkit\', \'input_select\'),
                    \'data-text\' => ! empty($datas[\'' . $class . '\']->' . $v['COLUMN_NAME'] . ') ? ' . $dataText . ' : \'\',
                )
            )),';
        }
    }
}
$html .= '
        );';

$htmlDateAuto = '';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);

        $htmlDateAuto .= '
            $this->items[] = new BItemField(array(
                \'model\' => $datas[\'' . $class . '\'],
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'value\' =>  $datas[\'' . $class . '\']->' . $v['COLUMN_NAME'] . '
            ));';
    }
}

if ($htmlDateAuto) {
    $html .= '

        if (! $datas[\'' . $class . '\']->isNewRecord) {' . $htmlDateAuto . '
        }';
}
$html .= '
    }
}';

return $html;