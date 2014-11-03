<?php

/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class PageContainerEditContainersArrayDataView
{
    /**
     * Array of BArrayRowItemDataView
     *
     * @var array
     */
    public $rows = array();

    public function __construct($datas)
    {
        if (isset($datas['BCmsPageContents'])) {
            foreach($datas['BCmsPageContents'] as $id => $bCmsPageContent) {
                $this->rows[] = new PageContainerEditContainersArrayRowDataView($id, $datas);
            }
        }
    }
}