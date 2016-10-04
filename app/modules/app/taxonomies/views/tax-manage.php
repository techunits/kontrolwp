<script type="text/javascript">

	window.addEvent('domready', function() {		
		// Makes the rows sortable
		new sort_rows();		
		
		(function($){
						
			$$('.delete-tax').addEvent('click', function(e) {
				var check = confirm('<?=__('Delete this item?', 'kontrolwp')?>');
					
				if(!check) {
					e.stop();	
				}
			});
		})(document.id);
	});
	
</script>


<!-- Main Col -->
<div class="main-col inline">
<? if(count($tax_custom) > 0) { ?>
	<!-- Active taxs -->
    <div class="section">
        <div class="inside">
            <div class="title"><?=__('Custom Taxonomies', 'kontrolwp')?></div>
            <div class="rows sortable">
            	<?					
						foreach($tax_custom as $data) { 
						
							$native_pt = array();
							$custom_pt = array();
							// Determine how many native taxonomies apply to this cpt
							 foreach($data['post_types'] as $pt) {
								 if($pt->cpt_type == 'native') { $native_pt[] = array('id'=>'', 'key'=>$pt->cpt_key, 'name'=>$pt->cpt_name); }
								 					      else { $custom_pt[] = array('id'=>$pt->cpt_id, 'key'=>$pt->cpt_key, 'name'=>$pt->cpt_name); }                                                        
                              } 
				
						
				?>
							<div class="row <?=empty($data['tax']->active) ? 'hidden-tax':''?>" id="<?=$data['tax']->tax_key?>" sortAction="<?=$controller_url?>/updatesortorder/<?=$data['tax']->id?>/">
                            	<div class="row-data">
                                    <div class="inline tab drag-row"></div>
                                    <div class="inline tax-name" style="width: 40%" title="Name">
                                        <b><a href="<?=$controller_url?>/edit/<?=$data['tax']->id?>"><?=$data['tax']->name?></a></b> &nbsp;&nbsp; ( <?=$data['tax']->tax_key?> )
                                    </div>
                                    <div class="inline tax-id" style="width: 5%; text-align:center; top: 12px;" title="<?=__('Key','kontrolwp')?>"></div>
                                    <div class="inline tax-updated" style="width: 22%; text-align:right; top: 12px;" title="<?=__('Last Updated','kontrolwp')?>"><?=date("g:i a - F j, Y", $data['tax']->updated)?></div>
                                    <div class="inline tax-options" style="width: 25%; text-align:right; top: 10px;" title="<?=__('Options','kontrolwp')?>">
                                        <a href="<?=$controller_url?>/edit/<?=$data['tax']->id?>"><img src="<?=URL_IMAGE?>/icon-edit.png" title="<?=__('Edit','kontrolwp')?>" alt="<?=__('Edit','kontrolwp')?>" /></a> &nbsp;
                                        <a href="<?=$controller_url?>/visible/<?=$data['tax']->id?>/<?=empty($data['tax']->active) ? '1':'0'?>&noheader=true"><img src="<?=URL_IMAGE?>/icon-visible.png" title="<?=__('Hide','kontrolwp')?>" alt="<?=__('Hide','kontrolwp')?>" /></a> &nbsp;&nbsp;
                                        <a href="<?=$controller_url?>/delete/<?=$data['tax']->id?>&noheader=true"  class="delete-tax"><img src="<?=URL_IMAGE?>/icon-delete.png" title="<?=__('Delete','kontrolwp')?>" alt="<?=__('Delete','kontrolwp')?>" /></a>
                                    </div>
                                </div>
								<? if(count($native_pt) > 0 || count($custom_pt) > 0) { ?>
                                <div class="row-pts">
                               			<div class="pts-attached">
                                        	<div style="padding-bottom: 2px"><?=__('Post Types Attached','kontrolwp')?></div>
                                        	<? foreach($native_pt as $pt) { ?>
                                            	   <div class="native pt-name inline"><?=$pt['name']?></div>                                              
                                            <? } ?>
                                            <? foreach($custom_pt as $pt) { ?>
                                            	   <div class="custom pt-name inline"><a href="<?=URL_WP_OPTIONS_PAGE.'&url=custom_post_types/edit/'.$pt['id']?>" target="_blank"><?=$pt['name']?></a></div>                                         
                                            <? } ?>
                                       </div>
                                </div>
                                <? } ?>
							</div>
					 <? } ?>
				
            </div>
        </div>
    </div>
    
    <? } ?>
    
    <? if(count($tax_native) > 0) { ?>
    <!-- Hidden taxs -->
    <div class="section">
        <div class="inside">
            <div class="title"><?=__('Native Taxonomies','kontrolwp')?></div>
            <div class="rows">
            	
					<? if(count($tax_native) > 0) {
						foreach($tax_native as $data) { 
						
							$native_pt = array();
							$custom_pt = array();
							$custom_pt_list = array();
							// Determine how many native taxonomies apply to this cpt
							foreach($data['post_types'] as $pt) {
								 if($pt->cpt_type == 'custom') { 
								 	$custom_pt[] = array('id'=>$pt->cpt_id, 'key'=>$pt->cpt_key, 'name'=>$pt->cpt_name); 
									$custom_pt_list[] = $pt->cpt_key;
								}                                                    
                            } 
							// Get the native taxonomies post types now
							if(isset($data['tax']->obj->object_type) && is_array($data['tax']->obj->object_type)) {
								if($data['tax']->obj->_builtin == TRUE) {
									foreach($data['tax']->obj->object_type as $pt_key) {
										$pt_obj = get_post_type_object($pt_key);
										// Don't add pts that are already in the custom list
										if(!in_array($pt_key, $custom_pt_list)) {
											$native_pt[] = array('id'=>'', 'key'=>$pt_key, 'name'=>$pt_obj->label);
										}
									}
								}
							}
						
				?>
							<div class="row <?=empty($data['tax']->active) ? 'hidden-tax':''?>" id="<?=$data['tax']->tax_key?>" sortAction="<?=$controller_url?>/updatesortorder/<?=$data['tax']->id?>/">
                            	<div class="row-data">
                                    <div class="inline tax-name" style="width: 40%; margin-left: 36px;" title="Name">
                                        <b><a href="<?=$controller_url?>/edit/<?=$data['tax']->id?>"><?=$data['tax']->name?></a></b> &nbsp;&nbsp; ( <?=$data['tax']->tax_key?> )
                                    </div>
                                    <div class="inline tax-id" style="width: 5%; text-align:center; top: 12px;" title="<?=__('Key','kontrolwp')?>"></div>
                                    <div class="inline tax-updated" style="width: 22%; text-align:right; top: 12px;" title="<?=__('Last Updated','kontrolwp')?>"></div>
                                    <div class="inline tax-options" style="width: 25%; text-align:right; top: 10px;" title="<?=__('Options','kontrolwp')?>"></div>
                                </div>
								<? if(count($native_pt) > 0 || count($custom_pt) > 0) { ?>
                                <div class="row-pts">
                               			<div class="pts-attached">
                                        	<div style="padding-bottom: 2px"><?=__('Post Types Attached','kontrolwp')?></div>
                                        	<? foreach($native_pt as $pt) { ?>
                                            	   <div class="native pt-name inline"><?=$pt['name']?></div>                                              
                                            <? } ?>
                                            <? foreach($custom_pt as $pt) { ?>
                                            	   <div class="custom pt-name inline"><a href="<?=URL_WP_OPTIONS_PAGE.'&url=custom_post_types/edit/'.$pt['id']?>" target="_blank"><?=$pt['name']?></a></div>                                         
                                            <? } ?>
                                       </div>
                                </div>
                                <? } ?>
							</div>
					 <? } 
				}else{ ?>
						<div class="row"><b>No native taxonomies found... that's actually really strange... what did you do??</b></div>					
				<? }?>	
				
            </div>
        </div>
    </div>
    <? } ?>
    
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
            <div class="title"><?=__('Custom Taxonomies','kontrolwp')?></div>
            <div class="menu-item add">
            	<? if(KONTROL_T && (4-$tax_count) <= 0) { ?>
            	<div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=__('Upgrade to the full edition!','kontrolwp')?></a></div>
                <div class="desc"><?=sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d custom taxonomies. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'),4)?></div>
           		 <? }else { ?>
                <div class="link"><a href="<?=$controller_url?>/add" class="button-primary" style="font-weight: normal;"><?=__('Add new custom taxonomy','kontrolwp')?></a></div>
                <? } ?>
            </div>
        </div>
    </div>
    <?php $this->renderElement('tax-section-tutorials', array('tax_count' => $tax_count)); ?>
</div>
 