<?php $current_user = wp_get_current_user(); ?>

<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('API Key','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][api_key]" value="<?php echo isset($data['gmaps']['api_key']) ? $data['gmaps']['api_key']:'' ?>" class="sixty required" /> 
            </div>
        </div>
        <div class="desc"><?php echo __('All Google Maps require an API key from Google. <a href="https://developers.google.com/maps/documentation/javascript/tutorial" target="_blank">Click here to learn how to obtain one</a>','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Map Height','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][height]" value="<?php echo isset($data['gmaps']['height']) ? $data['gmaps']['height']:'350' ?>" class="thirty required validate-integer" /> 
            </div>
        </div>
        <div class="desc"><?php echo __('Enter the desired height in pixels for the map. Default is ','kontrolwp')?> 350.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Map Centre','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][centre]" value="<?php echo isset($data['gmaps']['centre']) ? $data['gmaps']['centre']:'' ?>" class="thirty required" /> 
            </div>
        </div>
        <div class="desc"><?php echo __('Enter the latitude and longitude seperated by a comma for the centre position of the map when it loads. Example: For Brisbane, Australia enter ','kontrolwp')?> "-27.470933,153.023502". <a href="http://www.latlong.net/" target="_blank"><?php echo __('Use latlong.net for finding coordinates','kontrolwp')?></a>.</div>                        
    </div>
        
    <div class="item show_ui_field">
        <div class="label"><?php echo __('Map Location Icon','kontrolwp')?></div>
        <div class="field">
        
            <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="field[<?php echo $fkey?>][settings][gmaps][icon]" data-fileReturn="image_url"  data-fileGetData='<?php echo http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'full')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="850" data-fileTypes="{'<?php echo __('Images')?> (*.png)':'*.png'}">                            
                <input type="button" class="upload-el" value="<?php echo __('Upload Image','kontrolwp')?>" style="<?php echo isset($data['gmaps']['icon']) && !empty($data['gmaps']['icon']) ? 'display:none':''?>"  />
                <ul class="upload-list">
                 <?php if(isset($data['gmaps']['icon']) && !empty($data['gmaps']['icon'])) { ?>
                        <li class="file remove" id="file-1">
                            <div class="remove-file"></div>
                            <div class="file-image"><img src="<?php echo Kontrol_Tools::absolute_upload_path($data['gmaps']['icon'])?>"></div>
                            <input type="hidden" name="field[<?php echo $fkey?>][settings][gmaps][icon]" value="<?php echo Kontrol_Tools::absolute_upload_path($data['gmaps']['icon'])?>"></li>
                 <?php } ?>
                </ul>
                
            </div>
 
        </div> 
        <div class="desc"><?php echo __('Upload a custom map location icon. Any locations shown on the map will use this icon. Leave empty for default icon','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Map Type','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][gmaps][type]" data-hide-show-parent=".field-<?php echo $type?>" class="sixty hide-show">
              	<option value="add" data-hide-classes="map-user-select" data-show-classes="map-user-loc-search" <?php echo isset($data['gmaps']['type']) && $data['gmaps']['type'] == 'add' ? 'selected="selected"':''?>><?php echo __('User Adds Locations','kontrolwp')?></option>
                <option value="select" data-show-classes="map-user-select" data-hide-classes="map-user-loc-search" <?php echo isset($data['gmaps']['type']) && $data['gmaps']['type'] == 'select' ? 'selected="selected"':''?>><?php echo __('User Selects Locations','kontrolwp')?></option>
            </select> 
            <div class="inline kontrol-tip" title="<?php echo __('Map Type','kontrolwp')?>" data-text="<?php echo htmlentities('<b>User Adds Markers</b> - Allows the user to click on the map and place markers at certain locations.', ENT_QUOTES, 'UTF-8')?><p><?php echo htmlentities('<b>User Selects Markers</b> - Allows the user to only select markers that have already been added to the map by you.', ENT_QUOTES, 'UTF-8')?></p><p><?php echo htmlentities('All markers added will have their added/selected locations stored as latitude and longitude points when retrieving this custom field.', ENT_QUOTES, 'UTF-8')?></p>"></div>
        </div>
        <div class="desc"><?php echo __('You can either allow the user to add their own location markers by clicking on the map, or select from a list of set markers added by you','kontrolwp')?>.</div>
    </div>
    
    <div class="map-user-select">
 		<div class="image-copies subgroup">
			<?php if(isset($data['gmaps']['set_locations']) && is_array($data['gmaps']['set_locations']) && count($data['gmaps']['set_locations']) > 0) { 
                    $index = 1;
                    foreach($data['gmaps']['set_locations'] as $location) {
            ?>
                       <?php echo $this->renderElement('cf-gmaps-markers', array('fkey'=>$fkey, 'data'=>$location, 'type'=>$type, 'index'=> $index));?>
            <?php      	$index++;
                    }
            }else{ ?>
                <?php echo $this->renderElement('cf-gmaps-markers', array('fkey'=>$fkey, 'data'=>NULL, 'type'=>$type, 'index'=> 1));?>
            <?php } ?>
        </div>
        
         <div class="item">
            <div class="label"><?php echo __('Allow Location Duplicates?','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?php echo $fkey?>][settings][gmaps][allow_duplicates]" class="thirty">
                    <option value="false" <?php echo isset($data['gmaps']['allow_duplicates']) && $data['gmaps']['allow_duplicates'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                    <option value="true" <?php echo isset($data['gmaps']['allow_duplicates']) && $data['gmaps']['allow_duplicates'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                </select> 
            </div>
            <div class="desc"><?php echo __('Enabling this will allow the user to select the same location more than once from the above locations','kontrolwp')?>.</div>
        </div>
    
    </div>
    
    <div class="map-user-loc-search image-copies subgroup">
        <div class="item">
            <div class="label"><?php echo __('Enable Map Location Search?','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?php echo $fkey?>][settings][gmaps][location_search]" class="sixty">
                    <option value="true" <?php echo isset($data['gmaps']['location_search']) && $data['gmaps']['location_search'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                    <option value="false" <?php echo isset($data['gmaps']['location_search']) && $data['gmaps']['location_search'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                </select> 
            </div>
            <div class="desc"><?php echo __('This will allow the user the ability to add a location by entering an address as well as clicking the map','kontrolwp')?>.</div>
        </div>
        <div class="item">
            <div class="label"><?php echo __('Zoom Level','kontrolwp')?><span class="req-ast">*</span></div>
            <div>
                <div class="field">
                    <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][zoom]" value="<?php echo isset($data['gmaps']['zoom']) ? $data['gmaps']['zoom']:'8' ?>" class="sixty required validate-integer" /> 
                </div>
            </div>
            <div class="desc"><?php echo __('Enter the zoom level for the map when it loads. This determines how close or far the map will appear.<br />Default is 8. The higher the number, the closer the zoom','kontrolwp')?>.</div>                        
        </div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Maximum Map Selections Allowed','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][max_selections]" value="<?php echo isset($data['gmaps']['max_selections']) ? $data['gmaps']['max_selections']:'0' ?>" class="thirty required validate-integer" /> 
        </div>
        <div class="desc"><?php echo __('If the user is adding their own markers or selecting from yours, you can limit the amount they can add or select here. 0 = unlimited.','kontrolwp')?>.</div>
    </div>
    
        
</div>