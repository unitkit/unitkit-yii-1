<?php

/**
 * This class build a navigation bar
 *
 * @param mixed $items array(
 *	'brand' => array(
 *		'label' => array(
 * 	    	'value' => name,
 * 	    	'url' => url,
 * 			'hasRight' => true|false,
 * 	    	'active' => true|false
 * 	  	),
 *	)
 *	'items' => array(
 *		array(
 * 	  		'label' => array(
 * 	   			'value' => name,
 * 	   			'url' => url,
 * 	   			'hasRight' => int,
 * 	   			'active' => true|false
 * 	  		),
 * 	  		'items' => array(
 * 	   			array(
 * 	    			'label' => array(
 * 		  				'value' => name,
 *        				'url' => url,
 * 		  				'hasRight' => true|false,
 * 	      				'active' => true|false
 * 		 			)
 * 				),
 * 				array(
 * 					...
 * 				)
 *     		)
 *      ),
 *     	array(
 *        ...
 *     	),
 *	)
 *)
 *
 * @param mixed $htmlOptions @link $htmlOptions
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UNavBar extends CWidget
{
    /**
     * Datas needed to build menu
     *
     * @var array
     */
    public $items;

    /**
     * Html options
     *
     * @var array
     */
    public $htmlOptions;

    public function init()
    {
        // default options
        if ($this->items === null)
            $this->items = Yii::app()->controller->navBarData->config();
        if ($this->htmlOptions === null)
            $this->htmlOptions = array(
                'class' => 'navbar-inverse navbar-fixed-top'
            );
    }

    /**
     * Init array of html options
     *
     * @param mixed $item array of links
     */
    protected function initHtmlOptions(&$item)
    {
        if (! isset($item['htmlOptions']))
            $item['htmlOptions'] = array(
                'class' => ''
            );
        if (! isset($item['htmlOptions']['class']))
            $item['htmlOptions']['class'] = '';
    }

    /**
     * Build an item
     *
     * @param mixed $item array(value, url, htmlOptions, hasRight, type)
     */
    protected function buildItem(&$item)
    {
        if (isset($item['label']['type']) && $item['label']['type'] == 'brand')
            $item['label']['htmlOptions']['class'] .= ' navbar-brand';

        if (isset($item['label']['active']) && $item['label']['active'] === false)
            return '';

        if (! isset($item['label']['url']))
            return UHtml::tag('span', $item['label']['htmlOptions'], $item['label']['value']);

        if (isset($item['label']['hasRight']) && ! $item['label']['hasRight'])
            $item['label']['url'] = '#';

        return UHtml::link($item['label']['value'], $item['label']['url'], $item['label']['htmlOptions']);
    }

    /**
     * Build items of menu
     *
     * @param mixed $item
     * @param int $level
     */
    protected function buildItems($items, $level = 0)
    {
        $html = '';
        foreach ($items as $item) {
            // init html options
            $this->initHtmlOptions($item);
            $this->initHtmlOptions($item['label']);
            // var_dump($item);
            $itemHtml = '';
            if (isset($item['items'])) {
                if ($item['cpt'] > 0) {
                    if ($level == 0) {
                        $item['label']['value'] .= '<b class="caret"></b>';
                        $item['htmlOptions']['class'] .= ' dropdown';
                    } else
                        $item['htmlOptions']['class'] .= ' dropdown-submenu';

                    $item['label']['htmlOptions']['class'] .= ' dropdown-toggle';
                    $item['label']['htmlOptions']['data-toggle'] = 'dropdown';

                    $itemHtml .= $this->buildItem($item) . '<ul class="dropdown-menu">' . $this->buildItems($item['items'], $level + 1) . '</ul>';
                }
            } elseif (! isset($item['cpt']) || $item['cpt'] > 0)
                $itemHtml .= $this->buildItem($item);

            if ($itemHtml != '')
                $html .= UHtml::tag('li', $item['htmlOptions'], $itemHtml);
        }

        return $html;
    }

    /**
     * Build rights
     *
     * @param mixed $items
     * @return int
     */
    protected function buildRights(&$items)
    {
        $cpt = 0;
        foreach ($items as $k => &$itemData) {
            if (isset($itemData['items'])) {
                $itemData['cpt'] = $this->buildRights($itemData['items']);
                $cpt += $itemData['cpt'];
            } elseif ((! isset($itemData['label']['hasRight']) && isset($itemData['label']['url']) && $itemData['label']['url'] != '#') || (isset($itemData['label']['hasRight']) && $itemData['label']['hasRight'])) {
                $cpt += 1;
                $itemData['cpt'] = 1;
            } elseif (isset($itemData['label']['hasRight']))
                $itemData['cpt'] = 0;
        }
        return $cpt;
    }

    /**
     * Get html
     */
    public function run()
    {
        $html = '
		<div class="navbar' . (isset($this->htmlOptions['class']) ? ' ' . $this->htmlOptions['class'] : '') . '">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			      <span class="sr-only">Toggle navigation</span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			    </button>';

        if (isset($this->items['brand'])) {
            $this->initHtmlOptions($this->items['brand']['label']);
            $html .= $this->buildItem($this->items['brand']);
        }

        $html .= '
			</div>
			<div class="collapse navbar-collapse">';
        if (! empty($this->items['items']))
            foreach ($this->items['items'] as &$datas) {
                $this->buildRights($datas['items']);

                $html .= '
						<ul class="nav navbar-nav' . (isset($datas['htmlOptions']['class']) ? ' ' . $datas['htmlOptions']['class'] : '') . '">' . $this->buildItems($datas['items']) . '
						</ul>';
            }
        $html .= '
			</div>
		</div>';

        echo $html;
    }
}