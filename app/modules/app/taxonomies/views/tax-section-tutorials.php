<div class="section">
	<div class="inside">
        <div class="title"><?=__('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=APP_PLUGIN_URL?>/docs/custom-taxonomies/"><?=__('Code Snippets / Documentation','kontrolwp')?></a></div>
            <div class="desc"><?=__('Grab some code snippets for using custom taxonomies in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<? if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?=__('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
            <div class="menu-item add">
                <div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=sprintf(__('This limited edition allows you %d custom taxonomies','kontrolwp'),4)?>.</a></div>
                <div class="desc"><?=__('You currently have','kontrolwp')?> <b><?=(4-$tax_count)?></b> <?=__('taxonomies left. If you upgrade to the full version, you get unlimited taxonomies and all upgrades to Kontrol for free!','kontrolwp')?></div>
            </div>
        </div>
    </div>
<? } ?>

<?php $this->renderElement('languages'); ?>