<?php
$html = '<?php

/**
 * Data view of settings interface
 *
 * @version 1.0
 */
class ' . $datas['controller'] . 'SettingsDataView extends BSettingsDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related data
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        // data view id
        $this->id = \'' . lcfirst($datas['class']) . $datas['controller'] . 'Settings\';
        parent::__construct($data, $relatedData, $isSaved);
    }
}';

return $html;