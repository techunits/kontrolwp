<?php
/**********************
* Creates some easy to use functions for retrieving kontrol custom settings
* @author Euphern Technology Pvt. Ltd. & David Rugendyke 
* @author_uri http://www.ironcode.com.au
* @since 1.0.2
***********************/


if(!function_exists('kwp_get_setting')) {
	
	/**********************
	* Retrieve a custom setting
	* @author Euphern Technology Pvt. Ltd. & David Rugendyke 
	* @since 1.0.2
	***********************/
	
	function kwp_get_setting($field_key = NULL) 
	{
		if(!empty($field_key)) {

			$field_data = NULL;
			
			// Field content
			$field_data = get_option('kontrol_option_'.$field_key, NULL);
			
			if(!empty($field_data)) {
				// Format it
				$format = new Kontrol_CF_Format_Field_Data();
				$field_data = $format->get_field($field_key, $field_data);
			}

			return $field_data;
		}	
	}
	
}


if(!function_exists('kwp_the_setting')) {
	/**********************
	* Retrieve a custom setting and echoes it
	* @author Euphern Technology Pvt. Ltd. & David Rugendyke 
	* @since 1.0.2
	***********************/
	function kwp_the_setting($field_key = NULL) 
	{
		echo kwp_get_setting($field_key);
	}
	
}


?>