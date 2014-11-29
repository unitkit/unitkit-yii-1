<?php

/**
 * Unitki Generator
 *
 * @version 1.0.0
 */
class unitkitGenerator
{
    const TYPE_TEXT_INPUT = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_ADV_TEXTAREA = 3;
    const TYPE_ADV_INPUT_FILE = 4;
    const TYPE_DATE_INPUT = 5;
    const TYPE_SELECT = 6;
    const TYPE_ADV_SELECT = 7;
    const TYPE_PRIMARY_AUTO = 8;
    const TYPE_DATE_AUTO = 9;
    const TYPE_CHECK_INPUT = 10;
    public static $pathTpl;
    public static $pathResult;
    protected $pdo;

    public function __construct($db)
    {
        $this->pdo = new PDO('mysql:dbname=' . $db['name'] . ';host=' . $db['host'], $db['user'], $db['password']);
        $this->db = $db;
    }

    public static function optionName($id)
    {
        switch ($id) {
            case self::TYPE_TEXT_INPUT:
                return 'text input';
                break;
            case self::TYPE_TEXTAREA:
                return 'textarea';
                break;
            case self::TYPE_ADV_TEXTAREA:
                return 'advanced textarea';
                break;
            case self::TYPE_ADV_INPUT_FILE:
                return 'advanced input file';
                break;
            case self::TYPE_DATE_INPUT:
                return 'date input';
                break;
            case self::TYPE_SELECT:
                return 'select';
                break;
            case self::TYPE_ADV_SELECT:
                return 'advanced select';
                break;
            case self::TYPE_PRIMARY_AUTO:
                return 'primary auto';
                break;
            case self::TYPE_DATE_AUTO:
                return 'date auto';
                break;
            case self::TYPE_CHECK_INPUT:
                return 'radio input';
                break;
        }
    }

    public function getColumns($tableName)
    {
        $sql = 'SELECT
					DISTINCT COLUMN_NAME, TABLE_NAME, DATA_TYPE, COLUMN_TYPE, EXTRA, CHARACTER_MAXIMUM_LENGTH, COLUMN_KEY, IS_NULLABLE
				 FROM
				 	information_schema.COLUMNS
				 WHERE
				 	table_name= \'' . $tableName . '\' AND TABLE_SCHEMA = \'' . $this->db['name'] . '\'';
        $columns = array();
        foreach ($this->pdo->query($sql) as $row) {
            $columns[self::underscoredToLowerCamelcase($row['TABLE_NAME']) . '.' . $row['COLUMN_NAME']] = $row;
        }
        return $columns;
    }

    public function getI18nColumns($tableName)
    {
        $sql = 'SELECT
				DISTINCT COLUMN_NAME, TABLE_NAME, DATA_TYPE, COLUMN_TYPE, EXTRA, CHARACTER_MAXIMUM_LENGTH, COLUMN_KEY
			 FROM
			 	information_schema.COLUMNS
			 WHERE
			 	COLUMN_KEY <> \'PRI\'
			 	AND table_name= \'' . $tableName . '_i18n\' AND TABLE_SCHEMA = \'' . $this->db['name'] . '\'';

        $columns = array();
        foreach ($this->pdo->query($sql) as $row) {
            $columns[self::underscoredToLowerCamelcase($row['TABLE_NAME']) . 's.' . $row['COLUMN_NAME']] = $row;
        }
        return $columns;
    }

    public function getBelongToColumns($tableName)
    {
        $sql = 'SELECT
				i.TABLE_NAME, i.CONSTRAINT_TYPE, i.CONSTRAINT_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME, k.COLUMN_NAME
	         FROM
	         	information_schema.TABLE_CONSTRAINTS i
	            INNER JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME
	         WHERE
	         	i.CONSTRAINT_TYPE = \'FOREIGN KEY\'
	        	AND i.TABLE_SCHEMA = \'' . $this->db['name'] . '\'
	        	AND i.TABLE_NAME = \'' . $tableName . '\'';

        $belongTo = array();
        foreach ($this->pdo->query($sql) as $row) {
            $belongTo[self::underscoredToLowerCamelcase($row['TABLE_NAME']) . '.' . $row['COLUMN_NAME']] = $row;
        }
        return $belongTo;
    }

    public function getHasManyColumns($tableName)
    {
        $sql = 'SELECT
				i.TABLE_NAME, i.CONSTRAINT_TYPE, i.CONSTRAINT_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME, k.COLUMN_NAME
			 FROM
			 	information_schema.TABLE_CONSTRAINTS i
			    INNER JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME
			 WHERE
			 	i.CONSTRAINT_TYPE = \'FOREIGN KEY\'
				AND i.TABLE_SCHEMA = \'' . $this->db['name'] . '\'
				AND i.TABLE_NAME <> \'' . $tableName . '_i18n\'
				AND k.REFERENCED_TABLE_NAME = \'' . $tableName . '\'';
        $hasMany = array();
        foreach ($this->pdo->query($sql) as $row) {
            $hasMany[self::underscoredToLowerCamelcase($row['TABLE_NAME']) . 's.' . $row['COLUMN_NAME']] = $row;
        }
        return $hasMany;
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
     * Underscored to upper-camelcase
     * e.g.
     * "this_method_name" -> "ThisMethodName"
     *
     * @param unknown_type $string string to transform
     */
    public static function underscoredToUpperCamelcase($string)
    {
        $prefix = strtoupper(substr($string, 0, 2));
        $string = ($prefix == 'B') ? $prefix . substr($string, 2) : $string;
        return preg_replace('/(?:^|_)(.?)/e', "strtoupper('$1')", $string);
    }

    /**
     * Camelcase (lower or upper) to underscored
     * e.g.
     * "thisMethodName" -> "this_method_name"
     * e.g. "ThisMethodName" -> "this_method_name"
     *
     * @param unknown_type $string string to transform
     */
    public static function camelcaseToUnderscored($string)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $string));
    }

    public static function wordCut($string)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1 $2", $string));
    }

    public function createDirectory($datas, $isI18n)
    {
        $controller = lcfirst($datas['controller']);

        @mkdir(self::$pathResult . '/' . $datas['module'], 0777, true);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/public', 0777, true);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/public/css', 0777, true);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/public/js', 0777, true);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/public/images', 0777, true);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/controllers', 0777);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/components', 0777);
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/models', 0777);
    }

    public function createEditComponent($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'EditDataView.php', include self::$pathTpl . '/components/EditDataView.php');
    }

    public function createSettingComponent($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'SettingsDataView.php', include self::$pathTpl . '/components/SettingsDataView.php');
    }

    public function createTranslateComponent($datas)
    {
        $controller = lcfirst($datas['controller']);
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'TranslateDataView.php', include self::$pathTpl . '/components/TranslateDataView.php');
    }

    public function createListRowComponent($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'ListRowDataView.php', include self::$pathTpl . '/components/ListRowDataView.php');
    }

    public function createEditRowComponent($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'EditRowDataView.php', include self::$pathTpl . '/components/EditRowDataView.php');
    }

    public function createListComponent($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/components/' . $datas['controller'] . 'ListDataView.php', include self::$pathTpl . '/components/ListDataView.php');
    }

    public function createModel($datas, $addSearchMethod = true)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/models/' . $datas['class'] . '.php', include self::$pathTpl . '/models/model.php');
    }

    public function createControler($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/controllers/' . $datas['controller'] . 'Controller.php', include self::$pathTpl . '/controllers/controller.php');
    }

    public function createModuleInit($datas)
    {
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/' . unitkitGenerator::underscoredToUpperCamelcase(basename($datas['module'])) . 'Module.php', include self::$pathTpl . '/module.php');
    }

    public function createDBRoles($datas)
    {
        @mkdir(self::$pathResult . '/' . $datas['module'] . '/datas/db', 0777, true);

        $content = '';
        $operation = array(
            'create',
            'update',
            'consult',
            'delete'
        );
        foreach ($operation as $op) {
            $name = $op . ':' . $datas['app'] .'/' . $datas['module'] . '/' . strtolower(substr($datas['controller'],0,1)).substr($datas['controller'],1);
            $content .= 'INSERT INTO b_role(operation, business_rule, created_at, updated_at) ' . 'VALUES ("' . $name . '", "", NOW(), NOW());' . "\n";
            $content .= 'INSERT INTO b_role_i18n(b_role_id, i18n_id, name) ' . 'VALUES (LAST_INSERT_ID(), "en", "' . ucfirst($op) . ' ' . strtolower(unitkitGenerator::wordCut($datas['controller'])) . 's");' . "\n";
        }
        file_put_contents(self::$pathResult . '/' . $datas['module'] . '/datas/db/' . $datas['controller'] . 'Roles.sql', $content);
    }

    public function applyColumnsOptions($options, &$datas)
    {
        foreach ($options as $k => $o) {
            $datas['allColumns'][$k]['BB_TYPE'] = $o;
            if (isset($datas['columns'][$k]))
                $datas['columns'][$k]['BB_TYPE'] = $o;
            elseif (isset($datas['i18nColumns'][$k]))
                $datas['i18nColumns'][$k]['BB_TYPE'] = $o;
        }
    }

    public function applyRelations($relations, &$datas)
    {
        foreach ($relations as $k => $o)
            $datas['relations'][$k]['BB_REF'] = $o;
    }
}