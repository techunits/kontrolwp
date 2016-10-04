<?
/**********************
* Initialises the start of the Kontrol WP Framework - only included when the framework is needed
* Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

// Include and configure the LighVC framework
include_once(APP_PATH . 'modules/lightvc.php');
Lvc_Config::addControllerPath(APP_PATH . 'controllers/');
Lvc_Config::addControllerViewPath(APP_PATH . 'views/');
Lvc_Config::addLayoutViewPath(APP_PATH . 'views/layouts/');
Lvc_Config::addElementViewPath(APP_PATH . 'views/');
Lvc_Config::setViewClassName('AppView');

// Load main controller
include(APP_PATH . 'classes/AdminController.class.php');
include_once(APP_PATH . 'classes/AppView.class.php');
// Load admin routes
include(APP_CONFIG_PATH . '/AdminRoutes.php');

// Add the module directories as exta controller paths
foreach(glob(APP_MODULE_PATH.'*', GLOB_NOSORT) as $module_dir) { 
   Lvc_Config::addControllerPath($module_dir.'/');
}

// Add the module view directories as exta view paths
foreach(glob(APP_MODULE_PATH.'*/views', GLOB_NOSORT) as $module_dir) { 
   Lvc_Config::addControllerViewPath($module_dir.'/');
   Lvc_Config::addElementViewPath($module_dir.'/');
}


?>