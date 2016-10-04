<?php
/*
Plugin Name: Kontrol
Plugin URI: http://www.kontrolwp.com
Description: Kontrol is an advanced Wordpress package for managing custom post types, advanced custom fields, admin menu editing and much more through an easy to use interface. 
Version: 1.0
Author: David Rugendyke
Author URI: http://www.ironcode.com.au/
License: GPL
Copyright: David Rugendyke
Requirements: PHP version 5.2.4 or greater, MySQL version 5.0 or greater
*/


/**********************
* Initialises any modules hooks and additional functions - required to run everytime
* Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/
class KontrolModuleInit
{
	
	var $modules = array();
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function __construct() 
	{
		// Create an array of all the module config files
		$this->module_list();
		// Set the hooks of any modules that have the required function
		$this->set_hooks();
	}
	
	/**********************
	* Load all module configs into an array and return it
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function module_list() 
	{
		 // Load the module configs and order them by sort and type
		 foreach(glob(APP_MODULE_PATH.'*/module.php', GLOB_NOSORT) as $config) {  
			  // Get the config file
			  include($config);
			  $path = pathinfo($config);
			  $kontrol_module['path'] = $path['dirname'].'/';
			  $this->modules[] = $kontrol_module;
		 }
		 
		$sorted_modules = array();
		 // Reoorder the modules by their sort order
		foreach($this->modules as $module) {
			$sorted_modules[$module['sort_order']] = $module;
		}
		
		ksort($sorted_modules);
		$this->modules = $sorted_modules;
		
	
	}

	
	/**********************
	* Fire any hooks set in the modules
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function set_hooks() 
	{
		// Start the framework to process our request for this module
		include_once(APP_PATH . 'modules/lightvc.php');
		include_once(APP_PATH . 'classes/AppView.class.php');
		// Load main controller
		include(APP_PATH . 'classes/HookController.class.php');
		$init = new Lvc_Config();
		
		$init_modules = array();
		
		// Reoorder the modules to fire in their 'init' order
		foreach($this->modules as $module) {
			$init_modules[$module['init_order']] = $module;
		}

		// Fire the hooks now through the framework if they exist
		for($i=0; $i < count($init_modules); $i++) {
			$init->addControllerPath($init_modules[$i]['path']);
			$init->addControllerViewPath($init_modules[$i]['path'].'/'.'views/');
			$init->addLayoutViewPath($init_modules[$i]['path'].'/'.'views/');
			$init->addElementViewPath($init_modules[$i]['path'].'/'.'views/');
			$init->addElementViewPath(APP_VIEW_PATH);
			$init->setViewClassName('AppView');
			
			try {
				$request = new Lvc_Request();
				$request->setControllerName($init_modules[$i]['controller_file'].'_hooks');
				$request->setActionName('setHooks');
				
				$fc = new Lvc_FrontController();
				$fc->processRequest($request);
			}catch (Exception $e) {
			
				// Just used for debugging
				// echo '<p><b>Hook Error: '.$e->getMessage().'</b></p>';
			}
		}
	}
}
	


?>