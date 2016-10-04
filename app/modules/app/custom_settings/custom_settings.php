<?php
/**********************
* Controls the custom settings core admin, extends custom fields
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.2
***********************/

require_once(APP_MODULE_PATH.'custom_fields/custom_fields.php');

class CustomSettingsController extends CustomFieldsController
{
	
		
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	protected function beforeAction() {
		
		// Set the cf type
		parent::$type = 'cs';
		parent::beforeAction();
		
		// Current action
		$action = $this->getActionName();
		
		// If we are adding a custom settings field, load the custom fields css and js files
		if(!AJAX_REQUEST) {
			if($action == 'add' || $action == 'edit') {
				// Load the cf scripts/css
				parent::$app_module_current_path = APP_MODULE_PATH.'custom_fields';
				parent::$app_module_current_url = URL_MODULES.'custom_fields';
				// Load module CSS
				$this->setLayoutVar('css_files', parent::load_module_css());
				// Load module JS
				$this->setLayoutVar('js_files', parent::load_module_js());
			}
		}
		
	}
	
	/**********************
	* Save the custom settings
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function actionSaveSettings()
	{
		// Update the settings
		if(isset($this->post['settings'])) {
			// Convert any 'true', 'false', integer strings to their boolean/integer counterparts
			array_walk_recursive($this->post['settings'], 'Kontrol_Tools::array_convert_types');
			// Format our category data
			$new_categories = array();
			if(isset($this->post['settings']['categories']) && is_array($this->post['settings']['categories'])) {
				$labels = $this->post['settings']['categories']['label'];
				for($i=0; $i < count($labels); $i++) {
					
					$cat_label = $this->post['settings']['categories']['label'][$i];
					$cat_desc = $this->post['settings']['categories']['desc'][$i];
					// Generate a key if one doesn't exist
					$cat_key = isset($this->post['settings']['categories']['key'][$i]) && !empty($this->post['settings']['categories']['key'][$i]) ? $this->post['settings']['categories']['key'][$i] : htmlentities(str_replace(' ','-', strtolower($cat_label)));
					// Add it now
					$new_categories[$cat_key] = array('label' => $cat_label, 'desc' => $cat_desc);
				}
				
			}
			// Reasign the categories using out formatted one
			$this->post['settings']['categories'] = $new_categories;
			// Update option
			update_option('kontrol_cs_settings', $this->post['settings']);
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message('Save Complete', 'Custom Settings Successfully Updated.');
			// Redirect now
			$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName.'/manage/cs');
		}
	}
	
	/**********************
	* Delete a settings group and the fields in them
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function actionDeleteSettingsGroup()
	{
		if(isset($this->post['pt_type'])) {
			KontrolModel::load('custom_fields_groups', $this->controllerName);	
			KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
			// Get all the groups in that type
			$sel = new CustomFieldsGroupsPtsModel();
			$sel->group_type = 'cs';
			$sel->pt_key = $this->post['pt_type'];
			$groups = $sel->select();
			
			if(is_array($groups)) {
				foreach($groups as $group) {
					// Now delete the groups
					$sel = new CustomFieldsGroupsModel();
					$sel->id = $group->group_id;
					$sel->delete();
				}
			}
			
		}
	}
	
	/**********************
	* Displaying the settings page
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function actionSettingsPage()
	{
		
		// If there is a POST, we are saving fields
		if(isset($this->post['save_fields'])) {
			
			$this->settingsPageSaveFields();
		}
		
		// Main page layout for this controller
		$this->layout = 'wp-page';
		// Manage the settings page
		$this->controller_layout = 'cs-settings';
		
		// Get the cs settings
		$settings = get_option('kontrol_cs_settings', array());
		$page_title = (isset($settings['name']) && !empty($settings['name'])) ? $settings['name'] : 'Site Config';
		
		$first_cat_key = NULL;
		
		// Get the categories
		$categories = array();
		if(isset($settings['categories']) && is_array($settings['categories'])) {
			// Grab all the settings  for this one
		
			foreach($settings['categories'] as $cat_key => $data) {
				
				$first_cat_key = $first_cat_key == NULL && !empty($cat_key) ? $cat_key : $first_cat_key;
				
				
				// Get all this categories settings
				$sel = new CustomFieldsGroupsPtsModel();
				$sel->group_type = 'cs';
				$sel->pt_key = $cat_key;
				$sel->active = 1;
				$groups = $sel->select();
				
				$group_data = array();
				
				// Now validate any extra rules they might have
				foreach($groups as $group) {
							
					$this->group = $group;
					$options = unserialize($group->group_options);
					// Get all the fields for this group that are active
					$sel = new CustomFieldsModel();
					$sel->group_id = $group->group_id;
					$sel->active = 1;
					$fields = $sel->select();
					
					$group->fields = $fields;			
					$group_data[] = $group;
				}
				
				$categories[$cat_key] = array('data'=>$data, 'groups'=>$group_data);
			}
		}
		if(isset($_GET['cat']) && !empty($_GET['cat'])) {
			$current_cat = $_GET['cat'];
		}else{
			$current_cat = $first_cat_key;
		}
		

		// Set the main template var
		$this->setVar('updated_times', get_option('kontrol_cs_settings_updated', array()));
		$this->setVar('page_title', $page_title);
		$this->setVar('cat', $current_cat);
		$this->setVar('categories', $categories);
		$this->setVar('settings', $settings);
		
	}
	
	/**********************
	* Save the settings fields as options
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	public function settingsPageSaveFields()
	{
		if(isset($this->post['_kontrol'])) {
			
			$new_data = $this->post['_kontrol'];
			
			if(count($new_data) > 0) {
					foreach($new_data as $field_key => $value) {
						$field_key = 'kontrol_option_'.$field_key;
						update_option($field_key, $value);
					}
			}

		}
		
		// Get the the save time
		$updated_times = get_option('kontrol_cs_settings_updated', array());
		$updated_times[$this->post['current_cat']] = time();
		update_option('kontrol_cs_settings_updated', $updated_times);
		
		// Redirect now
		$this->redirect(URL_WP_SETTINGS_PAGE.'&cat='.$this->post['current_cat']);
		
	}
	
	
}

?>