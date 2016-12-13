<?php $current_user = wp_get_current_user(); ?>

<script type="text/javascript">

	var fields_validator = null;

	window.addEvent('domready', function() {
			// Various custom utilities for working with forms
			new kontrol_custom_fields_admin({
				'ajax_url':'<?php echo $controller_url?>' 
			});
			new kontrol_select_add();
			new kontrol_form_hide_show_new();
			new kontrol_select_custom();
			new kontrol_collapse_show();
			new kontrol_tool_tips({'container':'kontrol'});
			 // Validation.
  			fields_validator = new Form.Validator.Inline('cf-add');
			// Makes safe characters possible on fields with 'safe-chars' class
			restrict_safe_characters();
			// Allows you to duplcate a parent item and add it below automatically
			duplicate_parent();
			// Makes the rows sortable
			new sort_rows();
			// Uploads
			new kontrol_file_upload({
				'file_size_max': <?php echo Kontrol_Tools::return_post_max('bytes')?>,
				'app_path': '<?php echo URL_PLUGIN?>'
			});
			
	});
</script>


<!-- New Field Template -->
<div id="new-field-form" class="row edit-fields">
		<?php echo $this->renderElement('cf-field', array(
				'field_types'=>$field_types,
				'rules'=>$rules,
				'field_type'=>$type,
				'data'=>NULL
		)); ?>
</div>


<!-- Main Form -->
<form id="cf-add" action="<?php echo $controller_url?>/save/&noheader=true" method="POST">

<input type="hidden" name="cf-group-id" id="cf-group-id" value="<?php echo isset($cf_group) ? $cf_group->id:''?>" />

<!-- Main Col -->
<div class="main-col inline">
		<!-- Name -->
        <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Group Details','kontrolwp')?>               
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                        	 <div class="label"><?php echo __('Name','kontrolwp')?></div>
                             <div class="field"><input type="text" id="group-name" name="group-name" value="<?php echo isset($cf_group) ? htmlentities($cf_group->name, ENT_QUOTES, 'UTF-8'):''?>" class="required ninety" /></div>
                            <div class="desc"><?php echo __('A name for this set of custom fields','kontrolwp')?>.</div>
                    	</div>
                  </div>
                </div>
            </div>
        </div>
        
        <?php if($type == 'cf') { ?>
        <div class="section cf-group">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Group Rules','kontrolwp')?>                     
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                    	<!-- Group Post Types -->
                        <div class="item" id="group-post-types">
                        	  <div class="label large-bot-margin"><?php echo __('Show group in these post types','kontrolwp')?></div>
                              <div class="fields">
                              	<?php if(isset($post_type_groups)) {
									$index = 0; 
									foreach($post_type_groups as $pt_group) { ?>
                                       <div class="field group-post-type">
                                             <div class="inline twenty">
                                                 <div class="post_type">
                                                 	
                                                    <select style="min-width: 220px" name="group-post-types[]">
                                                         <?php foreach($post_types as $value => $label) { ?>
                                                              <option value="<?php echo esc_attr($value)?>" <?php echo (isset($pt_group->post_type_key) && $pt_group->post_type_key == esc_attr($value)) ? 'selected="selected"':'' ?>><?php echo $label?></option>
                                                         <?php } ?>
                                                    </select>
                                           		</div>
                                      	   </div>
                                     	<div class="inline duplicate-parent  <?php echo !empty($index) ? 'delete' : ''?>"></div>
                                 	 </div>
                                <?php $index++;
								   } 
								} ?>
                             </div>
                            <div class="desc"><?php echo __('Select which post types this custom field group will be active on. You can create very flexible and powerful groups by setting the groups post types here, then changing the fields rules individually','kontrolwp')?>.</div>
                        </div>
                        
                        
                        <div class="item">
                        	<div class="label"><?php echo __('Custom fields default rules','kontrolwp')?></div>
                            <div class="fields">
                                <select name="group-options[rule-defaults]" id="group-rules-select"  style="min-width: 220px">
                                    <option value="normal" <?php echo isset($cf_group->options['rule-defaults']) && $cf_group->options['rule-defaults'] == 'normal' ? 'selected="selected"':''?>><?php echo __('Basic','kontrolwp')?></option>
                                    <option value="custom" <?php echo isset($cf_group->options['rule-defaults']) && $cf_group->options['rule-defaults'] == 'custom' ? 'selected="selected"':''?>><?php echo __('Advanced','kontrolwp')?></option>
                                </select>
                            </div>
                             <div class="desc"><?php echo __("Select the 'basic' option if you just want to show the group depending on just the post type. For more control over the default rules of each field in this group, select the 'advanced' option",'kontrolwp')?>.</div>
                        </div>
                        
                                 
                        <div class="item hide" id="group-default-options">
             				 <div class="label large-bot-margin"><?php echo __('Custom field group default rules','kontrolwp')?> </div>
                             <div class="fieldfield-rules"> <!-- Rules -->
                             	<?php  
									// Remove the post type rules from the group since it's set above
									$post_type_el = $rules['Wordpress'][0];
									$group_rules = $rules;
									unset($group_rules['Wordpress'][0]);
									if(isset($cf_group) && isset($cf_group->rules) && count($cf_group->rules) > 0) {
										$this->renderElement('cf-rules', array('rule_set'=>$cf_group->rules, 'rules'=>$group_rules, 'type'=>'group-rule-set', 'class'=>'')); 
									}else{
										$this->renderElement('cf-rules', array('rule_set'=>NULL, 'rules'=>$group_rules, 'type'=>'group-rule-set', 'class'=>'')); 
									} 
								 ?>
                                 
                             </div>
                            <div class="desc"><?php echo __('These rules determine when a groups fields will appear in the selected post types above. Setting rules for individual fields will override these group defaults','kontrolwp')?>. <div class="inline kontrol-tip" title="<?php echo __('Custom field group default rules','kontrolwp')?>" data-width="450" data-text="<?php echo htmlentities(__('If you wish to hide or show certain groups or fields depending on the value of another custom field, you can do this by selecing the "Custom Field" option under the rules select box. Once you do this, enter the key for the custom field and select the operator you require (equals, does not equal, contains, begins with etc.) and then enter the value. You can create some amazing custom fields configurations using these custom fields rules.','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div></div>
                        </div>
                  </div>
                </div>
            </div>
        </div>
        <?php } ?>
         <?php if($type == 'cs') { ?>
        <!-- Group Settings -->
        <div class="section cs-group">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Group Settings Categories','kontrolwp')?>    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                    	<!-- Group Post Types -->
                        <div class="item" id="group-settings">
                        	  <div class="label large-bot-margin"><?php echo __('Show group in this settings category','kontrolwp')?>.</div>
                              <div class="fields">
                              	<?php if(isset($group_settings_cats_list)) { ?>
					                   <div class="field group-post-type">
                                             <div class="inline twenty">
                                                 <div class="group_settings">
                                                    <select style="min-width: 220px" name="group-settings-cat">
                                                         <?php foreach($group_settings_cats_list as $value => $data) { ?>
                                                              <option value="<?php echo esc_attr($value)?>" <?php echo (isset($post_type_groups[0]->post_type_key) && $post_type_groups[0]->post_type_key == esc_attr($value)) ? 'selected="selected"':'' ?>><?php echo $data['label']?></option>
                                                         <?php } ?>
                                                    </select>
                                           		</div>
                                      	   </div>
                                 	 </div>
                                <?php
								} ?>
                             </div>
                            <div class="desc"><?php echo __('This custom field group will appear in the selected category on the custom settings page','kontrolwp')?>.</div>
                        </div>

                  </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Fields -->
        <?php
        $field_list = isset($cf_group) ? $cf_group->fields : NULL; 
		$this->renderElement('cf-fields', array('title'=>__('Group Custom Fields','kontrolwp'), 'field_list'=>$field_list,'field_types'=>$field_types, 'rules'=>$rules, 'field_type'=>$type)); 
		?>
        <?php if($type == 'cf') { ?>
        <!-- Group Options -->
        <div class="section cf-group">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Group Options','kontrolwp')?>                
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                     	<div class="item">
                            <div class="label"><?php echo __('Position','kontrolwp')?></div>
                             <div class="field">
                             		<select name="group-options[position]" class="rule-match">
                                    	<option value="normal" <?php echo isset($cf_group->options['position']) && $cf_group->options['position'] == 'normal' ? 'selected="selected"':''?>><?php echo __('Standard','kontrolwp')?></option>
                                        <option value="advanced" <?php echo isset($cf_group->options['position']) && $cf_group->options['position'] == 'advanced' ? 'selected="selected"':''?>><?php echo __('Advanced','kontrolwp')?></option>
                                        <option value="side" <?php echo isset($cf_group->options['position']) && $cf_group->options['position'] == 'side' ? 'selected="selected"':''?>><?php echo __('Side','kontrolwp')?></option>
                                   	</select>
                             </div>
                    	</div>
                        <div class="item">
                            <div class="label"><?php echo __('Style','kontrolwp')?></div>
                             <div class="field">
                             		<select name="group-options[style]" class="rule-match">
                                        <option value="meta" <?php echo isset($cf_group->options['style']) && $cf_group->options['style'] == 'meta' ? 'selected="selected"':''?>><?php echo __('In a Metabox','kontrolwp')?></option>
                                        <option value="none" <?php echo isset($cf_group->options['style']) && $cf_group->options['style'] == 'none' ? 'selected="selected"':''?>><?php echo __('No Metabox','kontrolwp')?></option>
                                    </select>
                             </div>
                    	</div>
                  </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
 </div>

<input type="hidden" name="kver" id="kver" value="<?php echo KONTROL_T?>" data-field-count="<?php echo $field_count?>" />

 <!-- Side Col -->
<div class="side-col inline">
	
    
    <?php $this->renderElement('cf-'.$action.'-side-col', array('controller_url' => $controller_url)); ?>
    <?php $this->renderElement($type.'-side-col', array('controller_url' => $controller_url, 'field_count'=>$field_count)); ?>
</div>

</form>