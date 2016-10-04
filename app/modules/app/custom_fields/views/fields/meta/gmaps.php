<? 
    // Make the array safe for storing in the data attribute as a json array
	if(isset($field->settings['gmaps']['set_locations'])) { array_walk_recursive($field->settings['gmaps']['set_locations'], 'Kontrol_Tools::array_store_as_safe_json'); } 
?>

<div id="map-<?=$field->field_key?>" class="kontrol-gmap" 
	data-api-key="<?=isset($field->settings['gmaps']['api_key']) ? $field->settings['gmaps']['api_key']:''?>" 
    data-zoom="<?=isset($field->settings['gmaps']['zoom']) ? $field->settings['gmaps']['zoom']:'8'?>" 
    data-centre="<?=isset($field->settings['gmaps']['centre']) ? $field->settings['gmaps']['centre']:'-27.470933,153.023502'?>" 
    data-type="<?=isset($field->settings['gmaps']['type']) ? $field->settings['gmaps']['type']:'add'?>" 
    data-locations='<?=isset($field->settings['gmaps']['set_locations']) && is_array($field->settings['gmaps']['set_locations']) ? json_encode($field->settings['gmaps']['set_locations']):''?>' 
    data-icon="<?=isset($field->settings['gmaps']['icon']) ? Kontrol_Tools::absolute_upload_path($field->settings['gmaps']['icon']):''?>" 
    data-allow-duplicates="<?=isset($field->settings['gmaps']['allow_duplicates']) ? Kontrol_Tools::absolute_upload_path($field->settings['gmaps']['allow_duplicates']):''?>" 
    style="width: 100%; height: <?=isset($field->settings['gmaps']['height']) ? $field->settings['gmaps']['height']:'350'?>px">
 </div> 
 
 <? // In here so that the values can be reset if nothing is selected ?> 
 	<input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="" />
    
	<div class="kontrol-smart-box" data-hide-when-empty="true" data-disable-row-delete="true">
      <div class="section">
          <div class="inside">
               <div class="rows sortable">
               	  <div class="row new-row">
                      <div class="inline tab drag-row"></div>
                      <div class="content inline">[[LABEL]]</div>
                      <div class="delete-row" title="<?=__('Delete Row', 'kontrolwp')?>"></div>  
                      <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value='[[VALUE]]' data-dave='DAVEEE' />
                   </div>
               	  <? 
						if(!empty($data)) { 
				  ?>
                          <div class="row">
                              <div class="inline tab drag-row"></div>
                              <div class="content inline"><?=$data['label']?></div>
                              <div class="delete-row" title="<?=__('Delete Row', 'kontrolwp')?>"></div>  
                              <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value='<?=$data['value']?>' />
                           </div>
                   <? 	}
				    ?>
               </div> 
          </div>
      </div> 
   </div>   