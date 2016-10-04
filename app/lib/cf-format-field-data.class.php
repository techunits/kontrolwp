<?php
/**********************
* Retrieves a custom field and formats its data accordingly - used by custom fields and custom settings
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.2
***********************/

class Kontrol_CF_Format_Field_Data
{
	
	public $type;
	
	/**********************
	* Retrieve the field and format the passed data
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function get_field($field_key, $field_data = NULL)
	{
		
		// Now grab the field
		$sel = new CustomFieldsModel();
		$sel->field_key = $field_key;
		$sel->active = 1;
		$sel->limit = 1;
		$field = $sel->select();
		
		if(!empty($field)) {
			
			// Unseralize the options
			$field->settings = unserialize($field->settings);
			
			// Certain fields require some extra steps
			switch ($field->field_type) {
				case 'boolean':
					 // Convert it to real boolean vals
					 $field_data = ($field_data == 'true') ? TRUE : FALSE;
				break;
				case 'date':
					 // If its a date field with range enabled, return it as an array
					 if(isset($field->settings['date_range']) && $field->settings['date_range'] == TRUE) {
						 $field_data = explode('||', $field_data);
					 }
				break;
				case 'image':
					 // Check to see if this field has copies (a comma should seperate them, the first is always the original), if it does, grab them and format accordingly
					 if(strpos($field_data, ',') !== false) {
						 // Get the image ids
						 $attach_ids = explode(',',$field_data);
						 $attach_copy_ids_data = array();
						 // The first one is always the original
						 $original_data = $this->format_field_data($field, array_shift($attach_ids));
						 // Get the copy keys
						 if(isset($field->settings['image_copy']) && is_array($field->settings['image_copy']) && count($field->settings['image_copy']) > 0) {
							 $image_copies = array_values($field->settings['image_copy']);
						 }
						 // Format the array to return now since we are returning the original + copies
						 $index = 0;
						 foreach($attach_ids as $id) {
							 $attach_copy_ids_data[$image_copies[$index]['image_key']] = $this->format_field_data($field, $id);
							 $index++;
						 }
						 // Now return a formatted array
						 $image_copy_array = array('original'=>$original_data, 'copies'=>$attach_copy_ids_data);
						 
						 return $image_copy_array;
					 }
				break;
				case 'repeatable':
					// Get the repeatables fields and format them each
					if(isset($field_data) && is_array($field_data)) {
						$row_count = 0;
						$stored_settings = array();
						foreach($field_data as $row_key => $row_fields) {
							foreach($row_fields as $sub_field_key => $field_val) {
								if($row_count == 0) {
									// Only look up the fields settings on the first row, no need to do it again for each row since their all identical settings wise
									$sel = new CustomFieldsModel();
									$sel->field_key = $sub_field_key;
									$sel->active = 1;
									$sel->limit = 1;
									$sel->parent_id = $field->id;
									$sub_field = $sel->select();
									$sub_field->settings = unserialize($sub_field->settings);
									$stored_settings[$sub_field_key] = $sub_field;
								}
								$field_data[$row_key][$sub_field_key] = $this->format_field_data($stored_settings[$sub_field_key], $field_val);
							}
							$row_count++;
						}
					}
				
					break;
			}

			// Format the data and return type
			$field_data = $this->format_field_data($field, $field_data);
		}
		
		return $field_data;
		
	}
	
	/**********************
	* Format the passed data
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	private function format_field_data($field, $field_data)
	{
		$field_data_set = array();
		$return_single = TRUE;
		
		if(is_array($field_data)) {
			$field_data_set = $field_data;	
			$return_single = FALSE;
		}else{
			$field_data_set[0] = $field_data;	
		}
		

		for($i=0; $i < count($field_data_set); $i++) {
			
			$field_data = $field_data_set[$i];
			
			
			if(!empty($field_data)) {
			
				// Return Type?
				if(isset($field->settings['return_type'])) {
					if(is_numeric($field_data)) {
						if($field->settings['return_type'] == 'post_object') {
							$field_data = get_post($field_data);	
						}
						if($field->settings['return_type'] == 'post_url') {
							
							$field_data = get_permalink($field_data);
						}
						if($field->settings['return_type'] == 'url') {
							$field_data = wp_get_attachment_url($field_data);
						}
						if($field->settings['return_type'] == 'url_absolute') {
							$field_data = Kontrol_Tools::absolute_upload_path(wp_get_attachment_url($field_data));
						}
					}
				}else{
					
					// Allow HTML?
					if(isset($field->settings['allow_html']) && $field->settings['allow_html'] == FALSE) {
						$field_data = strip_tags($field_data);
					}
					// Convert line breaks?
					if(isset($field->settings['br_convert']) && $field->settings['br_convert'] == TRUE) {
						$field_data = nl2br($field_data);
					}
					
				}
				
				$field_data_set[$i] = $field_data;
			}
				
		}
		
		// Check to see if the return type is multiple (select, page-link), if it is, remove the first item, it's always en empty place holder, then return as an array
		if(isset($field->settings['select_max_values']) && $field->settings['select_max_values'] > 1)
		{
			array_shift($field_data_set);
		}
				
		
		// Don't return empty value repeatable arrays
		if(count($field_data_set) == 1 && $field->field_type == 'repeatable' && empty($field_data_set[0])) 
		{
			$field_data_set = array();
		}
		
		// If the field doesn't require an array return (multiple values), return just the value and not an array of one
		if($return_single == TRUE) 	{
			return $field_data_set[0];
		}else{
			return $field_data_set;
		}
	}
	
}

?>