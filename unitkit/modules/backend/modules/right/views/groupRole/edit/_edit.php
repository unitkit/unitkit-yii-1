<div class="header-title">
    <h1><?=Unitkit::t('backend', 'right_group_role_edit_title') ?></h1>
</div>
<div class="inner-container">
    <div class="grid">
	    <?php $this->renderPartial('edit/_form', array('models' => $models, 'isSaved' => $isSaved))?>
	</div>
    <!-- grid container -->
</div>