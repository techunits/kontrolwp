<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Manage Settings Groups','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?php echo $controller_url?>/manage/cs"><?php echo __('Manage custom settings','kontrolwp')?></a></div>
            <div class="desc"><?php echo __('View and manage all your custom settings and fields','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?php echo APP_PLUGIN_URL?>/docs/custom-settings/" target="_blank"><?php echo __('Code Snippets / Documentation','kontrolwp')?></a></div>
            <div class="desc"><?php echo __('Grab some code snippets for using these custom settings in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<?php if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?php echo __('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
            <div class="menu-item add">
                <div class="link"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><?php echo sprintf(__('This limited edition allows you %d custom fields','kontrolwp'),10)?>.</a></div>
                <div class="desc"><?php echo __('You currently have','kontrolwp')?> <b><?php echo (10-$field_count)?></b> <?php echo __('fields left. If you upgrade to the full version, you get unlimited advanced custom fields and all upgrades to Kontrol for free!','kontrolwp')?></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php $this->renderElement('languages'); ?>



