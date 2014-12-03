<?php
$html = '<?php

/**
 * Data view of translate interface
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'TranslateDataView extends BTranslateDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModels
     * @param array $relatedData Array of related data
     * @param array $pk Primary key
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $pk, $isSaved)
    {
        // data view id
        $this->id = \'' . lcfirst($datas['class']) . $datas['controller'] . 'Translate\';

        // primary key
        $this->pk = $pk;

        // I18n model
        $this->model = ' . ucfirst($datas['class']) . 'I18n::model();

        // data
        $this->data = $data;

        // related data
        $this->relatedData = $relatedData;

        // saved status
        $this->isSaved = $isSaved;

        // items
        $this->items = array(';
foreach ($datas['i18nColumns'] as $k => $v) {
    if ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXT_INPUT) {
        $html .= '
            new BItemField(array(
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextField\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm\',
                    \'id\' => false,
                )
            )),';
    } elseif ($v['BB_TYPE'] == unitkitGenerator::TYPE_TEXTAREA || $v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA) {
        $html .= '
            new BItemField(array(
                \'attribute\' => \'' . $v['COLUMN_NAME'] . '\',
                \'type\' => \'activeTextArea\',
                \'htmlOptions\' => array(
                    \'class\' => \'form-control input-sm' . ($v['BB_TYPE'] == unitkitGenerator::TYPE_ADV_TEXTAREA ? ' advanced-textarea' : '') . '\',
                    \'id\' => false,
                )
            )),';
    }
}
$html .= '
        );
    }
}';
return $html;