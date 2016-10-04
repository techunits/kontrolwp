<?php
/**********************
* Controls the hooks for each module
* @Plugin Name: Kontrol
* @Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class HookController extends Lvc_PageController
{

	var $wpdb;
	var $controller_layout;
		
	protected function beforeAction()
	{

		global $wpdb;
		$this->wpdb = $wpdb;
		
		// Don't load the default view immediately
		$this->loadDefaultView = false;
		// Set some paths for the current controller
		$this->app_module_current_path = APP_MODULE_PATH.str_replace('_hooks','',$this->controllerName);
		$this->app_module_current_url = URL_MODULES.str_replace('_hooks','',$this->controllerName);
		
	}
	
	/**********************
	* After the controller has run its action and finished, display the view and maybe tidy up
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function afterAction()
	{
		
	}
	

}

?>