<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class VariableGroupSettingsDataView extends BSettingsDataView
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
        $this->id = 'bVariableGroupVariableGroupSettings';
        parent::__construct($data, $relatedData, $isSaved);
    }
}