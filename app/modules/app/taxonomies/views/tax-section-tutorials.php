<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?php echo APP_PLUGIN_URL?>/docs/custom-taxonomies/"><?php echo __('Code Snippets / Documentation','kontrolwp')?></a></div>
            <div class="desc"><?php echo __('Grab some code snippets for using custom taxonomies in the frontend','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<?php if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?php echo __('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
            <div class="menu-item add">
                <div class="link"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><?php echo sprintf(__('This limited edition allows you %d custom taxonomies','kontrolwp'),4)?>.</a></div>
                <div class="desc"><?php echo __('You currently have','kontrolwp')?> <b><?php echo (4-$tax_count)?></b> <?php echo __('taxonomies left. If you upgrade to the full version, you get unlimited taxonomies and all upgrades to Kontrol for free!','kontrolwp')?></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php $this->renderElement('languages'); ?>