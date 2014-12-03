<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class GroupSettingsDataView extends BSettingsDataView
{

    /**
     * Data view of settings component
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related data
     * @param bool $isSaved Saved status
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        $this->id = 'bGroupGroupSettings';
        parent::__construct($data, $relatedData, $isSaved);
    }
}