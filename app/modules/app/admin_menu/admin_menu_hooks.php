<?php
/**********************
* Controls the admin menu type hooks
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class AdminMenuHooksController extends HookController
{
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();

	}
	
		
	/**********************
	* The controller will add any hooks it needs to here for the WP environment - is called everytime the app runs
	* @author David Rugendyke
	* @param: ob - Reference of $this
	* @since 1.0.0
	***********************/
	public function actionSetHooks()
	{
		if(is_admin() && !AJAX_REQUEST) {
			include_once('lib/am-generate-menu.php');
			// Set the custom post types
			add_action('admin_init', array(&$this,'set_admin_menu'));
		}
	}
	
	/**********************
	* Edits the admin menu when the hook above runs
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function set_admin_menu()
	{
		 global $menu;
		 global $submenu;
		 
		 global $k_menu_orig;
		 global $k_submenu_orig;
		 
		 $k_menu_orig = $menu;
		 $k_submenu_orig = $submenu;
		 
		 //echo '<pre>';
		 //print_r($menu);
		 //echo '</pre>';
		
		 
		 // Get the stored menu
		 $this->am = get_option('kontrol_admin_menu');
		 	 
			 
		 if(!empty($this->am) && is_array($this->am) && isset($menu) && !empty($menu)) {
			 
			  $menu_filtered = array();
		 
			 // Reformat the menu to match ours using the url as the key
			 foreach($menu as $key => $item) {
				 $menu_filtered[$item[2]] = $item;		 
			 }
			 
			 // Generate the filtered menu with the WP menu elements and kontrol menu elements
			 $this->am = kontrol_am_generate_menu($this->am);
			 
			  
			// Loop through the menu items and remove the hidden ones
			if(isset($this->am['menu']) && is_array($this->am['menu'])) {
				foreach($this->am['menu'] as $index => $item) {
					// Remove it if it's hidden or deleted
					if((isset($item['visible']) && $item['visible'] == 'false') || (isset($item['deleted']) && $item['deleted'] == 'true')) {
						unset($this->am['menu'][$index]);
					}
					// If the it doesn't exist in the main menu now for reasons outside of our control, remove it too
					if(!isset($menu_filtered[$index]) && !isset($item['type'])) {
						unset($this->am['menu'][$index]);
					}
					// Update it's menu icon to a path for this install
					if(isset($item[6]) && $item[6] != 'none') {
						 // Make the path absolute to this WP install incase the install has been moved to another domain/site
						 $item[6] = Kontrol_Tools::absolute_upload_path($item[6]);	
					}
				};
			}
			
			if(isset($this->am['submenu']) && is_array($this->am['submenu'])) {
				foreach($this->am['submenu'] as $parent_index => $item) {
					foreach($item as $index => $subitem) {
						if((isset($subitem['visible']) && $subitem['visible'] == 'false') || (isset($subitem['deleted']) && $subitem['deleted'] == 'true')) {
							unset($this->am['submenu'][$parent_index][$index]);
						}
					}
				};
			}
			
								
			$menu = array_values($this->am['menu']);
			$submenu = $this->am['submenu'];
		}
		   
	}
	
}

?>