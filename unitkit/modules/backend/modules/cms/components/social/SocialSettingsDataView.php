<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class SocialSettingsDataView extends BSettingsDataView
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
        $this->id = 'bCmsSocialSocialSettings';
        parent::__construct($datas, $relatedDatas, $isSaved);
    }
}