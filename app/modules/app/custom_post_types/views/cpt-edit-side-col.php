<div class="section">
	<div class="inside">
        <div class="title"><?=__('Save')?></div>
        <div class="menu-item submit-icon">
            <input type="submit" value="<?=__('Edit Post Type','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>
<div class="section">
	<div class="inside">
        <div class="title"><?=__('Custom Post Types','kontrolwp')?></div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/add"><?=__('Add post types','kontrolwp')?></a></div>
            <div class="desc"><?=__('Create a new custom post type','kontrolwp')?>.</div>
        </div>
        <div class="menu-item add">
            <div class="link"><a href="<?=$controller_url?>/manage"><?=__('Manage post types','kontrolwp')?></a></div>
            <div class="desc"><?=__('View and manage all your current post types','kontrolwp')?>.</div>
        </div>
   </div>
</div>

<?php $this->renderElement('cpt-section-tutorials', array('pt_count' => $pt_count)); ?>