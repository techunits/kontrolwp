<?
global $current_user;
get_currentuserinfo();
?>

<div class="icon32" id="icon-options-general"><br></div><h2><?=$page_title?> - <?=$categories[$cat]['data']['label']?></h2>

<? if(isset($categories[$cat]['data']['desc']) && !empty($categories[$cat]['data']['desc'])) { ?>
<div class="settings-desc">
	<?=nl2br($categories[$cat]['data']['desc'])?>
</div>
<? } ?>

<form id="post" action="<?=URL_WP_SETTINGS_PAGE.'&cat='.$cat?>&noheader=true" method="POST" name="post">

<div id="post-body" class="metabox-holder columns-2">

<div id="post-body-content">
	<div id="poststuff" class="cs-col-1">
 	<?  if(isset($categories[$cat]['groups']) && is_array($categories[$cat]['groups'])) {  ?>
        <div class="settings-fields">
            <?	if(isset($categories[$cat]['groups']) && count($categories[$cat]['groups']) > 0) { 
                    foreach($categories[$cat]['groups'] as $group) { ?>
                        <div class="postbox-container" id="postbox-container-2">
                            <div class="meta-box-sortables ui-sortable" id="normal-sortables">
                                <div class="postbox kontrol-metabox" style="display: block;">
                                <div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?=$group->group_name?></span></h3>
                                <div class="inside">
                                    <?	if(isset($group->fields) && count($group->fields) > 0) {  
                                            foreach($group->fields as $field) { 
											
												$sub_fields = NULL;
											
												// If it's a repeater field, get it's sub fields
												if($field->field_type == 'repeatable') {
													// Get all the fields in the group
													$sel = new CustomFieldsModel();
													$sel->group_id = $group->group_id;
													$sel->parent_id = $field->id;	
													$sel->active = 1;
													$sub_fields = $sel->select();
												}
				
                                                 $field->settings = unserialize($field->settings);
                                                 $field->validation = unserialize($field->validation);
                                                 // Check it has validation first
                                                 if(is_array($field->validation)) {
                                                    $field_validation = implode(' ',$field->validation);	
                                                 }
                                                 // Get the field html
                                                 ob_start();
                                                 $this->renderElement('fields/meta/'.$field->field_type, array('current_user'=>$current_user, 'field'=>$field, 'field_validation'=>$field_validation, 'field_value'=>get_option('kontrol_option_'.$field->field_key, ''), 'sub_fields'=>$sub_fields, 'post' => NULL));
                                                 $field_html = ob_get_contents();
                                                 ob_end_clean();
                                                 // Add it to the field container
                                                 $this->renderElement('fields/meta/layout', array('layoutContent'=>$field_html, 'field'=>$field));
                                                 
                                            } 
                                        } ?>
                                </div>
                                </div>
                             </div>
                        </div>
                   <? } ?>
            <? } ?>
           </div>
           <?
           } ?>
       
       </div>

       
       <!-- Side Col -->
       <div class="cs-col-2">
       			<div class="postbox " id="submitdiv">
                    <div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?=__('Settings','kontrolwp')?> - <?=$categories[$cat]['data']['label']?></span></h3>
                    <div class="inside">
                    <div id="submitpost" class="submitbox">
                    <div class="misc-pub-section curtime">
                        <span id="timestamp">
                        <?=__('Last Updated','kontrolwp')?> <b><?=(isset($updated_times[$cat]) && !empty($updated_times[$cat])) ? date('jS, F Y', $updated_times[$cat]):__('Never','kontrolwp') ?></b></span>
                    </div>
                    </div>
                    <div id="major-publishing-actions" style="margin-top: 5px;">             
                        <div id="publishing-action">
                        <span class="spinner" style="display: none;"></span>
                                <input type="submit" value="<?=__('Save Settings','kontrolwp')?>" accesskey="p" id="publish" class="button button-primary button-large" name="save">
                        </div>
                    <div class="clear"></div>
                    </div>
                    </div>
                </div>
              
         	</div>
       </div>
</div>


<input type="hidden" name="save_fields" value="TRUE" />
<input type="hidden" name="current_cat" value="<?=$cat?>" />
</form>