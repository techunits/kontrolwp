<script type="text/javascript">

	window.addEvent('domready', function() {		
		// Makes the rows sortable
		new sort_rows();	
		// Makes the columns sortable + more
		new kontrol_cpt_columns({
				'ajax_url':'<?php echo $controller_url?>' 
		});	
		// Allows you to duplcate a parent item and add it below automatically
		duplicate_parent();
		// Custom Selects
		new kontrol_select_custom();
		
		(function($){
				
			$$('.delete-cpt').addEvent('click', function(e) {
				var check = confirm('<?php echo __('Delete this item?', 'kontrolwp')?>');
					
				if(!check) {
					e.stop();	
				}
			});
		})(document.id);
	});
	
</script>



<!-- Main Col -->
<div class="main-col inline">
<?php if(isset($current_cpts) && count($current_cpts) > 0) { ?>
	<!-- Active CPTs -->
    <div class="section">
        <div class="inside">
            <div class="title"><?php echo __('Custom Post Types','kontrolwp')?></div>
            <div class="rows sortable">
            	<?php
						foreach($current_cpts as $data) { 
						
							$native_tax = array();
							$custom_tax = array();
							// Determine how many native taxonomies apply to this cpt
							 foreach($data['taxonomies'] as $tax) {
								 if($tax->tax_type == 'native') { $native_tax[] = array('id'=>$tax->tax_id, 'key'=>$tax->tax_key, 'name'=>$tax->tax_name); }
								 					       else { $custom_tax[] = array('id'=>$tax->tax_id, 'key'=>$tax->tax_key, 'name'=>$tax->tax_name); }                                                        
                              } 
							  
							 $col_values = $data['cpt']->columns;
							 
							  
							 // Set some default col values 
							 if(!isset($col_values) || !is_array($col_values) || (is_array($col_values) && count($col_values) == 0)) {  
									$col_values  = array('default');
							 }
						
				?>
							<div class="row <?php echo empty($data['cpt']->active) ? 'hidden-cpt':''?>" id="<?php echo $data['cpt']->cpt_key?>" sortAction="<?php echo $controller_url?>/updatesortorder/<?php echo $data['cpt']->id?>/">
                            	<div class="row-data">
                                    <div class="inline tab drag-row"></div>
                                    <div class="inline cpt-name row-data-col" style="width: 42%" title="Name">
                                        <b><a href="<?php echo $controller_url?>/edit/<?php echo $data['cpt']->id?>"><?php echo $data['cpt']->name?></a></b> &nbsp;&nbsp; ( <?php echo $data['cpt']->cpt_key?> )
                                       
                                    </div>
                                    <div class="inline cpt-id row-data-col" style="width: 3%; text-align:center; " title="<?php echo __('Key','kontrolwp')?>">&nbsp;</div>
                                    <div class="inline cpt-updated row-data-col" style="width: 25%; text-align:right;" title="<?php echo __('Last Updated','kontrolwp')?>"><?php echo date("g:i a - F j, Y", $data['cpt']->updated)?></div>
                                    <div class="inline cpt-options row-data-col" style="width: 22%; text-align:right;" title="<?php echo __('Options','kontrolwp')?>">
                                        <a href="<?php echo $controller_url?>/edit/<?php echo $data['cpt']->id?>"><img src="<?php echo URL_IMAGE?>/icon-edit.png" title="<?php echo __('Edit','kontrolwp')?>" alt="<?php echo __('Edit','kontrolwp')?>" /></a> &nbsp;
                                        <a href="<?php echo $controller_url?>/visible/<?php echo $data['cpt']->id?>/<?php echo empty($data['cpt']->active) ? '1':'0'?>&noheader=true"><img src="<?php echo URL_IMAGE?>/icon-visible.png" title="<?php echo __('Hide','kontrolwp')?>" alt="<?php echo __('Hide','kontrolwp')?>" /></a> &nbsp;&nbsp;
                                        <a href="<?php echo $controller_url?>/delete/<?php echo $data['cpt']->id?>&noheader=true"  class="delete-cpt"><img src="<?php echo URL_IMAGE?>/icon-delete.png" title="<?php echo __('Delete','kontrolwp')?>" alt="<?php echo __('Delete','kontrolwp')?>" /></a>
                                    </div>
                                </div>
                                 <?php if(count($native_tax) > 0 || count($custom_tax) > 0) { ?>
                                <div class="row-taxonomies">
                               			<div class="tax-attached">
                                       
                                        	<div style="padding-bottom: 2px"><?php echo __('Taxonomies Attached','kontrolwp')?></div>
                                        	<?php foreach($native_tax as $ntax) { 
                                					$tax_url = $ntax['name'] == 'Categories' ? "http://codex.wordpress.org/Taxonomies#Category" : $tax_url;
													$tax_url = $ntax['name'] == 'Post Tags' ? "http://codex.wordpress.org/Taxonomies#Tag" : $tax_url;
													$tax_url = $ntax['name'] == 'Format' ? "http://codex.wordpress.org/Post_Formats" : $tax_url;
											?>
                                            	   <div class="native tax-name inline"><a href="<?php echo $tax_url?>" target="_blank"><?php echo $ntax['name']?></a></div>                                              
                                            <?php } ?>
                                            <?php foreach($custom_tax as $ntax) { ?>
                                            	   <div class="custom tax-name inline"><a href="<?php echo URL_WP_OPTIONS_PAGE.'&url=taxonomies/edit/'.$ntax['id']?>" target="_blank"><?php echo $ntax['name']?></a></div>                                         
                                            <?php } ?>
                                        
                                       </div>
                                </div>
                                <?php } ?>
                                <div class="row-cols" data-cpt-id="<?php echo $data['cpt']->id?>">
                                	<div style="padding-bottom: 2px"><?php echo __('Post List Display Columns','kontrolwp')?></div>
                                    <div class="inline save-cols" title="<?php echo __('Save Display Columns','kontrolwp')?>"></div>
                               		<div class="inline row-col-container sortable">
                                    	<?php 																			
										$count = 0;
										foreach($col_values as $col) { 
											$this->renderElement('cpt-column-select', array('col'=>$col, 'count'=>$count, 'pt_key'=> $data['cpt']->cpt_key)); 
										    $count++;
										} ?>
                                    </div>
                                </div>
								
							</div>
					 <?php } ?>
				
            </div>
        </div>
    </div>
    
    <?php } ?>
    
    <!-- Native CPTs -->
    <div class="section">
        <div class="inside">
            <div class="title"><?php echo __('Native Post Types','kontrolwp')?></div>
            <div class="rows">
            	<?php
				  if(isset($native_pts) && count($native_pts) > 0) {

					foreach($native_pts as $data) { 
						
							$native_tax = array();
							$custom_tax = array();
							// Determine how many native taxonomies apply to this cpt
							 foreach($data['taxonomies'] as $tax) {
								 if(!empty($tax->_builtin)) { $native_tax[] = array('id'=>'', 'key'=>$tax->name, 'name'=>$tax->label); }                                          
	                         } 
							 foreach($data['custom_taxonomies'] as $tax) {
								 $custom_tax[] = array('id'=>$tax->tax_id, 'key'=>$tax->tax_key, 'name'=>$tax->tax_name);                                           
                              } 
							  
							 $col_values = $data['cpt']->columns;
							 
							  
							 // Set some default col values 
							 if(!isset($col_values) || !is_array($col_values) || (is_array($col_values) && count($col_values) == 0)) {  
									$col_values  = array('default');
							 }
				?>
							<div class="row">
                            	<div class="row-data">
                                    <div class="inline cpt-name" style="width: 42%; margin-left: 36px; margin-bottom: 10px;" title="Name">
                                        <b><?php echo $data['cpt']->name?></b> &nbsp;&nbsp; ( <?php echo $data['cpt']->cpt_key?> )
                                    </div>
                                    <div class="inline cpt-id" style="width: 3%; text-align:center; top: 12px;" title="<?php echo __('Key','kontrolwp')?>">&nbsp;</div>
                                    <div class="inline cpt-updated" style="width: 25%; text-align:right; top: 12px;" title="<?php echo __('Last Updated','kontrolwp')?>">&nbsp;</div>
                                    <div class="inline cpt-options" style="width: 22%; text-align:right; top: 12px;" title="<?php echo __('Options','kontrolwp')?>">&nbsp;</div>
								</div>
                                <?php if(count($native_tax) > 0 || count($custom_tax) > 0) { ?>
                                <div class="row-taxonomies">
                               			<div class="tax-attached">
                                       
                                        	<div style="padding-bottom: 2px"><?php echo __('Taxonomies Attached','kontrolwp')?></div>
                                        	<?php foreach($native_tax as $ntax) { 
													$tax_url = $ntax['name'] == __('Categories','kontrolwp') ? "http://codex.wordpress.org/Taxonomies#Category" : $tax_url;
													$tax_url = $ntax['name'] == __('Tags','kontrolwp') ? "http://codex.wordpress.org/Taxonomies#Tag" : $tax_url;
													$tax_url = $ntax['name'] == __('Format','kontrolwp') ? "http://codex.wordpress.org/Post_Formats" : $tax_url;
											?>
                                            	   <div class="native tax-name inline"><a href="<?php echo $tax_url?>" target="_blank"><?php echo $ntax['name']?></a></div>                                         
                                            <?php } ?>
                                            <?php foreach($custom_tax as $ntax) { ?>
                                            	   <div class="custom tax-name inline"><a href="<?php echo URL_WP_OPTIONS_PAGE.'&url=taxonomies/edit/'.$ntax['id']?>" target="_blank"><?php echo $ntax['name']?></a></div>                                         
                                            <?php } ?>
                                        
                                       </div>
                                </div>
                                <?php } ?>
                                <div class="row-cols" data-cpt-id="<?php echo $data['cpt']->id?>">
                                	<div style="padding-bottom: 2px"><?php echo __('Post List Display Columns','kontrolwp')?></div>
                                    <div class="inline save-cols" title="<?php echo __('Save Display Columns','kontrolwp')?>"></div>
                               		<div class="inline row-col-container sortable">
                                    	<?php 
										$count = 0;
										foreach($col_values as $col) { 
											$this->renderElement('cpt-column-select', array('col'=>$col, 'count'=>$count, 'pt_key'=> $data['cpt']->cpt_key)); 
										    $count++;
										} ?>
                                    </div>
                                </div>
							</div>
                   <?php } 
				 } ?>
				
            </div>
        </div>
    </div>
    
 
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
            <div class="title"><?php echo __('Custom Post Types','kontrolwp')?></div>
            <div class="menu-item add">
            <?php if(KONTROL_T && (2-$pt_count) <= 0) { ?>
            	<div class="link"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><?php echo __('Upgrade to the full edition!','kontrolwp')?></a></div>
                <div class="desc"><?php echo sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d custom post types. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'),2)?></div>
            <?php }else { ?>
           		<div class="link"><a href="<?php echo $controller_url?>/add" class="button-primary" style="font-weight: normal;"><?php echo __('Add new custom post type','kontrolwp')?></a></div>
            <?php } ?>
            </div>
        </div>
    </div>
    <?php $this->renderElement('cpt-section-tutorials', array('pt_count' => $pt_count)); ?>
</div>
 