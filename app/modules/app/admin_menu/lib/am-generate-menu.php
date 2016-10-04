<?php
/**********************
* Generates the admin menu
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


if(!function_exists('kontrol_am_generate_menu')) {
	
	/**********************
	* Generates the menu
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function kontrol_am_generate_menu($k_menu) 
	{
		global $k_menu_orig;
		global $k_submenu_orig; 
		
		$wp_menu = $k_menu_orig;
		$wp_submenu = $k_submenu_orig;
		
		 //echo '<pre>';
		// print_r($k_menu['submenu']);
		// echo '</pre>';
		 			 
		 if(!empty($k_menu) && is_array($k_menu)) {
			 
			 // Main Menu - Find new items in the main menu that are not in the saved one, most likely added by other plugins
			 foreach($wp_menu as $key => $item) {
				 // It's not a seperator?
				 if($item[4] != 'wp-menu-separator') {
					 // It isn't in our current menu
					 if(!isset($k_menu['menu'][$item[2]])) {
						 // Add it to the current menu 
						 $k_menu['menu'][$item[2]] = $item;
					 }
				 }
			 }
			 
			 // Sub Menu - Find new items in the main menu that are not in the saved one, most likely added by other plugins
			 foreach($wp_submenu as $key_url => $submenu) {
				// Go through each submenu item
				foreach($submenu as $index => $item) {
					$url_key = $item[2];
					//print_r($item);
					//echo $k_menu['submenu'][$key_url][$url_key][2].' - '.$url_key.'<br>';
					// It isn't in our current menu
					 if(!isset($k_menu['submenu'][$key_url][$url_key][2])) {
						 // Add it to the current menu 
						 $k_menu['submenu'][$key_url][$url_key] = $item;
					 }
				}
				
				// $k_menu['submenu'][$key_url] = array_values($k_menu['submenu'][$key_url]);
			 }
			 
		 }
		 
		 
		 return $k_menu;
		 
		 
		
	}
	
}




?>