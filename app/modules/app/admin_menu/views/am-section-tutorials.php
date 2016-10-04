<div class="section">
	<div class="inside">
        <div class="title"><?=__('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=APP_PLUGIN_URL?>/docs/admin-menu-editor/"><?=__('Documentation')?></a></div>
            <div class="desc"><?=__('View documentation on this module and also grab some code snippets for using this module in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<? if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?=__('Upgrade to Awesome','kontrolwp')?>!</div>
            <?php $this->renderElement('side-col-trial'); ?>
        </div>
    </div>
<? } ?>

<?php $this->renderElement('languages'); ?>