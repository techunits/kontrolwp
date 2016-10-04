<div class="section">
	<div class="inside">
        <div class="title"><?=__('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=APP_PLUGIN_URL?>/docs/custom-post-types/"><?=__('Code Snippets / Documentation','kontrolwp')?></a></div>
            <div class="desc"><?=__('Grab some code snippets for using custom post types in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<? if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?=__('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
            <div class="menu-item add">
                <div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=sprintf(__('This limited edition allows you %d custom post types','kontrolwp'),2)?>.</a></div>
                <div class="desc"><?=__('You currently have','kontrolwp')?> <b><?=(2-$pt_count)?></b> <?=__('post types left. If you upgrade to the full version, you get unlimited custom post types and all upgrades to Kontrol for free!','kontrolwp')?></div>
            </div>
        </div>
    </div>
<? } ?>

<?php $this->renderElement('languages'); ?>