<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MenuGroupSettingsDataView extends USettingsDataView
{
    /**
     * Constructor
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related datas
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        // data view id
        $this->id = 'uCmsMenuGroupMenuGroupSettings';
        parent::__construct($data, $relatedData, $isSaved);
    }
}