<?php
/**********************
* Controls the admin menu core admin
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class AdminMenuController extends AdminController
{
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		global $menu;
		global $submenu;
		
		global $menu_orig;
		global $submenu_orig;
		
		// Load the model
		//KontrolModel::load('custom_fields', $this->controllerName);	
			
		$this->wp_menu = $menu;
		$this->wp_submenu = $submenu;
		// Our saved menu
		$this->am = get_option('kontrol_admin_menu');
		
		// Page layout for this controller
		$this->controller_layout = 'am-manage';
	
	}
	
		

	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		
		include_once('lib/am-generate-menu.php');
		
		// Check to see if we have a saved custom menu
		if(empty($this->am)) {
			$this->am['menu'] = $this->wp_menu;
			$this->am['submenu'] = $this->wp_submenu;
		}else{
			$this->am = kontrol_am_generate_menu($this->am);	
		}
		
		/*echo '<pre>';
		print_r($k_menu['submenu']);
		echo '</pre>';
		*/

		
		
		// Get a list of all user roles
		$this->setVar('role_list', $this->get_roles_list());
		// Get a list of all capablities for a menu item
		$this->setVar('cap_list', $this->get_menu_capabilities_list());
		// Set the main menu
		$this->setVar('am', $this->am);
		
	}
	
	/**********************
	* Save a menu
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSave()
	{
		// Check to see if we are resetting to defaults first?
		if($this->post['reset-menu'] == 'true') 
		{
			delete_option('kontrol_admin_menu');
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message(__('Reset Complete','kontrolwp'), __('Admin Menu Reset To Defaults.','kontrolwp'));
		}else
		{
			// Convert our kontrol form menu to the WP style
			$this->convert_form_to_menus();
			// Assign to array
			$am = array('menu'=>$this->wp_menu, 'submenu'=>$this->wp_submenu);
			// Now save them
			update_option("kontrol_admin_menu", $am);
			
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message(__('Save Complete','kontrolwp'), __('Admin Menu Successfully Updated.','kontrolwp'));
		}
		
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);		
	}
	
	/**********************
	* Converts the kontrol form data into the required WP menu array
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function convert_form_to_menus()
	{
		
		$menu = array();
		$submenu = array();
		
		$post_menu = $this->post['am'];
						
		if(isset($post_menu) && is_array($post_menu)) {
			
			$post_menu = stripslashes_deep($post_menu);
			
			$sub_index = 0;
			
			
			
			foreach($post_menu[0] as $key => $menu_label) {
				$type = $post_menu['type'][$key];
				
				$url_key = (!empty($post_menu[2][$key]) && $post_menu[2][$key] != 'separator') ? $post_menu[2][$key] : 'separator'.rand(50, 1500);
				
				// Build the main menu
				if($type == 'main') {
										
					$menu[$url_key][0] = $menu_label;
					$menu[$url_key][1] = $post_menu[1][$key];
					$menu[$url_key][2] = $post_menu[2][$key];
					$menu[$url_key][3] = $post_menu[3][$key];
					$menu[$url_key][4] = $post_menu[4][$key];
					$menu[$url_key][5] = $post_menu[5][$key];
					// Remove the domain name from the image URL
					$menu[$url_key][6] = $post_menu[6][$key];
					$menu[$url_key]['visible'] = $post_menu['visible'][$key];
					$menu[$url_key]['type'] = $post_menu['type'][$key];
					$menu[$url_key]['deleted'] = $post_menu['deleted'][$key];

					
				}
				// Build the submenu
				if($type == 'sub' && isset($prevurl)) {
					$sub_index = $post_menu['index'][$key];
					$submenu[$prevurl][$url_key][0] = $menu_label;
					$submenu[$prevurl][$url_key][1] = $post_menu[1][$key];
					$submenu[$prevurl][$url_key][2] = $post_menu[2][$key];
					$submenu[$prevurl][$url_key][3] = $post_menu[3][$key];
					$submenu[$prevurl][$url_key]['visible'] = $post_menu['visible'][$key];
					$submenu[$prevurl][$url_key]['type'] = $post_menu['type'][$key];
					$submenu[$prevurl][$url_key]['deleted'] = $post_menu['deleted'][$key];
				}else{
					$prevurl = $post_menu[2][$key];
				}
			}
		}
		
		
		$this->wp_menu = $menu;
		$this->wp_submenu = $submenu;
				
	}
	
	/**********************
	* Checks to see if an index exists in an array, increments it and checks again if it does
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function index_check($index, $index_array)
	{
		if(in_array($index, $index_array)) {
			$index++;
			$this->index_check($index, $index_array);	
		}else{
			// If it's empty, get the last index used and incremembt it by one
			
			return $index;
		}	
	}
	
		
	/**********************
	* Capabilities List
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function get_menu_capabilities_list()
	{
		// Get a list of all capablities for a menu item
		global $wp_roles;

		$caps = array();

		if(!isset($wp_roles) || !isset($wp_roles->roles)){
			return $caps;
		}

		// Get the capabilities for each role
		foreach($wp_roles->roles as $role) {
			if (!empty($role['capabilities']) && is_array($role['capabilities']) ){ 
				$caps = array_merge($caps, $role['capabilities']);
			}
		}
		
		return $caps;
				
	}
	
	/**********************
	* Get roles List
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function get_roles_list()
	{

		global $wp_roles;
		$roles = array();

		if (!isset($wp_roles) || !isset($wp_roles->roles)){
			return $roles;
		}

		foreach($wp_roles->roles as $role_id => $role){
			$roles[$role_id] = $role['name'];
		}

		return $roles;

	}

	
	
	

	
	
	
}

?>