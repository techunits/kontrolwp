<?php
/**********************
* Controls the SEO core admin
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class SEOController extends AdminController
{
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		// Page layout for this controller
		$this->controller_layout = 'seo-settings';
	
	}
	
		

	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		// Load the main settings page by default
		$this->actionSettings();	
	}
	
	/**********************
	* Controller Settings Page
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSettings()
	{
		
		// Get the saved settings
		$this->setVar('settings', get_option('kontrol_seo_settings', array()));
		
		$seo_warnings = array();
		// Perform some initial SEO checks and add warnings if need be
		$wp_perm_format = strtolower(get_option('permalink_structure'));
		if(empty($wp_perm_format) || !strpos($wp_perm_format, '%postname%')) {
			$seo_warnings[] = 'permalink_structure';	
		}
		$this->setVar('seo_warnings', $seo_warnings);
		
		// Get the native/custom post types
		$pt_native = get_post_types(array('public'=>true, '_builtin'=>true), 'objects');
		unset($pt_native['attachment']);
		$this->setVar('pt_native', $pt_native);
		// Get all the custom post types
		$this->setVar('pt_custom', get_post_types(array('public'=>true, '_builtin'=>false), 'objects'));
		
		/*
		// Get the native/custom taxonomies
		$tax_native = get_taxonomies(array('public'=>true, '_builtin'=>true), 'objects');
		unset($tax_native['post_format']);
		$this->setVar('tax_native', $tax_native);
		// Get all the custom taxonomies
		$this->setVar('tax_custom', get_taxonomies(array('public'=>true, '_builtin'=>false), 'objects'));
		*/
		
	}
	
	/**********************
	* Controller Settings Page - Save
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSettingsSave()
	{
		// Saving
		if($_POST) {
			// Convert any 'true', 'false', integer strings to their boolean/integer counterparts
			array_walk_recursive($_POST['settings'], 'Kontrol_Tools::array_convert_types');
			update_option('kontrol_seo_settings', $_POST['settings']);	
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message(__('Save Complete','kontrolwp'), __('Settings Successfully Updated','kontrolwp').'.');
			// Redirect now
			$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName.'/settings');
		}
	}
	
	/**********************
	* Controller Defaults Page
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionDefaults()
	{
		$this->controller_layout = 'seo-defaults';
		// Load the main settings
		$this->setVar('settings', array_map('stripslashes_deep', get_option('kontrol_seo_settings', array())));
		// Load the defaults settings
		$this->setVar('defaults', array_map('stripslashes_deep', get_option('kontrol_seo_defaults', array())));
		// Set the post types
		$this->setVar('pts', get_post_types(array('public'=>true), 'objects'));
		
	}
	
	/**********************
	* Controller Defaults Page - Save
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionDefaultsSave()
	{
		// Saving
		if($_POST) {
			// Convert any 'true', 'false', integer strings to their boolean/integer counterparts
			array_walk_recursive($_POST['defaults'], 'Kontrol_Tools::array_convert_types');
			update_option('kontrol_seo_defaults', $_POST['defaults']);	
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message(__('Save Complete','kontrolwp'), __('Meta Defaults Successfully Updated','kontrolwp').'.');
			// Redirect now
			$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName.'/defaults');
		}
	}

	
}

?>