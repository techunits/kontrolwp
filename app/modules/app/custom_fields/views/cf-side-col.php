<div class="section">
	<div class="inside">
        <div class="title"><?=__('Manage Custom Fields Groups','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/manage"><?=__('Manage custom fields','kontrolwp')?></a></div>
            <div class="desc"><?=__('View and manage all your custom fields','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<div class="section">
	<div class="inside">
        <div class="title"><?=__('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=APP_PLUGIN_URL?>/docs/custom-fields/" target="_blank"><?=__('Code Snippets / Documentation','kontrolwp')?></a></div>
            <div class="desc"><?=__('Grab some code snippets for using these advanced custom fields in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<? if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?=__('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
            <div class="menu-item add">
                <div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=sprintf(__('This limited edition allows you %d custom fields','kontrolwp'),10)?>.</a></div>
                <div class="desc"><?=__('You currently have','kontrolwp')?> <b><?=(10-$field_count)?></b> <?=__('fields left. If you upgrade to the full version, you get unlimited advanced custom fields and all upgrades to Kontrol for free!','kontrolwp')?></div>
            </div>
        </div>
    </div>
<? } ?>

<?php $this->renderElement('languages'); ?>




