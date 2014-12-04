<?= isset($this->cmsPageContents[1]) ? $this->cmsPageContents[1] : ''; ?>

<div class="row" id="contact_form">
    <div class="box">
        <div class="col-lg-12">
            <?= isset($this->cmsPageContents[2]) ? $this->cmsPageContents[2] : ''; ?>
            <?php if($models['ContactForm']->hasErrors()): ?>
                <div class="alert alert-danger">
                    <?= UHtml::errorSummary($models['ContactForm']); ?>
                </div>
            <?php endif; ?>

            <?php if($isSent): ?>
                <div class="alert alert-success">
                    <?= Unitkit::t('frontend', 'email_is_sent') ?>
                </div>
            <?php endif; ?>
            <form role="form" method="POST" class="csrf" action="<?= $this->createUrl($this->id.'/index'); ?>#contact_form">
                <div class="row">
                    <div class="form-group col-lg-4 <?= $models['ContactForm']->hasErrors('firstName') ? 'has-error' : ''; ?>">
                        <label><?= $models['ContactForm']->getAttributeLabel('firstName'); ?></label>
                        <?= UHtml::activeTextField($models['ContactForm'], 'firstName', array('class' => 'form-control')) ?>
                    </div>
                    <div class="form-group col-lg-4 <?= $models['ContactForm']->hasErrors('lastName') ? 'has-error' : ''; ?>">
                        <label><?= $models['ContactForm']->getAttributeLabel('lastName'); ?></label>
                        <?= UHtml::activeTextField($models['ContactForm'], 'lastName', array('class' => 'form-control')) ?>
                    </div>
                    <div class="form-group col-lg-4 <?= $models['ContactForm']->hasErrors('email') ? 'has-error' : ''; ?>">
                        <label><?= $models['ContactForm']->getAttributeLabel('email'); ?></label>
                        <?= UHtml::activeEmailField($models['ContactForm'], 'email', array('class' => 'form-control')) ?>
                    </div>
                    <div class="form-group col-lg-4 <?= $models['ContactForm']->hasErrors('phone') ? 'has-error' : ''; ?>">
                        <label><?= $models['ContactForm']->getAttributeLabel('phone'); ?></label>
                        <?= UHtml::activeTelField($models['ContactForm'], 'phone', array('class' => 'form-control')) ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-lg-12 <?= $models['ContactForm']->hasErrors('message') ? 'has-error' : ''; ?>">
                        <label><?= $models['ContactForm']->getAttributeLabel('message'); ?></label>
                        <?= UHtml::activeTextArea($models['ContactForm'], 'message', array('class' => 'form-control', 'rows' => 6)) ?>
                    </div>
                    <div class="form-group col-lg-12">
                        <input type="hidden" name="save" value="contact">
                        <button type="submit" class="btn btn-default"><?= Unitkit::t('unitkit', 'btn_send'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>