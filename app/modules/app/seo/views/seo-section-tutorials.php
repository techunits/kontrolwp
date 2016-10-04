<div class="section">
	<div class="inside">
        <div class="title"><?=__('Code and Tutorials','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=APP_PLUGIN_URL?>/docs/seo/"><?=__('Documentation','kontrolwp')?></a></div>
            <div class="desc"><?=__('View documentation on the SEO module here','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<? if(KONTROL_T) { ?>
	<div class="section">
        <div class="inside">
            <div class="title"><?=__('Upgrade to Awesome!','kontrolwp')?></div>
            <?php $this->renderElement('side-col-trial'); ?>
        </div>
    </div>
<? } ?>