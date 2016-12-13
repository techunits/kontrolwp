<?php
/*
Plugin Name: KontrolWP - Kontrol Wordpress Developer Kit
Plugin URI: http://www.kontrolwp.com
Description: KontrolWP is an advanced Wordpress plugin for developers. Create custom CMS sites using advanced custom fields, custom post types, custom taxonomies, admin menu editors, SEO and much more through an easy to use interface. 
Version: 2.0.7
Author: Euphern Technology Pvt. Ltd. & David Rugendyke 
Author URI: http://www.kontrolwp.com
License: GPLv3 http://www.gnu.org/licenses/gpl.html
Requirements: PHP version 5.3 or greater, MySQL version 5.1 or greater
Text Domain: kontrolwp
Tags: kontrolwp, advanced custom fields, custom post types, custom taxonomies, admin menu editor 
*/

// Remove any added slashes if "Magic Quotes" are enabled
if (get_magic_quotes_gpc()) {
    $_POST      = array_map('stripslashes_deep', $_POST);
    $_GET       = array_map('stripslashes_deep', $_GET);
    $_COOKIE    = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST   = array_map('stripslashes_deep', $_REQUEST);
}

// Some hooks don't need to run if it's an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    define('AJAX_REQUEST', TRUE);   
}else{
    define('AJAX_REQUEST', FALSE);
}

// Avoid "not found" errors for favicon, which is automatically requested by most browsers.
if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {

} else {
    
    // Load core application config
    require_once('app/config/application.php');
    
    // Include some general classes
    require_once(APP_PATH . 'classes/AppTools.class.php');
    require_once(APP_PATH . 'classes/AppModel.class.php');
    
    // Load the language file to use
    $lang = new Kontrol_Init_Language();
    add_action('plugins_loaded', array(&$lang, 'load'));
    
    // Is this an ajax upload?
    if(isset($_REQUEST['upload']) && $_REQUEST['upload'] == 'true') {
            require_once(APP_PATH . 'modules/lightvc.php');
            Lvc_Config::addControllerPath(APP_PATH . 'controllers/');
            // Set the controller to upload 
            $request = new Lvc_Request();
            $request->setControllerName('upload_file');
            $request->setActionName($_REQUEST['ac']);
            $fc = new Lvc_FrontController();
            $fc->processRequest($request);
        
    } else {
    
        // Initialise all the modules - set their hooks and more
        require_once(APP_PATH . 'classes/ModuleInit.class.php');
        $init = new KontrolModuleInit();
        // Get a list of the modules config files
        $modules = $init->modules;
        
        // If it's the WP admin area, load our hooks and process any plugin page option requests using the LVC Framework
        if(is_admin()) {
            // Our admin class
            require_once(APP_PATH . 'classes/Admin.class.php');
            $kontrol_admin = new KontrolAdmin();
            $kontrol_admin->path_check();
            
            // Set the admin menu hook seperately, as it needs it's callback defined here
            add_action('admin_menu', array(&$kontrol_admin, 'set_hook_options_page'));
            
            // Set all the admin hooks
            $kontrol_admin->set_hooks();

            //  TODO: this should be fired only on Dashboard
            require_once(APP_PATH . 'controllers/kwp_dashboard.php');
            $kdc = new KWPDashboardController();
            $kdc->actionQuickWidget();

            
        }
        require_once(APP_PATH . 'controllers/clone_post.php');
        $cpc = new ClonePostController();
        $cpc->actionClone();

        //  activate KontrolWP widgets
        require_once(APP_PATH . 'controllers/widget.php');
        $cpc = new KWPCustomPostTypeWidgetController();
        $cpc->actionRegisterWidget();
    }
}

?>