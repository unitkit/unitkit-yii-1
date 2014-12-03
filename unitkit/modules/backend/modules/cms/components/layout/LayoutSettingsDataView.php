<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class LayoutSettingsDataView extends BSettingsDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related data
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        // data view id
        $this->id = 'bCmsLayoutLayoutSettings';
        parent::__construct($data, $relatedData, $isSaved);
    }
}