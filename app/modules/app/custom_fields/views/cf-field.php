   
    <div class="inline tab drag-row"></div>
    <div title="Name" style="width: 19%;  top: 4px;" class="inline cpt-name">
        <b class="field-name edit-field"><?php echo isset($data) ? $data->name : __('New Field','kontrolwp');?></b>
    </div>
    <div title="Key" style="width: 19%; top: 4px; font-weight: bold;" class="inline field-key"><?php echo isset($data) ? $data->field_key : __('new-field','kontrolwp')?></div>
    <div title="Last Updated" style="width: 17%; top: 4px;" class="inline cpt-updated"><?php echo isset($data) ? $data->field_type->name : __('Text','kontrolwp')?></div>
    <div title="Required or Optional" style="width: 17%; top: 4px;" class="inline field-required"><?php echo (isset($data->validation[0]) && $data->validation[0] == 'required') ? __('Required','kontrolwp'):__('Optional','kontrolwp') ?></div>
    <div title="Options" style="width: 18%; text-align: center;" class="inline cpt-options">
        <img class="edit-field" alt="<?php echo __('Edit','kontrolwp')?>" title="<?php echo __('Edit','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-edit.png" style="cursor: pointer"> &nbsp;
        <img class="clone-field" alt="<?php echo __('Clone Field','kontrolwp')?>" title="<?php echo __('Clone Field','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-clone.png" style="cursor: pointer"> &nbsp;
        <img class="hide-field" alt="<?php echo __('Hide','kontrolwp')?>" title="<?php echo __('Hide this custom field','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
        <img class="delete-field" alt="<?php echo __('Delete','kontrolwp')?>" title="<?php echo __('Delete','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-delete.png" style="cursor: pointer">
    </div>
    
    <?php $fkey = isset($data) ? $data->id : 'key_id'; ?>
    
    <div class="row-form section-content">
        <input type="hidden" name="field[<?php echo $fkey?>][id]" class="field-id" value="<?php echo isset($data) ? $data->id : '0';?>" />
        <input type="hidden" name="field[<?php echo $fkey?>][parent_id]" class="field-parent-id" value="<?php echo isset($data) ? $data->parent_id : '0';?>" />
        <input type="hidden" name="field[<?php echo $fkey?>][repeatable]" class="field-repeatable" value="<?php echo isset($data) && !empty($data->parent_id) ? 1 : 0;?>" />
        <input type="hidden" name="field[<?php echo $fkey?>][sort-order]" value="<?php echo isset($data) ? $data->sort_order : '0';?>" />
        <input type="hidden" name="field[<?php echo $fkey?>][active]" class="field-active" value="<?php echo isset($data) ? $data->active : '1';?>" />
        <div class="form-style">
          	 <!-- Field Properties -->
             <div class="item">
                <div class="label"><?php echo __('Field Name','kontrolwp')?><span class="req-ast">*</span></div>
                <div class="field"><input type="text" id="name" name="field[<?php echo $fkey?>][name]" value="<?php echo isset($data) ? htmlentities($data->name, ENT_QUOTES, 'UTF-8') : '';?>" class="required ninety form-field-name" /></div>
                <div class="desc"><?php echo __('The name for your custom field. It was also appear as the label','kontrolwp')?>.</div>
            </div>
            
            <div class="item">
                <div class="label"><?php echo __('Field Key','kontrolwp')?><span class="req-ast">*</span></div>
                <div class="field"><input type="text" id="key" name="field[<?php echo $fkey?>][key]"  maxlength="20" value="<?php echo isset($data) ? $data->field_key : '';?>" class="<?php echo isset($data) ? 'edited' : '';?> required maxLength:20 ninety safe-chars form-field-key" /> <div class="inline kontrol-tip" title="Field Key Quick Copy" data-text="<?php echo htmlentities('When viewing this custom field on a post, you can quickly access this field key by <b>double clicking</b> your mouse on the field title.<p>This is a developer shortcut that allows you to quickly access the field key without needing to come back here.</p>', ENT_QUOTES, 'UTF-8')?>"></div></div>
                <div class="desc"><?php echo __('Max. 20 characters, cannot contain capital letters or spaces','kontrolwp')?>.</div>
            </div>
            
            <div class="item">
                <div class="label"><?php echo __('Field Required','kontrolwp')?><span class="req-ast">*</span></div>
                <div class="field">
                      <select name="field[<?php echo $fkey?>][validation][]" class="sixty form-field-required">
                        <option value="cf-not-required" <?php echo (isset($data->validation[0]) && $data->validation[0] == 'cf-not-required') ? 'selected="selected"':'' ?>><?php echo __('No')?></option>
                        <option value="required" <?php echo (isset($data->validation[0]) && $data->validation[0] == 'required') ? 'selected="selected"':'' ?>><?php echo __('Yes')?></option>
                      </select>  
                </div>
                <div class="desc"><?php echo __("If this field is required, select 'Yes' and the user will be required to complete it",'kontrolwp')?>.</div>
            </div>
            
            <div class="item">
                <div class="label"><?php echo __('Field Validation','kontrolwp')?><span class="req-ast">*</span></div>
                <!-- Validation -->
                <div>
                    <?php if(isset($data) && count($data->validation) > 1) { 
                        for($i=1; $i < count($data->validation); $i++) {
                            $this->renderElement('cf-validation', array('data'=>$data->validation[$i], 'index'=>$i, 'fkey'=>$fkey)); 
                        }
                    }else{
                        $this->renderElement('cf-validation', array('data'=>NULL, 'fkey'=>$fkey)); 
                    } ?>
                </div>
                <div class="desc"><?php echo __('Add multiple types of validation to your field if required. Use the plus sign at the end of the dropdown to add more','kontrolwp')?>.</div>
            </div>
            
            <div class="item">
                <div class="label field-type"><?php echo __('Field Type','kontrolwp')?><span class="req-ast">*</span></div>
                <div class="field">
                      <select name="field[<?php echo $fkey?>][type]" class="field-type-dd sixty">
                        <?php foreach($field_types as $type) { 
     
								$default_select = NULL;
								if(!isset($data) && $type->cf_key == 'text') {
									$default_select = TRUE;
								}
								
							// For i18n purposes, we need to specify the field names here so they can be converted - these do nothing but provide the translator with a list of the field type names to translate
							$i18n = __('Checkbox','kontrolwp');
							$i18n = __('Colour Picker','kontrolwp');
							$i18n = __('Date Picker','kontrolwp');
							$i18n = __('File','kontrolwp');
							$i18n = __('Image','kontrolwp');
							$i18n = __('Page Link / Object','kontrolwp');
							$i18n = __('Radio Button','kontrolwp');
							$i18n = __('Repeatable','kontrolwp');
							$i18n = __('Select','kontrolwp');
							$i18n = __('Text','kontrolwp');
							$i18n = __('Text Area','kontrolwp');
							$i18n = __('True / False','kontrolwp');
							$i18n = __('Wysiwyg Editor','kontrolwp');
                        ?>
                            <option class="<?php echo ($type->cf_key == 'repeatable') ? 'repeatable-remove':''?>" value="<?php echo $type->cf_key?>" <?php echo ((isset($data->field_type->cf_key) && $data->field_type->cf_key == $type->cf_key) || $default_select == TRUE) ? 'selected="selected"':'' ?>><?php echo __($type->name,'kontrolwp')?></option>
                        <?php } ?>
                      </select>
                </div>
                <div class="desc"><?php echo __('The type of field that will be shown. Some fields have special properties that can be customised when selected from the dropdown','kontrolwp')?>.</div>
            </div>
            
            <div class="settings">
                 <?php 		 
                    $field_types_repeatable = $field_types;
                    foreach($field_types as $type) { 
                        $settings_data = isset($data) ? $data->settings : array();
                        $this->renderElement('fields/settings/'.$type->cf_key, array('type'=>$type->cf_key, 'data'=>$settings_data, 'field_data'=>$data, 'fkey'=>$fkey, 'rules'=>$rules, 'field_types'=>$field_types, 'field_type'=>$field_type));
                 } ?>
            </div>
           
    		 <!-- Field Instructions -->
             <div class="item">
                <div class="label"><?php echo __('Instructions','kontrolwp')?></div>
                <div class="field">
                      <textarea name="field[<?php echo $fkey?>][instructions]" class="ninety"><?php echo (isset($data) && !empty($data->instructions)) ? $data->instructions:'' ?></textarea>
                </div>
                <div class="desc"><?php echo __('Enter some instructions on how to use the field. Instructions will appear below the field like this one','kontrolwp')?>.</div>
            </div>

            <div class="item">
                <div class="label"><?php echo __('Tool Tip','kontrolwp')?></div>
                <div class="field">
                	<select name="field[<?php echo $fkey?>][settings][tip][enabled]" data-hide-show-parent=".form-style" class="sixty hide-show">
                        <option value="false" data-hide-classes="settings-tip" <?php echo isset($data->settings['tip']['enabled']) && $data->settings['tip']['enabled'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="true" data-show-classes="settings-tip" <?php echo isset($data->settings['tip']['enabled']) && $data->settings['tip']['enabled'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                    </select> 
                     <div class="inline kontrol-tip" title="Field Tool Tips" data-text="<?php echo htmlentities('<b>This is a tool tip!</b> If you add a tool tip for your field, it will appear next to your field just like this one and will be activated when the user puts their mouse over the icon. You can include HTML.', ENT_QUOTES, 'UTF-8')?>"></div>
                </div>
                <div class="desc"><?php echo __('Add a tool tip for your field if you need to include more detailed instructions, examples or more general information','kontrolwp')?>.</div>
            </div>
            <div class="settings-tip">
                <div class="item">
                    <div class="label"><?php echo __('Tip Title','kontrolwp')?></div>
                    <div class="field">
                        <input type="text" id="name" name="field[<?php echo $fkey?>][settings][tip][title]" value="<?php echo isset($data->settings['tip']['title']) ? htmlentities($data->settings['tip']['title'], ENT_QUOTES, 'UTF-8') : '';?>" class="required sixty" />
                    </div>
                    <div class="desc"><?php echo __('Add a title for the tool tip that will appear next to this field','kontrolwp')?>.</div>
                </div>
                <div class="item">
                    <div class="label"><?php echo __('Tip Max Width','kontrolwp')?></div>
                    <div class="field">
                        <input type="text" id="name" name="field[<?php echo $fkey?>][settings][tip][width]" value="<?php echo isset($data->settings['tip']['width']) ? htmlentities($data->settings['tip']['width'], ENT_QUOTES, 'UTF-8') : '400';?>" class="validate-integer sixty" />
                    </div>
                    <div class="desc"><?php echo __('Enter in a number for the maximum width of this tool tip in pixels. Default is 400','kontrolwp')?>.</div>
                </div>
                <div class="item">
                    <div class="label"><?php echo __('Tip Text','kontrolwp')?></div>
                    <div class="field">
                        <textarea name="field[<?php echo $fkey?>][settings][tip][text]" class="required ninety"><?php echo (isset($data->settings['tip']['text']) && !empty($data->settings['tip']['text'])) ? $data->settings['tip']['text']:'' ?></textarea>
                    </div>
                    <div class="desc"><?php echo __('Enter in the main text for this tool tip','kontrolwp')?>.</div>
                </div>
            </div>
            
             <?php if($field_type == 'cf') { ?>
             <!-- Field Rules -->
                 <div class="item field-rules repeatable-remove cf-group">
                    <div class="label"><?php echo __('Rules','kontrolwp')?></div>
                    <div class="rules-type">
                        <select name="field[<?php echo $fkey?>][rules-type]" class="rules-type-select"  style="width: 150px">
                            <option value="group" <?php echo (isset($data->rule_type) && $data->rule_type == 'group') ? 'selected="selected"':'' ?>><?php echo __('Use Groups Rules','kontrolwp')?></option>
                            <option value="custom" <?php echo (isset($data->rule_type) && $data->rule_type == 'custom') ? 'selected="selected"':'' ?>><?php echo __('Custom Rules','kontrolwp')?></option>
                        </select>
                    </div>
                    <?php if(isset($data) && count($data->rules) > 0) { 
                        $this->renderElement('cf-rules', array('rule_set'=>$data->rules, 'rules'=>$rules, 'type'=>'field['.$fkey.']', 'class'=>'')); 
                    }else{
                        $this->renderElement('cf-rules', array('rule_set'=>NULL, 'rules'=>$rules, 'type'=>'field['.$fkey.']', 'class'=>'hide')); 
                    } ?>   
                    <div class="desc"><?php echo __('You can set individual rules for fields or just use the default which is the groups rules. These rules determine when the field will appear','kontrolwp')?>.</div>
                </div>
             <?php } ?>
                
            <div class="item">
                <input type="button" value="<?php echo __('Save Custom Field','kontrolwp')?>" class="save-field button-primary" /> &nbsp;&nbsp; <div class="ajax-loader inline hide"></div>
            </div>
        </div>
    </div>