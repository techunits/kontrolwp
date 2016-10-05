
<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Save')?></div>
        <div class="menu-item submit-icon">
            <input type="submit" value="<?php echo __('Save New Post Type','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>
<div class="section">
	<div class="inside">
        <div class="title"><?php echo __('Custom Post Types','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?php echo $controller_url?>/manage"><?php echo __('Manage post types','kontrolwp')?></a></div>
            <div class="desc"><?php echo __('View and manage all your current post types','kontrolwp')?>.</div>
        </div>
    </div>
</div>


<?php $this->renderElement('cpt-section-tutorials', array('pt_count' => $pt_count)); ?>