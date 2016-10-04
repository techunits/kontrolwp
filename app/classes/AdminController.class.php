<?php
/**********************
* Controls the initial plugin load and application settings for the admin area in WP
* @Plugin Name: Kontrol
* @Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class AdminController extends Lvc_PageController
{

	protected $layout = 'default';
	
	var $wpdb;
	var $controller_layout;
	var $ajax = FALSE;
	
	public static $app_module_current_path;
	public static $app_module_current_url;
		
	
	protected function beforeAction()
	{

		global $wpdb;
		global $modules;
		
		$this->wpdb = $wpdb;
		
		// Make the list of modules available to the main template for the menu
		$this->setLayoutVar('modules', $modules);
		
		// Don't load the default view immediately
		$this->loadDefaultView = false;
		// Set some paths for the current controller
		self::$app_module_current_path = APP_MODULE_PATH.$this->controllerName;
		self::$app_module_current_url = URL_MODULES.$this->controllerName;
		
		// Check to see if we have an Kontrol Alert to display
		$alert = new Kontrol_Alert();
		$this->setLayoutVar('app_alert_msg', $alert->check_message());
		
		// Set some paths for the main layout template
		$this->setLayoutVar('app_current_controller', $this->controllerName);
		
		// Set some paths for the current view
		$this->setVar('controller_url', URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
		$this->setVar('action', $this->actionName);
		
		// Don't need to add hooks if we the request is done via ajax
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// Special ajax methods can be added here if needed
			$this->ajax = TRUE;
		}else{
			// Check if the user has access privs
			$this->check_admin_options_page();
			// Load module CSS
			$this->setLayoutVar('css_files', self::load_module_css());
			// Load module JS
			$this->setLayoutVar('js_files', self::load_module_js());
		}
		
	}
	
	/**********************
	* After the controller has run its action and finished, display the view and maybe tidy up
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function afterAction()
	{
		// Display the controllers set view
		if($this->controller_layout && $this->ajax == FALSE) {
			$this->loadView($this->controller_layout);
		}else{
			exit();	
		}
	}
	
	/**********************
	* Admin Options Page Content
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function check_admin_options_page() 
	{
		if (!current_user_can('manage_options'))  {
			wp_die(__('You do not have sufficient permissions to access this page. Administrator access only.', 'kontrolwp'));
		}						
	}
	
	/**********************
	* Load CSS for the current module
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public static function load_module_css() 
	{
		
		$files = array();
		
		// Load all the CSS for this module
		foreach(glob(self::$app_module_current_path.'/css/*.css', GLOB_NOSORT) as $css) { 
			$path = pathinfo($css);	
			$css = self::$app_module_current_url.'/css/'.$path['filename'].'.css';
			$files[] = $css;
		}
		
		return $files;
		
	}
	
	/**********************
	* Load JS for the current module
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public static function load_module_js() 
	{
		
		$files = array();
		
		// Load all the CSS for this module
		foreach(glob(self::$app_module_current_path.'/js/*.js', GLOB_NOSORT) as $js) { 
			$path = pathinfo($js);	
			$js = self::$app_module_current_url.'/js/'.$path['filename'].'.js';
			$files[] = $js;
		}
		
		return $files;
		
	}
	
		

}

?>