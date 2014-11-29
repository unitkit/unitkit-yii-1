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
     * @param array $datas Array of CModel
     * @param array $relatedDatas Related datas
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $isSaved)
    {
        // data view id
        $this->id = \'' . lcfirst($datas['class']) . $datas['controller'] . 'Settings\';
        parent::__construct($datas, $relatedDatas, $isSaved);
    }
}';

return $html;