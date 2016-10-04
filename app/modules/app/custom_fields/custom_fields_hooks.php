<?php
/**********************
* Controls the custom fields hooks and the custom settings hooks
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class CustomFieldsHooksController extends HookController
{
	protected $layout = 'fields/meta/layout';
	public $group;
	
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		// Load the models
		KontrolModel::load('custom_fields', $this->controllerName);		
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		KontrolModel::load('custom_fields_rules', $this->controllerName);	
		KontrolModel::load('custom_fields_types', $this->controllerName);
		// Load the extra libs
		include_once(APP_LIB_PATH.'cf-format-field-data.class.php');	
		include_once('lib/cf-rules.php');	
		include_once('lib/cf-frontend.php');	
		include_once(APP_MODULE_PATH.'custom_settings/lib/cs-frontend.php');	
	
	}
	
	/**********************
	* The controller will add any hooks it needs to here for the WP environment - is called everytime the app runs
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSetHooks()
	{
		if (is_admin()) {
			// Metabox CSS
			add_action('admin_print_styles', array(&$this, 'actionLoadCSS'));
			// JS - Go Go Mootools :D - also add the cf types to the head as a JS array
			add_action('admin_print_scripts', array(&$this, 'actionLoadJS'));
			// Add the meta boxes to the admin post edit screens
			add_action('add_meta_boxes', array(&$this,'setCustomFieldsMetaBoxes'));
			// Add a callback function to save any data from the metabox
			add_action('save_post',array(&$this,'saveCustomFieldsMetaBoxes'));
			// Get the custom settings config
			$settings = get_option('kontrol_cs_settings', array());
			// Check to see if we need to add the admin menu settings
			if(isset($settings['enabled']) && $settings['enabled'] == TRUE) {
				// Add settings menu
				add_action('admin_menu',array(&$this, 'customSettingsPageInit'));
			}
		}
	}
	
	/**********************
	* Set a hook for the settings page 
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function customSettingsPageInit()
	{
		// Get the custom settings config
		$settings = get_option('kontrol_cs_settings', array());
		$menu_icon = (isset($settings['menu_icon']) && !empty($settings['menu_icon'])) ? Kontrol_Tools::absolute_upload_path($settings['menu_icon']) : NULL;
		$menu_name = (isset($settings['name']) && !empty($settings['name'])) ? $settings['name'] : 'Site Config';
		
		
		// Process the request for the page via the framework
		global $kontrol_admin;
		$kontrol_admin->set_hook_menu_page('Kontrol Settings', 'kontrol-settings', $menu_name, 'kontrol-settings-menu', 'manage_options', 'kontrolcs', $menu_icon, 1000);
		
		// Add submenu pages
		if(isset($settings['categories']) && is_array($settings['categories']) && count($settings['categories']) > 0) {
			foreach($settings['categories'] as $cat_key => $cat_data) {
				add_submenu_page('kontrolcs', 'Settings - '.$cat_data['label'], $cat_data['label'], 'manage_options', 'admin.php?page=kontrolcs&cat='.$cat_key, NULL);
			}
		}
		
	}
	

	/**********************
	* The CSS for the meta boxes/fields
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionLoadCSS()
	{
		// Load our metabox CSS
		wp_register_style('kontrol-cf-meta', $this->app_module_current_url.'/css/meta.css');
        wp_enqueue_style('kontrol-cf-meta');
		// Settings page
		wp_register_style('kontrol-cf-settings', URL_MODULES.'custom_settings/css/settings.css');
        wp_enqueue_style('kontrol-cf-settings');
	}
	
	/**********************
	* The JS for the meta boxes/fields
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionLoadJS()
	{
		
		global $post;

		// Load our metabox JS
		wp_enqueue_script('kontrolmoo-cf-meta',  $this->app_module_current_url.'/js/custom-fields-meta.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-cf-validation',  $this->app_module_current_url.'/js/custom-fields-validation.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		wp_enqueue_script('kontrolmoo-cf-gmaps',  $this->app_module_current_url.'/js/custom-fields-gmaps.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
		
		// Compile our CF types into a JS array for the above script to use
		$rules = CF_Rules::generate();
		
		$types_keys = array();
		foreach($rules as $parent_key => $rule_set) {
			foreach($rule_set as $rule) {
				// User roles are filtered out at the meta box function below
				if($rule['key'] != 'user_roles') {
					$types_keys[] = $rule['key']; 	
				}
			}
		}
		
		// Set the correct localisation
		$current_lang = WPLANG;
		$lang_id = str_replace('_','-',$current_lang);
		
		echo "<script type='text/javascript'>
				var kontrol_cf_types = ['".implode("','", $types_keys)."'];
				var kontrol_app_path = '".URL_PLUGIN."';
				var kontrol_upload_size_limit = '".Kontrol_Tools::return_post_max('bytes')."';
				var kontrol_post_data = ".json_encode($post).";
				var kontrol_i18n_lang = '".$lang_id."';
			  </script>";	
	}
	
	
	/**********************
	* Sets the custom fields meta boxes
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function setCustomFieldsMetaBoxes()
	{


		// Get the current post type
		$post_type = $GLOBALS['current_screen']->post_type;
		
		// Get all our active groups for this post type
		$sel = new CustomFieldsGroupsPtsModel();
		$sel->pt_key = $post_type;
		$sel->active = 1;
		$groups = $sel->select();
		// Now validate any extra rules they might have
		foreach($groups as $group) {
			$this->group = $group;
			$options = unserialize($group->group_options);
			// Get all the fields for this group that are active
			$sel = new CustomFieldsModel();
			$sel->group_id = $group->group_id;
			$sel->active = 1;
			$fields = $sel->select();

			// Metabox ID
			$metabox_id = $options['style'] == 'meta' ? 'kontrol-group-' : 'kontrol-group-nobox-';
			// Process the fields now
			if(count($fields) > 0) {
				// Create a meta box for this group now
				add_meta_box(
					$metabox_id.$group->group_id,	
					esc_html__($group->group_name, $group->group_name),		// Title
					array(&$this,'setCustomFieldsMetaBoxesContent'),		// Callback function
					$post_type,					// Admin page (or post type)
					$options['position'],		// Context
					'high',			            // Priority
					array('group'=>$group, 'fields'=>$fields)	// Group/Fields	
				);
				
				
					
			}
			
		}
		
	}
	
	/**********************
	* Saves the custom fields meta boxes
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function saveCustomFieldsMetaBoxes($post_id)
	{
		
		if(isset($_POST['kontrol_noncename'])) {
						
			if(!wp_verify_nonce($_POST['kontrol_noncename'], 'kontrol_cf_submit')) {
					die('Kontrol Security Check: Form submitted late or from external server location.');
			}
			
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { 
				return; 
			}
		
			// Get the correct post id (not a revision)
			if (wp_is_post_revision($post_id)) {
				$post_id = wp_is_post_revision($post_id);
			}
			
			if(isset($_POST['_kontrol'])) {
				$new_data = $_POST['_kontrol'];
				
				//echo '<pre>';
				//print_r($new_data);
				//echo '</pre>';
				//die();
			
				if(count($new_data) > 0) {
						foreach($new_data as $field_key => $value) {
							$current_data = get_post_meta($post_id, $field_key, TRUE); 
							if ($current_data) {
								if (empty($value)) {
									delete_post_meta($post_id, $field_key);
								}else{
									update_post_meta($post_id, $field_key, $value);
								}
							}
							elseif (!empty($value)) {
								add_post_meta($post_id, $field_key, $value, TRUE);
							}
						}
				}
			}
		}
		
		
		return $post_id;

	}
	
	
	/**********************
	* Sets the custom fields meta boxes
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function setCustomFieldsMetaBoxesContent($post, $args)
	{
	   // Use nonce for verification
	   wp_nonce_field('kontrol_cf_submit', 'kontrol_noncename' );
	   // Group
	   $group = $args['args']['group'];
	   // Fields
	   $fields = $args['args']['fields'];
	   // Get all the rules for this group
	   $sel = new CustomFieldsRulesModel();
	   $sel->group_id = $group->group_id;
	   $sel->field_id = 0;
	   $group_rules = $sel->select();
	  
	   foreach($fields as $field) {
		    $field->settings = unserialize($field->settings);
			$field->validation = unserialize($field->validation);
			// Get the rules for this field
			$sel = new CustomFieldsRulesModel();
			$sel->group_id = $group->group_id;
			$sel->field_id = $field->id;
			$rules = $sel->select();
			
			$field_op = NULL;
			$field_rules = NULL;
			$field_cond = NULL;
			$rule_groups = array();
			$field_validation = NULL;
			
			// Fall back to the group rules if none for the field exist
			if(count($rules) == 0 && count($group_rules) > 0) {
				$rules = $group_rules;
			}
			
			// Filter out user role rules here, make them check the match the logged of user regardless
			global $current_user;
			get_currentuserinfo();
			$user_roles = $current_user->roles;
			$user_role = array_shift($user_roles);
			$skip_field = false;
			
			// Compile the rules into a grouped array per rule type
			foreach($rules as $rule) {
				
				$param_key = NULL;
				
				// Get custom value field types for rules
				if(isset($rule->param) && strpos($rule->param, ':') !== FALSE) {
					$custom_rule_parts = split(':', $rule->param);
					$rule->param = $custom_rule_parts[0];
					$param_key = $custom_rule_parts[1];
				}
				
				$rule_groups[$rule->param]['operator'][] = $rule->operator;
				$rule_groups[$rule->param]['value'][] = $rule->value;
				$rule_groups[$rule->param]['key'][] = $param_key;
				$rule_groups[$rule->param]['cond'] = $rule->cond;
			}
						
			foreach($rule_groups as $rule_group_key => $rule_data) {
				
				$field_cond = $rule_data['cond'];
							
				$field_rules .= 'data-rule-'.$rule_group_key.'="'.implode(',', $rule_data['value']).'" data-op-'.$rule_group_key.'="'.implode(',', $rule_data['operator']).'" data-key-'.$rule_group_key.'="'.implode(',', $rule_data['key']).'" ';	
				
				// Skip this field if the user role doesn't match it eval("return($x $z $y);")
				if($rule_group_key == 'user_roles') {
					for($i=0; $i < count($rule_data['value']); $i++) {
						if($rule_data['operator'][$i] == '=' && ($user_role != $rule_data['value'][$i])) {
							$skip_field = true;
						}
						if($rule_data['operator'][$i] == '!=' && ($user_role == $rule_data['value'][$i])) {
							$skip_field = true;
						}
					}
				}
			}
				
			// Check it has validation first
			if(is_array($field->validation)) {
				$field_validation = implode(' ',$field->validation);	
			}

			if(!$skip_field) {
				
				// If it's a repeater field, get it's sub fields
				if($field->field_type == 'repeatable') {
					// Get all the fields in the group
					$sel = new CustomFieldsModel();
					$sel->group_id = $group->group_id;
					$sel->parent_id = $field->id;	
					$sel->active = 1;
					$this->setVar('sub_fields', $sel->select());
				}
				
				$this->setLayoutVar('field', $field);
				$this->setLayoutVar('field_cond', $field_cond);
				$this->setLayoutVar('field_rules', $field_rules);
				$this->setVar('current_user', $current_user);
				$this->setVar('field', $field);
				$this->setVar('field_validation', $field_validation);
				$this->setVar('field_value', get_post_meta($post->ID, $field->field_key, TRUE)); 
				$this->setVar('post', $post);
				// Load the fields view
				$this->loadView('fields/meta/'.$field->field_type);
			}
	   }
	   
	}
	
	
}

?>