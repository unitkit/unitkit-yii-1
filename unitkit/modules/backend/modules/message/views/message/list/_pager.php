<div class="text-center">
<?php
    $this->widget(
        'CLinkPager',
        array(
            'pages' => $pagination,
            'htmlOptions' => array(
                'class' => 'pagination'
            ),
            'selectedPageCssClass' => 'active',
            'hiddenPageCssClass' => 'disabled',
            'header' => '',
            'cssFile' => false
        )
    );
?>
</div>