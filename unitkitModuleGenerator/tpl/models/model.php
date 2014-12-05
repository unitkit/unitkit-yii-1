<?php
$html = '<?php

/**
 * This is the model class for table "' . $datas['table'] . '"
 *
 * @version 1.0
 */
class ' . $datas['class'] . ' extends CActiveRecord
{';

// upload file
$htmlUpl = '';
foreach ($datas['columns'] as $k => $c) {
    if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
        $htmlUpl .= '		\'' . $c['COLUMN_NAME'] . '\' => array(
            \'types\' => array(\'jpg\', \'jpeg\', \'gif\', \'png\'),
            \'max\' => 10485760, // 10MB = 1024x1024x10
        	\'pathDest\' => \'\',
			\'urlDest\' => \'\',
        ),' . "\n";
    }
}
if ($htmlUpl != '') {
    $html .= '
    /**
     * Upload attribute
     *
     * @var array
     */
    public static $upload = array(
' . $htmlUpl . '    );

    /**
     * Array of operations used from uploader component
     *
     * @var array
     */
    public $uploadOperations;
';
}

// search sort
$htmlSS = '';
foreach ($datas['i18nColumns'] as $c) {
    $htmlSS .= '	public $lk_' . $c['TABLE_NAME'] . 's_' . $c['COLUMN_NAME'] . ';' . "\n";
}
foreach ($datas['relations'] as $k => $c) {
    if (isset($c['BB_REF']) && isset($datas['columns'][$k]['BB_TYPE']) && $datas['columns'][$k]['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
        $info = explode('.', $c['BB_REF']);
        if ($info[1] != $c['REFERENCED_COLUMN_NAME']) {
            $info[0] = unitkitGenerator::camelcaseToUnderscored($info[0]);
            /* if($info[0][strlen($info[0])-1] == 's') $info[0] = substr($info[0], 0, -1); */
            $htmlSS .= '	public $lk_' . $info[0] . '_' . $info[1] . ';' . "\n";
        }
    }
}
if ($htmlSS != '') {
    $html .= '
    // related attributes
' . $htmlSS;
}

$htmlSS = '';
foreach ($datas['columns'] as $c) {
    if (isset($c['BB_TYPE']) && in_array($c['BB_TYPE'], array(
        unitkitGenerator::TYPE_DATE_AUTO,
        unitkitGenerator::TYPE_DATE_INPUT
    ))) {
        $htmlSS .= '	public $v_' . $c['COLUMN_NAME'] . '_start;' . "\n";
        $htmlSS .= '	public $v_' . $c['COLUMN_NAME'] . '_end;' . "\n";
    }
}

if ($htmlSS != '') {
    $html .= '
    // virtual attributes
' . $htmlSS;
}

$html .= '
    /**
     * @see CActiveRecord::scopes()
     */
    public function scopes()
    {
        return array();
    }

    /**
     * @see CActiveRecord::model()
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return \'' . $datas['table'] . '\';
    }

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            //save' . "\n";

$rules['required'] = '';
$rules['requiredExcludePri'] = '';
foreach ($datas['columns'] as $c) {
    if ($c['EXTRA'] != 'auto_increment' && $c['IS_NULLABLE'] == 'NO')
        $rules['required'] .= $c['COLUMN_NAME'] . ', ';
    if ($datas['isTableI18n'] && $c['COLUMN_KEY'] != 'PRI')
        $rules['requiredExcludePri'] .= $c['COLUMN_NAME'] . ', ';
}
$rules['required'] = substr($rules['required'], 0, - 2);
if ($datas['isTableI18n'])
    $rules['requiredExcludePri'] = substr($rules['requiredExcludePri'], 0, - 2);

$html .= '            array(\'' . $rules['required'] . '\', \'required\', \'on\' => array(\'insert\', \'update\')),' . "\n";
if ($datas['isTableI18n'])
    $html .= '			array(\'' . $rules['requiredExcludePri'] . '\', \'required\', \'on\' => \'preInsert\'),' . "\n";

foreach ($datas['columns'] as $c) {
    if ($c['COLUMN_KEY'] == 'PRI')
        $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'unsafe\', \'on\' => array(\'insert\', \'update\')),' . "\n";
    if ($c['CHARACTER_MAXIMUM_LENGTH'] !== null)
        $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'length\', \'max\' => ' . $c['CHARACTER_MAXIMUM_LENGTH'] . '),' . "\n";
    if ($c['DATA_TYPE'] == 'int' || $c['DATA_TYPE'] == 'bigint')
        $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'type\', \'type\' => \'integer\'),' . "\n";
    if ($c['DATA_TYPE'] == 'varchar' || $c['DATA_TYPE'] == 'text' || $c['DATA_TYPE'] == 'mediumtext' || $c['DATA_TYPE'] == 'longtext') {
        if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE)
            $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'type\', \'type\' => \'string\', \'on\' => array(\'insert\', \'update\', \'search\')),' . "\n";
        else
            $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'type\', \'type\' => \'string\'),' . "\n";
    }
    if (isset($c['BB_TYPE'])) {
        if ($c['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO) {
            if ($c['COLUMN_NAME'] == 'updated_at')
                $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'default\', \'value\' => UTools::now(), \'setOnEmpty\' => false, \'on\' => array(\'update\', \'insert\')),' . "\n";
            if ($c['COLUMN_NAME'] == 'created_at')
                $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'default\', \'value\' => UTools::now(), \'setOnEmpty\' => false, \'on\' => \'insert\'),' . "\n";
        }
        if ($c['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT) {
            $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'boolean\', \'on\' => array(\'insert\', \'update\')),' . "\n";
        }
        if ($c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE) {
            $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'file\', \'types\' => implode(\',\', static::$upload[\'' . $c['COLUMN_NAME'] . '\'][\'types\']),
                \'maxSize\' => static::$upload[\'' . $c['COLUMN_NAME'] . '\'][\'max\'], \'on\'=> array(\'upload\')),' . "\n";
        }
    }
    if ($c['IS_NULLABLE'] == 'YES')
        $html .= '            array(\'' . $c['COLUMN_NAME'] . '\', \'default\', \'setOnEmpty\' => true, \'value\' => null),' . "\n";
}

$html .= '
            // search
            array(\'';
foreach ($datas['columns'] as $c) {
    if (isset($c['BB_TYPE']) && in_array($c['BB_TYPE'], array(
        unitkitGenerator::TYPE_DATE_AUTO,
        unitkitGenerator::TYPE_DATE_INPUT
    ))) {
        $html .= 'v_' . $c['COLUMN_NAME'] . '_start, ';
        $html .= 'v_' . $c['COLUMN_NAME'] . '_end, ';
    } else
        $html .= $c['COLUMN_NAME'] . ', ';
}
foreach ($datas['i18nColumns'] as $c)
    $html .= 'lk_' . $c['TABLE_NAME'] . 's_' . $c['COLUMN_NAME'] . ', ';
foreach ($datas['relations'] as $k => $c) {
    if (isset($c['BB_REF']) && isset($datas['columns'][$k]['BB_TYPE']) && $datas['columns'][$k]['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
        $info = explode('.', $c['BB_REF']);
        if ($info[1] != $c['REFERENCED_COLUMN_NAME']) {
            $info[0] = unitkitGenerator::camelcaseToUnderscored($info[0]);
            /* if($info[0][strlen($info[0])-1] == 's') $info[0] = substr($info[0], 0, -1); */
            $html .= 'lk_' . $info[0] . '_' . $info[1] . ', ';
        }
    }
}
$html = substr($html, 0, - 2);
$html .= '\',
                \'safe\', \'on\' => \'search\'),
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(' . "\n";

foreach ($datas['relations'] as $r) {
    if ($r['TABLE_NAME'] == $datas['table']) {
        $html .= '            \'' . unitkitGenerator::underscoredToLowerCamelcase($r['REFERENCED_TABLE_NAME']) . '\' => array(self::BELONGS_TO, \'' . unitkitGenerator::underscoredToUpperCamelcase($r['REFERENCED_TABLE_NAME']) . '\', \'' . $r['COLUMN_NAME'] . '\'),' . "\n";

        if (isset($r['BB_REF']) && $r['BB_REF'] != '') {
            $info = explode('.', $r['BB_REF']);
            $tableRef = unitkitGenerator::camelcaseToUnderscored($info[0]);

            if ($tableRef != $r['REFERENCED_TABLE_NAME'] && $info[1] != $r['REFERENCED_COLUMN_NAME']) {
                $html .= '            \'' . unitkitGenerator::underscoredToLowerCamelcase($info[0]) . '\' => array(self::HAS_MANY, \'' . unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]) . '\', array(\'' . $r['COLUMN_NAME'] . '\' => \'' . $r['COLUMN_NAME'] . '\')),' . "\n";
            }
        }
    } else
        $html .= '            \'' . unitkitGenerator::underscoredToLowerCamelcase($r['TABLE_NAME']) . 's\' => array(self::HAS_MANY, \'' . unitkitGenerator::underscoredToUpperCamelcase($r['TABLE_NAME']) . '\', \'' . $r['COLUMN_NAME'] . '\'),' . "\n";
}
if (! empty($datas['i18nColumns']))
    $html .= '            \'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table_i18n']) . 's\' => array(self::HAS_MANY, \'' . unitkitGenerator::underscoredToUpperCamelcase($datas['table_i18n']) . '\', \'' . $datas['table'] . '_id\'),' . "\n";

$html .= '        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(' . "\n";
foreach ($datas['columns'] as $c) {
    $groupName = isset($c['BB_TYPE']) && ($c['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO || $c['BB_TYPE'] == unitkitGenerator::TYPE_CHECK_INPUT || $c['COLUMN_NAME'] == 'id') ? 'unitkit' : $datas['translate_const_model'];

    if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_DATE_AUTO || in_array($c['COLUMN_NAME'], array('id', 'activated', 'validated'))) {
        $html .= '            \'' . $c['COLUMN_NAME'] . '\' => Unitkit::t(\'' . $groupName . '\', \'model:' . $c['COLUMN_NAME'] . '\'),' . "\n";
    } else {
        $html .= '            \'' . $c['COLUMN_NAME'] . '\' => Unitkit::t(\'' . $groupName . '\', $this->tableName().\':' . $c['COLUMN_NAME'] . '\'),' . "\n";
    }
}

$htmlSSLab = '';
foreach ($datas['i18nColumns'] as $c)
    $htmlSSLab .= '            \'lk_' . $c['TABLE_NAME'] . 's_' . $c['COLUMN_NAME'] . '\' => ' . unitkitGenerator::underscoredToUpperCamelcase($c['TABLE_NAME']) . '::model()->getAttributeLabel(\'' . $c['COLUMN_NAME'] . '\'),' . "\n";
foreach ($datas['relations'] as $k => $c) {
    if (isset($c['BB_REF'])) {
        $info = explode('.', $c['BB_REF']);
        if ($info[1] != $c['REFERENCED_COLUMN_NAME']) {
            $model = unitkitGenerator::underscoredToUpperCamelcase(($info[0][strlen($info[0]) - 1] == 's') ? substr($info[0], 0, - 1) : $info[0]);
            $info[0] = unitkitGenerator::camelcaseToUnderscored($info[0]);
            /* if($info[0][strlen($info[0])-1] == 's') $info[0] = substr($info[0], 0, -1); */
            $htmlSSLab .= '            \'lk_' . $info[0] . '_' . $info[1] . '\' => ' . $model . '::model()->getAttributeLabel(\'' . $info[1] . '\'),' . "\n";
        }
    }
}
if ($htmlSSLab != '') {
    $html .= '
            // related attributes
' . $htmlSSLab;
}
$html .= '        );
    }';
if ($addSearchMethod) {
    $html .= '

    /**
     * Retrieves a list of models based on the current search/filter conditions
     *
     * @param string i18n ID
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($i18nId)
    {
        $criteria = $this->getDbCriteria();
        $criteria->alias = \'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '\';
        $criteria->with = array(
';

    foreach ($datas['relations'] as $k => $v) {
        if (isset($v['BB_REF']) && $v['BB_REF'] != '') {
            $info = explode('.', $v['BB_REF']);
            if ($info[1] != $v['REFERENCED_COLUMN_NAME']) {
                // $model = (unitkitGenerator::underscoredToLowerCamelcase($v['REFERENCED_TABLE_NAME']) != $info[0]) ? unitkitGenerator::underscoredToLowerCamelcase($v['REFERENCED_TABLE_NAME']).'.' : '';
                $model = unitkitGenerator::underscoredToLowerCamelcase($info[0]);
                $html .= '            \'' . $model . '\' => array(
                \'select\' => \'' . $info[1] . '\',
                \'alias\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($info[0]) . '\',
                \'joinType\' => \'LEFT JOIN\',
                \'together\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '\',';

                if (unitkitGenerator::underscoredToLowerCamelcase($v['REFERENCED_TABLE_NAME']) != $info[0]) /* i18n table */
                {
                    $html .= '
                \'on\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($info[0]) . '.i18n_id = :id18nId\',
                \'params\' => array(\':id18nId\' => $i18nId),';
                }

                $html .= '
            ),' . "\n";
            }
        }
    }
    if (! empty($datas['i18nColumns'])) {
        $model = unitkitGenerator::underscoredToLowerCamelcase($datas['table_i18n']) . 's';
        $html .= '            \'' . $model . '\' => array(
                \'select\' => \'';
        foreach ($datas['i18nColumns'] as $c)
            $html .= $c['COLUMN_NAME'] . ',';
        $html = substr($html, 0, - 1);
        $html .= '\',
                \'alias\' => \'' . $model . '\',
                \'joinType\' => \'LEFT JOIN\',
                \'together\' => \'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '\',
                \'on\' => \'' . $model . '.i18n_id = :id18nId\',
                \'params\' => array(\':id18nId\' => $i18nId)
            ),
';
    }

    $html .= '        );

        if ($this->validate()) {
';
    foreach ($datas['columns'] as $k => $c) {
        if (isset($c['BB_TYPE']) && in_array($c['BB_TYPE'], array(
            unitkitGenerator::TYPE_DATE_AUTO,
            unitkitGenerator::TYPE_DATE_INPUT
        ))) {
            $html .= '            if($this->v_' . $c['COLUMN_NAME'] . '_start != \'\')
            {
                $criteria->addCondition(\'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '.' . $c['COLUMN_NAME'] . ' >= :v_' . $c['COLUMN_NAME'] . '_start\');
                $criteria->params += array(\':v_' . $c['COLUMN_NAME'] . '_start\' => $this->v_' . $c['COLUMN_NAME'] . '_start);
            }
            if($this->v_' . $c['COLUMN_NAME'] . '_end != \'\')
            {
                $criteria->addCondition(\'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '.' . $c['COLUMN_NAME'] . ' <= DATE_ADD(:v_' . $c['COLUMN_NAME'] . '_end, INTERVAL 1 DAY)\');
                $criteria->params += array(\':v_' . $c['COLUMN_NAME'] . '_end\' => $this->v_' . $c['COLUMN_NAME'] . '_end);
            }' . "\n";
        } else {
            $ext = (in_array($c['DATA_TYPE'], array(
                'timestamp',
                'varchar',
                'text'
            ))) ? ', true' : '';
            $html .= '            $criteria->compare(\'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '.' . $c['COLUMN_NAME'] . '\', $this->' . $c['COLUMN_NAME'] . '' . $ext . ');' . "\n";
        }
    }
    foreach ($datas['i18nColumns'] as $k => $c) {
        $html .= '            $criteria->compare(\'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table_i18n']) . 's.' . $c['COLUMN_NAME'] . '\', $this->lk_' . $c['TABLE_NAME'] . 's_' . $c['COLUMN_NAME'] . ', true);' . "\n";
    }
    foreach ($datas['relations'] as $k => $c) {
        if (isset($c['BB_REF']) && isset($datas['columns'][$k]['BB_TYPE']) && $datas['columns'][$k]['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
            $info = explode('.', $c['BB_REF']);
            if ($info[1] != $c['REFERENCED_COLUMN_NAME']) {
                $info[0] = unitkitGenerator::camelcaseToUnderscored($info[0]);
                /* if($info[0][strlen($info[0])-1] == 's') $info[0] = substr($info[0], 0, -1); */
                $html .= '            $criteria->compare(\'' . unitkitGenerator::underscoredToLowerCamelcase($info[0]) . '.' . $info[1] . '\', $this->lk_' . $info[0] . '_' . $info[1] . ', true);' . "\n";
            }
        }
    }
    $html .= '        }

        return new CActiveDataProvider($this, array(
            \'criteria\' => $criteria,
            \'sort\' => array(
                \'sortVar\' => \'sort\',' . (count($datas['pk']) == 1 ? '
                \'defaultOrder\' => array(\'' . unitkitGenerator::underscoredToLowerCamelcase($datas['table']) . '.' . reset($datas['pk']) . '\' => CSort::SORT_DESC),' : '') . '
                \'attributes\' => array(';
    foreach ($datas['columns'] as $k => $c) {
        $html .= '
                    \'' . unitkitGenerator::underscoredToLowerCamelcase($c['TABLE_NAME']) . '.' . $c['COLUMN_NAME'] . '\' => array(
                    	\'label\' => $this->getAttributeLabel(\'' . $c['COLUMN_NAME'] . '\'),
                    ),';
    }
    foreach ($datas['i18nColumns'] as $k => $c) {
        $html .= '
                    \'' . unitkitGenerator::underscoredToLowerCamelcase($c['TABLE_NAME']) . 's.' . $c['COLUMN_NAME'] . '\' => array(
                    	\'label\' => $this->getAttributeLabel(\'lk_' . $c['TABLE_NAME'] . 's_' . $c['COLUMN_NAME'] . '\'),
                    ),';
    }

    foreach ($datas['relations'] as $k => $c) {
        if (isset($c['BB_REF'])) {
            $info = explode('.', $c['BB_REF']);
            if ($info[1] != $c['REFERENCED_COLUMN_NAME']) {
                $model = unitkitGenerator::underscoredToLowerCamelcase($info[0]);
                $info[0] = unitkitGenerator::camelcaseToUnderscored($info[0]);
                /* if($info[0][strlen($info[0])-1] == 's') $info[0] = substr($info[0], 0, -1); */
                $html .= '
                    \'' . $model . '.' . $info[1] . '\' => array(
                        \'label\' => $this->getAttributeLabel(\'lk_' . $info[0] . '_' . $info[1] . '\'),
                    ),';
            }
        }
    }

    $html .= '
                ),
            ),
            \'pagination\' => array(
                \'pageVar\' => \'page\'
            )
        ));
    }';
}
$html .= '
}';
return $html;