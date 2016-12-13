<?php $current_user = wp_get_current_user(); ?>

<script type="text/javascript">

	window.addEvent('domready', function() {		
			// Mootools for managing the tables
			new kontrol_custom_fields_manage({
				'ajax_url':'<?php echo $controller_url?>' 
			});
			
    		// Makes the rows sortable
			new sort_rows();

	});
	
</script>


<!-- Main Col -->
<div id="group-rows" class="main-col inline">
	
	<div class="section">
            <div class="inside">
                <div class="title"><?php echo __('Custom Fields Groups','kontrolwp')?></div>
            </div>
     </div>
	<?php if(isset($post_types) && count($post_types) > 0) { 
		
		foreach($post_types as $pt_key => $pt) { 
			if(isset($groups[$pt_key])) {
	?>
        <div class="section">
            <div class="inside">
                <div class="title"><?php echo $post_types[$pt_key]?></div>
                <div class="rows sortable">
                    <?php foreach($groups[$pt_key] as $group) { ?>
                    	<div id="<?php echo $group->id?>" data-id="<?php echo $group->id?>" data-group-id="<?php echo $group->group_id?>" sortAction="<?php echo $controller_url?>/updateGroupOrder/<?php echo $group->id?>/" class="row <?php echo empty($group->active) ? 'field-hidden':''?>">
                            <div class="inline tab drag-row"></div>
                            <div title="<?php echo __('Name','kontrolwp')?>" style="width: 25%;  top: 4px;" class="inline cpt-name">
                                <b><a href="<?php echo $controller_url?>/edit/<?php echo $group->group_id?>"><?php echo $group->group_name?></a></b>
                            </div>
                            <div title="<?php echo __('Field Count','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><b><?php echo $group->field_count?></b> <?php echo __('Fields','kontrolwp')?></div>
                            <div title="<?php echo __('Position','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><?php echo isset($group->options['position']) ? ucwords($group->options['position']) : ''?></div>
                            <div title="<?php echo __('Meta Box Type','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><?php echo isset($group->options['style']) && $group->options['style'] == 'meta' ? __('Metabox','kontrolwp') : __('No Metabox','kontrolwp'); ?></div>
                            <div title="<?php echo __('Options','kontrolwp')?>" style="width: 21%; text-align: center;" class="inline cpt-options">
                                <a href="<?php echo $controller_url?>/edit/<?php echo $group->group_id?>"><img class="edit-field" alt="<?php echo __('Edit','kontrolwp')?>" title="<?php echo __('Edit','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-edit.png" style="cursor: pointer"></a> &nbsp;
                                <img class="hide-field" alt="<?php echo __('Hide','kontrolwp')?>" title="<?php echo __('Hide','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
                                <img class="delete-field" alt="<?php echo __('Delete','kontrolwp')?>" title="<?php echo __('Delete','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-delete.png" style="cursor: pointer">
                            </div>
                    	</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 		}
		}
	} ?>
   
</div>

 
<!-- Side Col -->
<div class="side-col inline">
	 <div class="section notification">
     	<div class="inside">
            <div class="title"></div>
            <div class="menu-item alert"><div class="text link"></div></div>
        </div>
    </div>

	 <div class="section">
     	<div class="inside">
            <div class="title"><?php echo __('Field Groups','kontrolwp')?></div>
            <div class="menu-item add">
            	<?php if(KONTROL_T && (10-$field_count) <= 0) { ?>
                	<div class="link"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><?php echo __('Upgrade to the full edition!','kontrolwp')?></a></div>
                    <div class="desc"><?php echo sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d advanced custom fields. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'), 10)?></div>
                <?php }else{ ?>
                    <div class="link"><a href="<?php echo $controller_url?>/add" class="button-primary" style="font-weight: normal;"><?php echo __('Add new field group','kontrolwp')?></a></div>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <?php $this->renderElement('cf-side-col', array('field_count'=>$field_count, 'controller_url'=>$controller_url)); ?>
</div>
 