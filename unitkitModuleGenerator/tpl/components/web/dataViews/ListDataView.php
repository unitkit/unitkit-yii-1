<?php
$html = '<?php

/**
 * Data view of list interface
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'ListDataView extends UListDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Array of related data
     * @param CModel $model Current model
     * @param CSort $sort CSort component
     * @param CPagination $pagination CPagination component
     */
    public function __construct(&$data, &$relatedData, &$model, &$sort, &$pagination)
    {
        // id
        $this->id = \'' . lcfirst($datas['class']) . $datas['controller'] . 'Main\';

        // component title
        $this->title = Unitkit::t(\'unitkit\', \'list_title\');

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // sort
        $this->sort = $sort;

        // sort attributes
        $this->sortAttributes = array(' . "\n";

foreach ($datas['allColumns'] as $k => $v) {
    $columnName = $v['COLUMN_NAME'];
    $class = $v['TABLE_NAME'];
    if (isset($datas['relations'][$k]['BB_REF'])) {
        $info = explode('.', $datas['relations'][$k]['BB_REF']);
        $columnName = $info[1];
        $class = $info[0];
    } elseif ($v['TABLE_NAME'] == $datas['table_i18n']) {
        $class = $class . 's';
    }

    $class = unitkitGenerator::underscoredToLowerCamelcase($class);
    if (isset($v['BB_TYPE']) && ! in_array($v['BB_TYPE'], array(
        unitkitGenerator::TYPE_PRIMARY_AUTO,
        unitkitGenerator::TYPE_DATE_AUTO
    ))) {
        $html .= '            \'' . $class . '.' . $columnName . '\',' . "\n";
    }
}
foreach ($datas['allColumns'] as $k => $v) {
    $columnName = $v['COLUMN_NAME'];
    $class = $v['TABLE_NAME'];
    if (isset($datas['relations'][$k]['BB_REF'])) {
        $info = explode('.', $datas['relations'][$k]['BB_REF']);
        $columnName = $info[1];
        $class = $info[0];
    }
    $class = unitkitGenerator::underscoredToLowerCamelcase($class);
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $html .= '            \'' . $class . '.' . $columnName . '\',' . "\n";
    }
}

$html .= '        );

        // controller
        $controller = Yii::app()->controller;

        // search
        $this->gridSearch = array(';

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
                $columnName = 'lk_' . $info[0] . '_' . $info[1];
            }
        } elseif ($v['TABLE_NAME'] == $datas['table_i18n']) {
            $columnName = 'lk_' . $v['TABLE_NAME'] . 's_' . $v['COLUMN_NAME'];
        }

        if ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'data\' => array(
                    \'\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_all\'),
                    \'1\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_checked\'),
                    \'0\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_unchecked\'),
                ),
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeDropDownList\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_INPUT) {
            $html .= '
            new UDateRangeItemField(
                $model,
                \'' . $columnName . '\',
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_start\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_start_gridSearch') . '\'
                    )
                )),
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_end\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_end_gridSearch') . '\'
                    )
                ))
            ),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXTAREA || $v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_i18ns') == $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);

            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'data\' => $relatedData[\'' . $classR . '[' . $info[1] . ']\'],
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeDropDownList\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);

            $dataText = $classR . '::model()->findByPk(' . ($isI18nTable ? 'array(
                                \'' . $datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_' . $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] . '\' => $model->' . $columnName . ',
                                \'i18n_id\' => Yii::app()->language
                            )' : '$model->' . $columnName . '') . ')->' . $info[1];

            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeHiddenField\',
                \'htmlOptions\' => array(
                	\'class\' => \'input-ajax-select allow-clear\',
                	\'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($classR . '_' . $info[1] . '_gridSearch') . '\',
                	\'data-action\' => $controller->createUrl(
                        $controller->id.\'/advComboBox/\',
                        array(
                            \'name\' => \'' . $classR . '[' . $info[1] . ']\',' . ($isI18nTable ? "\n" . '            				\'language\' => Yii::app()->language' : '') . '
                        )
                	),
                	\'data-placeholder\' => Unitkit::t(\'unitkit\', \'input_select\'),
                	\'data-text\' =>
                        ! empty($model->' . $columnName . ')
                        ?
                        	' . $dataText . '
                        :
                        	\'\'
                )
            )),';
        }
    }
}

$htmlDateAuto = '';
foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);
        $columnName = $v['COLUMN_NAME'];

        $htmlDateAuto .= '
            new UDateRangeItemField(
                $model,
                \'' . $columnName . '\',
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_start\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_start_gridSearch') . '\'
                    )
                )),
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_end\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_end_gridSearch') . '\'
                    )
                ))
            ),';
    }
}
$html .= $htmlDateAuto . '
        );

        // advanced search
        $this->advancedSearch = array(';

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
                $columnName = 'lk_' . $info[0] . '_' . $info[1];
            }
        } elseif ($v['TABLE_NAME'] == $datas['table_i18n']) {
            $columnName = 'lk_' . $v['TABLE_NAME'] . 's_' . $v['COLUMN_NAME'];
        }

        if ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'data\' => array(
                    \'\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_all\'),
                    \'1\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_checked\'),
                    \'0\' => Unitkit::t(\'unitkit\', \'input_drop_down_list_unchecked\'),
                ),
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeDropDownList\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_INPUT) {
            $html .= '
        	new UDateRangeItemField(
                $model,
                \'' . $columnName . '\',
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_start\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_start_advSearch') . '\'
                    )
                )),
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_end\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_end_advSearch') . '\'
                    )
                ))
			),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXTAREA || $v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA) {
            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_i18ns') == $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);

            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'data\' => $relatedData[\'' . $classR . '[' . $info[1] . ']\'],
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeDropDownList\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'id\' => false
                )
            )),';
        } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_SELECT && isset($datas['relations'][$k]['BB_REF'])) {
            $info = explode('.', $datas['relations'][$k]['BB_REF']);
            $isI18nTable = unitkitGenerator::underscoredToLowerCamelcase($datas['relations'][$k]['REFERENCED_TABLE_NAME']) != $info[0];
            $classR = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);

            $dataText = $classR . '::model()->findByPk(' . ($isI18nTable ? 'array(
                				\'' . $datas['relations'][$k]['REFERENCED_TABLE_NAME'] . '_' . $datas['relations'][$k]['REFERENCED_COLUMN_NAME'] . '\' => $model->' . $columnName . ',
                				\'i18n_id\' => Yii::app()->language
                			)' : '$model->' . $columnName . '') . ')->' . $info[1];

            $html .= '
            new UItemField(array(
                \'model\' => $model,
                \'attribute\' => \'' . $columnName . '\',
                \'type\' => \'activeHiddenField\',
                \'htmlOptions\' => array(
                    \'class\' => \'input-ajax-select allow-clear\',
                    \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($classR . '_' . $info[1] . '_advSearch') . '\',
                    \'data-action\' => $controller->createUrl(
                        $controller->id.\'/advComboBox/\',
                        array(
                            \'name\' => \'' . $classR . '[' . $info[1] . ']\',' . ($isI18nTable ? "\n" . '            				\'language\' => Yii::app()->language' : '') . '
                        )
                    ),
                    \'data-placeholder\' => Unitkit::t(\'unitkit\', \'input_select\'),
                    \'data-text\' =>
                        ! empty($model->' . $columnName . ')
                        ?
                            ' . $dataText . '
                        :
                            \'\'
                )
            )),';
        }
    }
}

foreach ($datas['allColumns'] as $k => $v) {
    if (isset($v['BB_TYPE']) && $v['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
        $class = unitkitGenerator::underscoredToUpperCamelcase($v['TABLE_NAME']);
        $columnName = $v['COLUMN_NAME'];

        $html .= '
        	new UDateRangeItemField(
                $model,
                \'' . $columnName . '\',
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_start\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_start_advSearch') . '\'
                    )
                )),
                new UItemField(array(
                    \'model\' => $model,
                    \'attribute\' => \'v_' . $columnName . '_end\',
                    \'type\' => \'activeTextField\',
                    \'htmlOptions\' => array(
                        \'class\' => \'form-control input-sm date-picker date-range\',
                        \'placeholder\' => Unitkit::t(\'unitkit\', \'input_search\'),
                        \'id\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($class . '_v_' . $columnName . '_end_advSearch') . '\'
                    )
                ))
            ),';
    }
}
$html .= '
        );';

$sLinkArrayPK = 'array(';
foreach ($datas['pk'] as $pk)
    $sLinkArrayPK .= '\'' . $pk . '\' => $d->' . $pk . ',';
$sLinkArrayPK .= ')';

$html .= '

        // rows
        foreach($data as $d) {
            $this->rows[] = new ' . $datas['controller'] . 'ListRowDataView($d, ' . $sLinkArrayPK . ');
        }

        // pagination
        $this->pagination = $pagination;
    }
}';
return $html;