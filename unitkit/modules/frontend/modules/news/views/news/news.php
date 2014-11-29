<?= isset($this->cmsPageContents[1]) ? $this->cmsPageContents[1] : ''; ?>
<section>
    <?php foreach($data as $d): ?>
    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                <h2>
                    <?= $d->bCmsNewsI18n->title; ?>
                    -
                    <small><?=date("F j, Y", strtotime($d->created_at )) ?></small>
                </h2>
                <?= $d->bCmsNewsI18n->content; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>
<div class="text-center">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pagination,
        'htmlOptions' => array(
            'class' => 'pagination'
        ),
        'selectedPageCssClass' => 'active',
        'hiddenPageCssClass' => 'disabled',
        'header' => '',
        'cssFile' => false
    ));
    ?>
</div>