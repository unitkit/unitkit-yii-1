<?php

/**
 * Data view of settings interface
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MessageGroupSettingsDataView extends BSettingsDataView
{

    /**
     * Data view of settings component
     *
     * @param array $datas Array of CModel
     * @param array $relatedDatas Related datas
     * @param bool $isSaved Saved satus
     */
    public function __construct($datas, $relatedDatas, $isSaved)
    {
        $this->id = 'bMessageGroupMessageGroupSettings';
        parent::__construct($datas, $relatedDatas, $isSaved);
    }
}