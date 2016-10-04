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
* Controls the start of the Kontrol WP Framework
* Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/
class KontrolAdmin
{
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function __construct() 
	{
		
	}

	/**********************
	* Load our plugins options page through the admin menu hook
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function set_hooks() 
	{
		
		// Main assets
		add_action('admin_print_styles', array(&$this, 'load_assets_css'));
		// JS - Go Go Mootools :D
		add_action('admin_print_scripts', array(&$this, 'load_assets_js'));
		// Activation of the plugin
		register_activation_hook(PLUGIN_PATH.'index.php', array(&$this, 'install_plugin'));
	}
	
	/**********************
	* This admin options page hook is called seperately
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function set_hook_options_page() 
	{
		// Process the request when viewing the kontrol plugin page
		$hook_suffix = add_options_page(__("Kontrol Panel",'kontrolwp'), 'Kontrol', 'manage_options', 'kontrolwp', array(&$this, 'option_page_request'));
		// Load our assets for the admin options area
		add_action('load-'.$hook_suffix , array(&$this,'option_page_load_assets'));
	}
		
	/**********************
	* The utility page hook is called when a new seperate page outside of the settings->kontrol menu needs to run
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function set_hook_utility_page($page_title, $page_title_id, $menu_name, $menu_id, $perm_level, $page_id, $menu_icon) 
	{
		// Process the request when viewing the kontrol plugin page
		$hook_suffix = add_utility_page(__($page_title,$page_title_id), __($menu_name,$menu_id), $perm_level, $page_id, array(&$this, 'option_page_request'), $menu_icon);
		// Load our assets for the admin options area
		//add_action('load-'.$hook_suffix , array(&$this,'option_page_load_assets'));
		
	}
	
	/**********************
	* The utility page hook is called when a new seperate page outside of the settings->kontrol menu needs to run
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function set_hook_menu_page($page_title, $page_title_id, $menu_name, $menu_id, $perm_level, $page_id, $menu_icon, $pos) 
	{
		// Process the request when viewing the kontrol plugin page
		$hook_suffix = add_menu_page(__($page_title,$page_title_id), __($menu_name,$menu_id), $perm_level, $page_id, array(&$this, 'option_page_request'), $menu_icon, $pos);
		
	}
	
	/**********************
	* Load CSS
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function load_assets_css() 
	{
        wp_register_style('kontrol', URL_CSS.'admin.css');
		wp_enqueue_style('kontrol');
		
		wp_register_style('kontrol-date', URL_CSS.'datepicker.css');
		wp_enqueue_style('kontrol-date');
		
		wp_register_style('kontrol-moorainbow', URL_CSS.'moorainbow/mooRainbow.css');
		wp_enqueue_style('kontrol-moorainbow');
	}
	
	/**********************
	* Load JS
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function load_assets_js() 
	{
		$current_lang = WPLANG;
		
        // Kontrol is largely powered by Mootools in the admin, so add it to the wphead
		// Note: It won't break other plugins in no conflict mode
		// Mootools is actually very awesome (class based JS, yes please!), if you want to try something other than jQuery, give it a shot, we love it
		wp_enqueue_script('kontrolmoo-core', URL_JS.'core/mootools-core-1.4.5.js');
		wp_enqueue_script('kontrolmoo-more', URL_JS.'core/mootools-more-1.4.0.1-nc.js');
		
		// Load greensock - awesome lightweight effects lib
		wp_enqueue_script('kontrolgs-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js');
		
		// Load the i18n language file and parse it - these are commonly used js phrases that support internationalisation in Kontrol
		wp_enqueue_script('kontrolmoo-i18n', URL_JS.'i18n.js');
		wp_localize_script('kontrolmoo-i18n', 'kontrol_i18n_js', array(
			'label_required'  => __('Required', 'kontrolwp'),
			'label_optional'  => __('Optional', 'kontrolwp'),
			'delete'  => __('Delete this item?', 'kontrolwp'),
			'delete_pt'  => __('Delete group from this post type?', 'kontrolwp'),
			'delete_pt_warning'  => __('A group must belong to at least one post type. To delete this group entirely, edit it and and hit the "Delete" button.', 'kontrolwp'),
			'delete_cf_group_warning'  => __('Delete this group permanently?', 'kontrolwp'),
			'leave_without_saving_cf'  => __('You have not saved this custom field group. Are you sure you wish to leave the page?', 'kontrolwp'),
			'confirm' => __('Are you sure?', 'kontrolwp'),
			'remove_upload' => __('Remove this upload?', 'kontrolwp'),
			'error_server' => __('Error occured contacting the server', 'kontrolwp'),
			'error_upload_required' => __('This file upload is required', 'kontrolwp'),
			'error_max_choices' => __('You are allowed to select a maximum of', 'kontrolwp'),
			'error_max_cf' => sprintf(__("Apologies! This version of Kontrol only allows you %d custom fields. Please upgrade at %s to create unlimited custom fields.\n\nIt's super cheap and as a bonus, you'll be supporting us and you'll receive all upgrades and future modules for Kontrol for free!", 'kontrolwp'), 10, 'http://www.kontrolwp.com/upgrade'),
			'seo_replace_title' => __('Do you want to replace the current SEO title with this auto generated one?', 'kontrolwp'),
			'copy_field_key' => __('Custom Field Key','kontrolwp'),
			'gmap_location_duplicate' => __('Sorry, you are only allowed to select this location once.','kontrolwp')
		));
		
		// Fancy Uploader
		wp_enqueue_script('kontrolmoo-fancyul-pb',  URL_JS.'fancyupload/source/Fx.ProgressBar.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-fancyul-swiff',  URL_JS.'fancyupload/source/Swiff.Uploader.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-fancyul-fu3',  URL_JS.'fancyupload/source/FancyUpload3.Attach.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		
		// Kontrol File Uploader
		wp_enqueue_script('kontrolmoo-image-upload',  URL_JS.'file-uploads.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
			
		// Kontrol Smart Box
		wp_enqueue_script('kontrolmoo-smart-box',  URL_JS.'smart-box.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		// Kontrol Tab Box
		wp_enqueue_script('kontrolmoo-tab-box',  URL_JS.'tab-box.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		// Kontrol Tip Box
		wp_enqueue_script('kontrolmoo-tip-box',  URL_JS.'tool-tips.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		// Sortables
		wp_enqueue_script('kontrolmoo-sortrows',  URL_JS.'sort-rows.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		
		// Date Picker - Load the correct language file
		$date_lang_id = str_replace('_','-',$current_lang);
		$date_lang = !empty($current_lang) && file_exists(PLUGIN_PATH.'js/datepicker/Locale.'.$date_lang_id.'.DatePicker.js') ? $date_lang_id : 'en-US';
	
		wp_enqueue_script('kontrolmoo-date-local',  URL_JS.'datepicker/Locale.'.$date_lang.'.DatePicker.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-date-picker',  URL_JS.'datepicker/Picker.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-date-attach',  URL_JS.'datepicker/Picker.Attach.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-date',  URL_JS.'datepicker/Picker.Date.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-date-range',  URL_JS.'datepicker/Picker.Date.Range.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		// Moo Rainbow
		wp_enqueue_script('kontrolmoo-moorainbow',  URL_JS.'moorainbow/mooRainbow.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		
	}
	
	/**********************
	* Load our options page assets when it's loaded
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function option_page_load_assets() 
	{	
		// The options page scripts
		wp_enqueue_script('kontrolmoo-utlities',  URL_JS.'utilities.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-formhideshow',  URL_JS.'form-hide-show.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-formhideshownew',  URL_JS.'form-hide-show-new.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-selectcustom',  URL_JS.'select-custom-value.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-collapse',  URL_JS.'collapse-expand-section.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-seladd',  URL_JS.'select-add.js',  array('kontrolmoo-core', 'kontrolmoo-more'));	
		wp_enqueue_script('kontrolmoo-sidenote',  URL_JS.'side-notification.js',  array('kontrolmoo-core', 'kontrolmoo-more'));		
	}
	
	/**********************
	* Process the request, launch framework - only fired from within the options page for this plugin for optimisation
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function option_page_request() 
	{
		
		// Start the framework to process our request
		include(APP_PATH . 'modules/lightvc.init.php');
					
		try {
			
			// Process the HTTP request using only the routers we need for this application.
			$fc = new Lvc_FrontController();
			$fc->addRouter(new Lvc_RegexRewriteRouter($regexRoutes));
			$fc->processRequest(new Lvc_HttpRequest());
			
			
		} catch (Lvc_Exception $e) {
			
			// Log the error message
			error_log($e->getMessage());
			
			echo '<p><b>Kontrol Error: '.$e->getMessage().'</p>';
			
			// Get a request for the 404 error page.
			$request = new Lvc_Request();
			$request->setControllerName('error');
			$request->setActionName('view');
			$request->setActionParams(array('error' => '404'));
	
			// Get a new front controller without any routers, and have it process our handmade request.
			$fc = new Lvc_FrontController();
			$fc->processRequest($request);
			
		} catch (Exception $e) {
			
			// Some other error, output "technical difficulties" message to user?
			error_log($e->getMessage());
		}
	}
	
	
	/**********************
	* Runs when the plugin is activated, use it to setup tables and add data based on modules etc.
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function install_plugin() 
	{
			
		include_once(APP_PATH . 'modules/lightvc.php');
		Lvc_Config::addControllerPath(APP_PATH . 'controllers/');
		
		$request = new Lvc_Request();
		$request->setControllerName('plugin');
		$request->setActionName('install');

		$fc = new Lvc_FrontController();
		$fc->processRequest($request);
	}
	
	/**********************
	* This function checks to see if the serial key is valid - yup that's right! If you want to pirate it, go ahead and figure it out below :) 
	* But please at least take note that I put a huge amount of time and effort into this and I really think it's worth the small amount i'm charging! Support independant developers please ;D
	* You can buy it legit at www.kontrolwp.com and get some warm fuzzy feelings for helping me make this a great plugin and continue making it so!
	* P.S I love you!
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function path_check() 
	{
		$dd0=get_option('kontrol_verify_cache',NULL);$sw1=get_option('kontrol_serial',NULL);if(!$dd0){define('KONTROL_T',TRUE);}else{$ek2=!empty($sw1)?sha1($sw1.APP_ID):NULL;$qo3=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,md5($ek2),base64_decode($dd0),MCRYPT_MODE_CBC,md5(md5($ek2))),"\0");($qo3==$sw1)?define('KONTROL_T',FALSE):define('KONTROL_T',TRUE);}
		define('DD0_TRIAL', $dd0);
	}
	
}
	


?>