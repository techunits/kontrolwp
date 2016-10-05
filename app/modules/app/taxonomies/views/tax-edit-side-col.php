
<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Save')?></div>
        <div class="menu-item submit-icon">
            <input type="submit" value="<?php echo __('Edit Taxonomy','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>
<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Custom Taxonomies','kontrolwp')?></div>
        <div class="menu-item add">
                <div class="link"><a href="<?php echo $controller_url?>/add"><?php echo __('Add new taxonomy','kontrolwp')?></a></div>
                <div class="desc"><?php echo __('Create a new custom taxonomy','kontrolwp')?>.</div>
            </div>
        <div class="menu-item add">
            <div class="link"><a href="<?php echo $controller_url?>/manage"><?php echo __('Manage taxonomies','kontrolwp')?></a></div>
            <div class="desc"><?php echo __('View and manage all your current taxonomies','kontrolwp')?>.</div>
        </div>
    </div>
</div>

<?php $this->renderElement('tax-section-tutorials', array('tax_count' => $tax_count)); ?>