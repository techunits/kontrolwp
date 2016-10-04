
<div class="section">
	<div class="inside">
        <div class="title"><?=__('Save')?></div>
        <div class="menu-item submit-icon">
            <input type="submit" value="<?=__('Save New Taxonomy','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>
<div class="section">
	<div class="inside">
        <div class="title"><?=__('Custom Taxonomies','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/manage"><?=__('Manage taxonomies','kontrolwp')?></a></div>
            <div class="desc"><?=__('View and manage all your current taxonomies','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<?php $this->renderElement('tax-section-tutorials', array('tax_count' => $tax_count)); ?>