<?php
/**********************
* Creates some easy to use functions for retrieving kontrol CFs
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


if(!function_exists('get_cf')) {
	/**********************
	* Retrieve a custom field
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	
	function get_cf($field_key = NULL, $post_id = NULL) 
	{
		if(!empty($field_key)) {
			global $post;
			$field_data = NULL;
			
			// Check if we're in the loop
			if(empty($post_id)) {
				$post_id = $post->ID;
			}
			
			if(empty($post_id)) { return; }
			
			// Field content
			$field_data = get_post_meta($post_id, $field_key, TRUE);
			
			if(!empty($field_data)) {
				// Format it
				$format = new Kontrol_CF_Format_Field_Data();
				$field_data = $format->get_field($field_key, $field_data);
			}

			return $field_data;
		}	
	}
	
}


if(!function_exists('the_cf')) {
	/**********************
	* Retrieve a custom field and echoes it
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function the_cf($field_key = NULL, $post_id = NULL) 
	{
		echo get_cf($field_key, $post_id);
	}
	
}


?>