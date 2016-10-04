<?
 global $current_user;
 get_currentuserinfo();
?>

<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('API Key','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][gmaps][api_key]" value="<?=isset($data['gmaps']['api_key']) ? $data['gmaps']['api_key']:'' ?>" class="sixty required" /> 
            </div>
        </div>
        <div class="desc"><?=__('All Google Maps require an API key from Google. <a href="https://developers.google.com/maps/documentation/javascript/tutorial" target="_blank">Click here to learn how to obtain one</a>','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?=__('Map Height','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][gmaps][height]" value="<?=isset($data['gmaps']['height']) ? $data['gmaps']['height']:'350' ?>" class="thirty required validate-integer" /> 
            </div>
        </div>
        <div class="desc"><?=__('Enter the desired height in pixels for the map. Default is ','kontrolwp')?> 350.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Map Centre','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
            <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][gmaps][centre]" value="<?=isset($data['gmaps']['centre']) ? $data['gmaps']['centre']:'' ?>" class="thirty required" /> 
            </div>
        </div>
        <div class="desc"><?=__('Enter the latitude and longitude seperated by a comma for the centre position of the map when it loads. Example: For Brisbane, Australia enter ','kontrolwp')?> "-27.470933,153.023502". <a href="http://www.latlong.net/" target="_blank"><?=__('Use latlong.net for finding coordinates','kontrolwp')?></a>.</div>                        
    </div>
        
    <div class="item show_ui_field">
        <div class="label"><?=__('Map Location Icon','kontrolwp')?></div>
        <div class="field">
        
            <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="field[<?=$fkey?>][settings][gmaps][icon]" data-fileReturn="image_url"  data-fileGetData='<?=http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'full')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="850" data-fileTypes="{'<?=__('Images')?> (*.png)':'*.png'}">                            
                <input type="button" class="upload-el" value="<?=__('Upload Image','kontrolwp')?>" style="<?=isset($data['gmaps']['icon']) && !empty($data['gmaps']['icon']) ? 'display:none':''?>"  />
                <ul class="upload-list">
                 <? if(isset($data['gmaps']['icon']) && !empty($data['gmaps']['icon'])) { ?>
                        <li class="file remove" id="file-1">
                            <div class="remove-file"></div>
                            <div class="file-image"><img src="<?=Kontrol_Tools::absolute_upload_path($data['gmaps']['icon'])?>"></div>
                            <input type="hidden" name="field[<?=$fkey?>][settings][gmaps][icon]" value="<?=Kontrol_Tools::absolute_upload_path($data['gmaps']['icon'])?>"></li>
                 <? } ?>
                </ul>
                
            </div>
 
        </div> 
        <div class="desc"><?=__('Upload a custom map location icon. Any locations shown on the map will use this icon. Leave empty for default icon','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Map Type','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?=$fkey?>][settings][gmaps][type]" data-hide-show-parent=".field-<?=$type?>" class="sixty hide-show">
              	<option value="add" data-hide-classes="map-user-select" data-show-classes="map-user-loc-search" <?=isset($data['gmaps']['type']) && $data['gmaps']['type'] == 'add' ? 'selected="selected"':''?>><?=__('User Adds Locations','kontrolwp')?></option>
                <option value="select" data-show-classes="map-user-select" data-hide-classes="map-user-loc-search" <?=isset($data['gmaps']['type']) && $data['gmaps']['type'] == 'select' ? 'selected="selected"':''?>><?=__('User Selects Locations','kontrolwp')?></option>
            </select> 
            <div class="inline kontrol-tip" title="<?=__('Map Type','kontrolwp')?>" data-text="<?=htmlentities('<b>User Adds Markers</b> - Allows the user to click on the map and place markers at certain locations.', ENT_QUOTES, 'UTF-8')?><p><?=htmlentities('<b>User Selects Markers</b> - Allows the user to only select markers that have already been added to the map by you.', ENT_QUOTES, 'UTF-8')?></p><p><?=htmlentities('All markers added will have their added/selected locations stored as latitude and longitude points when retrieving this custom field.', ENT_QUOTES, 'UTF-8')?></p>"></div>
        </div>
        <div class="desc"><?=__('You can either allow the user to add their own location markers by clicking on the map, or select from a list of set markers added by you','kontrolwp')?>.</div>
    </div>
    
    <div class="map-user-select">
 		<div class="image-copies subgroup">
			<? if(isset($data['gmaps']['set_locations']) && is_array($data['gmaps']['set_locations']) && count($data['gmaps']['set_locations']) > 0) { 
                    $index = 1;
                    foreach($data['gmaps']['set_locations'] as $location) {
            ?>
                       <?=$this->renderElement('cf-gmaps-markers', array('fkey'=>$fkey, 'data'=>$location, 'type'=>$type, 'index'=> $index));?>
            <?      	$index++;
                    }
            }else{ ?>
                <?=$this->renderElement('cf-gmaps-markers', array('fkey'=>$fkey, 'data'=>NULL, 'type'=>$type, 'index'=> 1));?>
            <? } ?>
        </div>
        
         <div class="item">
            <div class="label"><?=__('Allow Location Duplicates?','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?=$fkey?>][settings][gmaps][allow_duplicates]" class="thirty">
                    <option value="false" <?=isset($data['gmaps']['allow_duplicates']) && $data['gmaps']['allow_duplicates'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                    <option value="true" <?=isset($data['gmaps']['allow_duplicates']) && $data['gmaps']['allow_duplicates'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                </select> 
            </div>
            <div class="desc"><?=__('Enabling this will allow the user to select the same location more than once from the above locations','kontrolwp')?>.</div>
        </div>
    
    </div>
    
    <div class="map-user-loc-search image-copies subgroup">
        <div class="item">
            <div class="label"><?=__('Enable Map Location Search?','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?=$fkey?>][settings][gmaps][location_search]" class="sixty">
                    <option value="true" <?=isset($data['gmaps']['location_search']) && $data['gmaps']['location_search'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                    <option value="false" <?=isset($data['gmaps']['location_search']) && $data['gmaps']['location_search'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                </select> 
            </div>
            <div class="desc"><?=__('This will allow the user the ability to add a location by entering an address as well as clicking the map','kontrolwp')?>.</div>
        </div>
        <div class="item">
            <div class="label"><?=__('Zoom Level','kontrolwp')?><span class="req-ast">*</span></div>
            <div>
                <div class="field">
                    <input type="text" name="field[<?=$fkey?>][settings][gmaps][zoom]" value="<?=isset($data['gmaps']['zoom']) ? $data['gmaps']['zoom']:'8' ?>" class="sixty required validate-integer" /> 
                </div>
            </div>
            <div class="desc"><?=__('Enter the zoom level for the map when it loads. This determines how close or far the map will appear.<br />Default is 8. The higher the number, the closer the zoom','kontrolwp')?>.</div>                        
        </div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Maximum Map Selections Allowed','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][gmaps][max_selections]" value="<?=isset($data['gmaps']['max_selections']) ? $data['gmaps']['max_selections']:'0' ?>" class="thirty required validate-integer" /> 
        </div>
        <div class="desc"><?=__('If the user is adding their own markers or selecting from yours, you can limit the amount they can add or select here. 0 = unlimited.','kontrolwp')?>.</div>
    </div>
    
        
</div>