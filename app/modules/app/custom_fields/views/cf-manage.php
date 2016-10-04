<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">

	window.addEvent('domready', function() {		
			// Mootools for managing the tables
			new kontrol_custom_fields_manage({
				'ajax_url':'<?=$controller_url?>' 
			});
			
    		// Makes the rows sortable
			new sort_rows();

	});
	
</script>


<!-- Main Col -->
<div id="group-rows" class="main-col inline">
	
	<div class="section">
            <div class="inside">
                <div class="title"><?=__('Custom Fields Groups','kontrolwp')?></div>
            </div>
     </div>
	<? if(isset($post_types) && count($post_types) > 0) { 
		
		foreach($post_types as $pt_key => $pt) { 
			if(isset($groups[$pt_key])) {
	?>
        <div class="section">
            <div class="inside">
                <div class="title"><?=$post_types[$pt_key]?></div>
                <div class="rows sortable">
                    <? foreach($groups[$pt_key] as $group) { ?>
                    	<div id="<?=$group->id?>" data-id="<?=$group->id?>" data-group-id="<?=$group->group_id?>" sortAction="<?=$controller_url?>/updateGroupOrder/<?=$group->id?>/" class="row <?=empty($group->active) ? 'field-hidden':''?>">
                            <div class="inline tab drag-row"></div>
                            <div title="<?=__('Name','kontrolwp')?>" style="width: 25%;  top: 4px;" class="inline cpt-name">
                                <b><a href="<?=$controller_url?>/edit/<?=$group->group_id?>"><?=$group->group_name?></a></b>
                            </div>
                            <div title="<?=__('Field Count','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><b><?=$group->field_count?></b> <?=__('Fields','kontrolwp')?></div>
                            <div title="<?=__('Position','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><?=isset($group->options['position']) ? ucwords($group->options['position']) : ''?></div>
                            <div title="<?=__('Meta Box Type','kontrolwp')?>" style="width: 15%; top: 4px;" class="inline"><?=isset($group->options['style']) && $group->options['style'] == 'meta' ? __('Metabox','kontrolwp') : __('No Metabox','kontrolwp'); ?></div>
                            <div title="<?=__('Options','kontrolwp')?>" style="width: 21%; text-align: center;" class="inline cpt-options">
                                <a href="<?=$controller_url?>/edit/<?=$group->group_id?>"><img class="edit-field" alt="<?=__('Edit','kontrolwp')?>" title="<?=__('Edit','kontrolwp')?>" src="<?=URL_IMAGE?>icon-edit.png" style="cursor: pointer"></a> &nbsp;
                                <img class="hide-field" alt="<?=__('Hide','kontrolwp')?>" title="<?=__('Hide','kontrolwp')?>" src="<?=URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
                                <img class="delete-field" alt="<?=__('Delete','kontrolwp')?>" title="<?=__('Delete','kontrolwp')?>" src="<?=URL_IMAGE?>icon-delete.png" style="cursor: pointer">
                            </div>
                    	</div>
                    <? } ?>
                </div>
            </div>
        </div>
    <? 		}
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
            <div class="title"><?=__('Field Groups','kontrolwp')?></div>
            <div class="menu-item add">
            	<? if(KONTROL_T && (10-$field_count) <= 0) { ?>
                	<div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=__('Upgrade to the full edition!','kontrolwp')?></a></div>
                    <div class="desc"><?=sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d advanced custom fields. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'), 10)?></div>
                <? }else{ ?>
                    <div class="link"><a href="<?=$controller_url?>/add" class="button-primary" style="font-weight: normal;"><?=__('Add new field group','kontrolwp')?></a></div>
                <? } ?>
            </div>
        </div>
    </div>
    
    <?php $this->renderElement('cf-side-col', array('field_count'=>$field_count, 'controller_url'=>$controller_url)); ?>
</div>
 