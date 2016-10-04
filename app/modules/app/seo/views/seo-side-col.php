
<div class="section notification">
     	<div class="inside">
            <div class="title"></div>
            <div class="menu-item alert"><div class="text link"></div></div>
        </div>
    </div>

<div class="section">
	<div class="inside">
        <div class="title"><?=__('Save','kontrolwp')?></div>
        <div class="menu-item submit-icon">
            <input type="submit" value="<?=__('Save Settings','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>
<div class="section">
	<div class="inside">
        <div class="title"><?=__('Menu','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/settings"><?=__('Main SEO Settings','kontrolwp')?></a></div>
            <div class="desc"><?=__('Configure the main SEO module settings','kontrolwp')?>.</div>
        </div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/defaults"><?=__('Title and Meta Data Defaults','kontrolwp')?></a></div>
            <div class="desc"><?=__('Set default SEO for the homepage or certain post types','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<?php $this->renderElement('seo-section-tutorials'); ?>

<?php $this->renderElement('languages'); ?>