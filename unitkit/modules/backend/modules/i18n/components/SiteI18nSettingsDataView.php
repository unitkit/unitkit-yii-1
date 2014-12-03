<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SiteI18nSettingsDataView extends BSettingsDataView
{

    /**
     * Data view of settings component
     *
     * @param array $data Array of CModel
     * @param array $relatedData Related datas
     * @param bool $isSaved Saved satus
     */
    public function __construct($data, $relatedData, $isSaved)
    {
        $this->id = 'bSiteI18nSiteI18nSettings';
        parent::__construct($data, $relatedData, $isSaved);
    }
}