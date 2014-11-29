<?php
ini_set('display_errors', true);

$db = array(
    'name' => 'unitkit',
    'host' => '127.0.0.1',
    'user' => 'unitkit',
    'password' => 'unitkit'
);

if (empty($_POST)) {
?>
<html>
<body>
    <form action="module_generator.php" method="post">
        <table border="1">
            <tr>
                <th>Application name</th>
                <td><input type="text" name="app" value="backend" /></td>
            </tr>
            <tr>
                <th>Module name</th>
                <td><input type="text" name="module" /></td>
            </tr>
            <tr>
                <th>Controller name</th>
                <td><input type="text" name="controller" value="Default" /></td>
            </tr>
            <tr>
                <th>Translate group</th>
                <td><input type="text" name="translate_const_model" value="unitkit" /></td>
            </tr>
            <tr>
                <th>Table name</th>
                <td><input type="text" name="table" /></td>
            </tr>
            <tr>
                <td colspan="5"><input type="submit" value="Next" name="conf_table" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
<?php
} else {
    require __DIR__ . '/class/generator.php';

    $table = strtolower($_POST['table']);

    // new generator
    $generator = new unitkitGenerator($db);
    $generator::$pathTpl = __DIR__ . '/tpl';
    $generator::$pathResult = __DIR__ . '/results';

    // data
    $datas = array(
        'controller' => ucfirst($_POST['controller']),
        'translate_const_model' => $_POST['translate_const_model'],
        'class' => unitkitGenerator::underscoredToUpperCamelcase($table),
        'classI18n' => unitkitGenerator::underscoredToUpperCamelcase($table . '_i18n'),
        'module' => $_POST['module'],
        'table' => $table,
        'table_i18n' => $table . '_i18n',
        'pk' => false,
        'hasAdvInputFile' => false,
        'columns' => $generator->getColumns($table),
        'i18nColumns' => $generator->getI18nColumns($table),
        'belongTo' => $generator->getBelongToColumns($table),
        'isTableI18n' => false
    );
    $datas['allColumns'] = array() + $datas['columns'] + $datas['i18nColumns'];

    if (isset($_POST['conf_table']) && ! empty($_POST['module']) && ! empty($_POST['table']) && ! empty($_POST['controller']) && ! empty($_POST['translate_const_model'])) {
?>
<html>
<body>
    <form action="module_generator.php" method="post">
        <table border="1">
            <tr>
                <td>Position</td>
                <td>Columns</td>
                <td>Tables</td>
                <td>Format</td>
                <td>Option</td>
                <td>Relation attribute</td>
            </tr>
<?php
        $i = 0;
        foreach ($datas['allColumns'] as $c) :
            $subTable = isset($datas['belongTo'][unitkitGenerator::underscoredToLowerCamelcase($c['TABLE_NAME']) . '.' . $c['COLUMN_NAME']]) ? $datas['belongTo'][unitkitGenerator::underscoredToLowerCamelcase($c['TABLE_NAME']) . '.' . $c['COLUMN_NAME']]['REFERENCED_TABLE_NAME'] : $c['TABLE_NAME'];
            $class = unitkitGenerator::underscoredToLowerCamelcase(($c['TABLE_NAME'] == $datas['table'] . '_i18n') ? $c['TABLE_NAME'] . 's' : $c['TABLE_NAME']);
            $cTable = isset($datas['belongTo'][$class . '.' . $c['COLUMN_NAME']]) ? $datas['belongTo'][unitkitGenerator::underscoredToLowerCamelcase($c['TABLE_NAME']) . '.' . $c['COLUMN_NAME']]['REFERENCED_TABLE_NAME'] : $c['TABLE_NAME'];
?>
				<tr>
                <th><input type="text" name="position[<?=$class.'.'.$c['COLUMN_NAME']?>]" value="<?= $i++; ?>" /></th>
                <th><?=$c['COLUMN_NAME']?></th>
                <td><?=$cTable ?></td>
                <td>
                    <?=$c['DATA_TYPE']?>
                </td>
                <td>
                    <select name="options[<?=$class.'.'.$c['COLUMN_NAME']?>]">
						<?php if($subTable != $datas['table'] && $subTable != $datas['table'].'_i18n'): ?>
                        <option value="<?=unitkitGenerator::TYPE_SELECT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_SELECT)?></option>
                        <option value="<?=unitkitGenerator::TYPE_ADV_SELECT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_ADV_SELECT)?></option>
                        <option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
						<?php elseif(in_array($c['DATA_TYPE'], array('text', 'varchar','mediumtext', 'longtext', 'tinytext'))): ?>
                        <option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
                        <option value="<?=unitkitGenerator::TYPE_TEXTAREA ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXTAREA)?></option>
                        <option value="<?=unitkitGenerator::TYPE_ADV_TEXTAREA ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_ADV_TEXTAREA)?></option>
						<?php if($cTable == $table): ?>
						<option value="<?=unitkitGenerator::TYPE_ADV_INPUT_FILE ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_ADV_INPUT_FILE)?></option>
						<?php endif; ?>
						<?php elseif(in_array($c['DATA_TYPE'], array('timestamp', 'datetime')) && !in_array($c['COLUMN_NAME'], array('created_at', 'updated_at')) ): ?>
                        <option value="<?=unitkitGenerator::TYPE_DATE_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_DATE_INPUT)?></option>
                        <option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
						<?php elseif($c['COLUMN_TYPE'] == 'tinyint(1) unsigned'): ?>
                        <option value="<?=unitkitGenerator::TYPE_CHECK_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_CHECK_INPUT)?></option>
						<?php elseif(!in_array($c['COLUMN_NAME'], array('created_at', 'updated_at')) && $c['COLUMN_KEY'] != 'PRI'):?>
                        <option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
						<?php elseif(in_array($c['COLUMN_NAME'], array('created_at', 'updated_at'))): ?>
                        <option value="<?=unitkitGenerator::TYPE_DATE_AUTO ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_DATE_AUTO)?></option>
                        <option value="<?=unitkitGenerator::TYPE_DATE_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_DATE_INPUT)?></option>
                        <option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
						<?php elseif($c['COLUMN_KEY'] == 'PRI'): ?>
							<?php if($c['EXTRA'] == 'auto_increment'):?>
							<option value="<?=unitkitGenerator::TYPE_PRIMARY_AUTO ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_PRIMARY_AUTO)?></option>
							<?php endif; ?>
							<option value="<?=unitkitGenerator::TYPE_TEXT_INPUT ?>"><?=unitkitGenerator::optionName(unitkitGenerator::TYPE_TEXT_INPUT)?></option>
						<?php endif; ?>
                    </select>
                </td>
                <td>
                <?php if ($subTable != $datas['table'] && $subTable != $datas['table'] . '_i18n') : ?>
					<select name="relations[<?=$class.'.'.$c['COLUMN_NAME']?>]">
						<?php foreach($generator->getColumns($subTable) as $subC): ?>
							<option value="<?=unitkitGenerator::underscoredToLowerCamelcase($subC['TABLE_NAME']).'.'.$subC['COLUMN_NAME']?>"><?=unitkitGenerator::underscoredToLowerCamelcase($subC['TABLE_NAME']).'.'.$subC['COLUMN_NAME']?></option>
						<?php endforeach;?>
					    <?php foreach($generator->getI18nColumns($subTable) as $subC): ?>
							<option value="<?=unitkitGenerator::underscoredToLowerCamelcase($subC['TABLE_NAME']).'s.'.$subC['COLUMN_NAME']?>"><?=unitkitGenerator::underscoredToLowerCamelcase($subC['TABLE_NAME']).'s.'.$subC['COLUMN_NAME']?></option>
						<?php endforeach;?>
					</select>
                <?php endif;?>
                </td>
            </tr>
				<?php endforeach; ?>
				<tr>
                <td colspan="5">
                    <input type="hidden" name="module" value="<?=$_POST['module']?>" />
                    <input type="hidden" name="table" value="<?=$_POST['table']?>" />
                    <input type="hidden" name="controller" value="<?=$_POST['controller']?>" />
                    <input type="hidden" name="translate_const_model" value="<?=$_POST['translate_const_model']?>" />
                    <input type="hidden" name="app" value="<?=$_POST['app']?>" />
                    <input type="submit" value="Build" name="build" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
<?php
    } elseif (isset($_POST['build'])) {
        $datas['hasMany'] = $generator->getHasManyColumns($datas['table']);
        $datas['relations'] = array() + $datas['belongTo'] + $datas['hasMany'];
        $datas['app'] = $_POST['app'];

        if (isset($_POST['options']))
            $generator->applyColumnsOptions($_POST['options'], $datas);

        if (isset($_POST['relations']))
            $generator->applyRelations($_POST['relations'], $datas);

        foreach ($datas['columns'] as $k => $c) {
            if ($c['COLUMN_KEY'] == 'PRI')
                $datas['pk'][] = $c['COLUMN_NAME'];
            if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE)
                $datas['hasAdvInputFile'] = true;
        }

        $generator->createDirectory($datas, ! empty($datas['i18nColumns']));
        if (! empty($datas['i18nColumns'])) {
            $generator->createTranslateComponent($datas);

            $tableI18n = $table . '_i18n';
            // data
            $i18nDatas = array(
                'class' => unitkitGenerator::underscoredToUpperCamelcase($tableI18n),
                'classI18n' => null,
                'module' => $_POST['module'],
                'table' => $tableI18n,
                'table_i18n' => null,
                'translate_const_model' => $_POST['translate_const_model'],
                'pk' => false,
                'hasAdvInputFile' => false,
                'columns' => $generator->getColumns($tableI18n),
                'i18nColumns' => $generator->getI18nColumns($tableI18n),
                'belongTo' => $generator->getBelongToColumns($tableI18n),
                'isTableI18n' => true
            );
            $i18nDatas['hasMany'] = $generator->getHasManyColumns($i18nDatas['table']);
            $i18nDatas['relations'] = array() + $i18nDatas['belongTo'] + $i18nDatas['hasMany'];
            $i18nDatas['allColumns'] = array() + $i18nDatas['columns'] + $i18nDatas['i18nColumns'];
            foreach ($i18nDatas['columns'] as $k => $c) {
                if ($c['COLUMN_KEY'] == 'PRI' && $c['COLUMN_NAME'] != 'b_i18n_id')
                    $i18nDatas['pk'] = $c['COLUMN_NAME'];
                if (isset($c['BB_TYPE']) && $c['BB_TYPE'] == unitkitGenerator::TYPE_ADV_INPUT_FILE)
                    $i18nDatas['hasAdvInputFile'] = true;
            }
            $generator->createModel($i18nDatas, false);
        }

        $positions = array_flip($_POST['position']);
        ksort($positions);

        $tmpColumns = array();
        foreach ($positions as $id) {
            $tmpColumns[$id] = $datas['allColumns'][$id];
        }

        $datas['allColumns'] = $tmpColumns;

        $generator->createEditComponent($datas);
        $generator->createListComponent($datas);
        $generator->createListRowComponent($datas);
        $generator->createEditRowComponent($datas);
        $generator->createSettingComponent($datas);
        $generator->createModel($datas);
        $generator->createControler($datas);
        $generator->createModuleInit($datas);
        $generator->createDBRoles($datas);

        echo 'The '.$datas['module'].' module is now build !';
    }
}
?>