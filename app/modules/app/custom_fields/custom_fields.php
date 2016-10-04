<?php
/**********************
* Controls the custom fields core admin
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class CustomFieldsController extends AdminController
{
	
	public static $type = 'cf';
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		// Load the model
		KontrolModel::load('custom_fields', $this->controllerName);	
		// Load the rules	
		include_once('lib/cf-rules.php');
		// Current fields
		$this->setVar('field_count', $this->currentFieldCount());
		$this->setVar('type', self::$type);
		
		
	
	}
	
		

	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		// See if we have an active CF, send to add new if we dont
		$sel = new CustomFieldsGroupsPtsModel();
		$sel->group_type = NULL;
		$results = $sel->select();
		
		if(self::$type == 'cf') {
		
			if(count($results) > 0) {
				$this->actionManage();
				$this->setVar('action', 'manage');
			}else{
				$this->actionAdd();
				$this->setVar('action', 'add');
			}
			
		}else{
			$this->actionManage();
			$this->setVar('action', 'manage');
		}
		
	}
	
	
	/**********************
	* Manage CF
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionManage()
	{
		
		// Page layout for this controller
		$this->controller_layout = self::$type.'-manage';
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		// Get all the groups by post type
		$sel = new CustomFieldsGroupsPtsModel();
		$sel->group_type = self::$type;
		$groups = $sel->select();
		
		$pt_groups = array();
		// Order them into an array by post type
		if(count($groups) > 0) {
			foreach($groups as $group) {
				// Count the fields
				$sel = new CustomFieldsModel();
				$sel->group_id = $group->group_id;
				$fields = $sel->select();
				$group->field_count = count($fields);
				$group->options = unserialize($group->group_options);
				$pt_groups[$group->post_type_key][] = $group;
			}
		}
		
		// Custom fields
		if(self::$type == 'cf') {
			// Get the current post types
			$post_types_wp = get_post_types(array('public'=> true),'objects');
			$post_types_cf = array();
			foreach($post_types_wp as $pt) {
				$post_types_cf[$pt->name] = $pt->label;
			}
		}
		
		// Get the custom settings config
		$settings = get_option('kontrol_cs_settings', array());
		
		// Custom settings
		if(self::$type == 'cs') {
			$post_types_cf =  $settings['categories'];
		}else{
			asort($post_types_cf);
		}
		
		$this->setVar('type', self::$type);
		$this->setVar('post_types', $post_types_cf);
		$this->setVar('cs_settings', $settings);
		$this->setVar('groups', $pt_groups);
		
				
	}
	
	/**********************
	* Add CF
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionAdd()
	{
		$this->controller_layout = 'cf-add-edit-form';
		KontrolModel::load('custom_fields_types', $this->controllerName);
		// Check Save
		$this->checkVer();
		// Get a list of the current field types
		$sel = new CustomFieldsTypesModel();
		$this->setVar('field_types', $sel->select());
		// Get the rules to use
		$this->setVar('rules', CF_Rules::generate());
		// Set the post types
		$post_types_wp = get_post_types(array('public'=> true),'objects');
		$post_types_cf = array();
		foreach($post_types_wp as $pt) {
			$post_types_cf[$pt->name] = $pt->label;
		}
		$this->setVar('post_types', $post_types_cf);
		
		// Add an inital post type group
		$this->setVar('post_type_groups', array('post'=>'Post Type'));
		
		// Get the custom settings config
		$settings = get_option('kontrol_cs_settings', array());
		
		// Get the group settings categories list
		$this->setVar('group_settings_cats_list',  $settings['categories']);

		
	}
	
	/**********************
	* Save/Update a CF group
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSave()
	{
		// Load the models we need
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		KontrolModel::load('custom_fields_rules', $this->controllerName);
		
		// Are we deleting?
		if(isset($this->post['group-delete-flag']) &&  $this->post['group-delete-flag'] == 1) {
			// Get the group
			$sel = new CustomFieldsGroupsModel();	
			$sel->id = $this->post['cf-group-id'];
			$group = $sel->select();
			// Delete
			$del = new CustomFieldsGroupsModel();	
			$del->id = $this->post['cf-group-id'];
			$del->delete();
			// Display a Kontrol update message
			$alert = new Kontrol_Alert();
			$alert->set_message('Group Deleted', 'Group \''.$group->name.'\' was deleted successfully');
			// Redirect now
			$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
			exit();
		}	
				
		// Save/Update the Group
		$save = new CustomFieldsGroupsModel($this->post);
		if(!empty($this->post['cf-group-id'])) {
			$save->id = $this->post['cf-group-id'];
		}
		$id = $save->save();
		
		
		// Delete the rules for this group and its fields
		$del = new CustomFieldsRulesModel();
		$del->group_id = $id;
		$del->delete();
						
		// Delete the fields set for the group currently
		//$del = new CustomFieldsModel();
		//$del->group_id = $id;
		//$del->delete();
		
		
		// Save the group rules now if set to custom
		if(isset($this->post['group-options']['rule-defaults']) && $this->post['group-options']['rule-defaults'] == 'custom') {
			
			$save = new CustomFieldsRulesModel($this->post);
			$save->group_id = $id;
			$save->save($this->post['group-rule-set']['rules']);
		}
		
		$field_saved_list = array();
		
		// Add the current fields now to that group
		if(isset($this->post['field']) && count($this->post['field'] > 0)) {
			$sort = 0;
			$prev_field_id = 0;
			foreach($this->post['field'] as $field_id => $field) {
				
				if(!empty($prev_parent_field_id)) {
					// If this field is a repeatable and it's parent id is set to 0, use the previous saved field id as parent
					if($field['repeatable'] == 1 && empty($field['parent_id'])) {
						$field['parent_id'] = $prev_parent_field_id;
					}	
				}
				
				// Find that field
				$save = new CustomFieldsModel($field);
				$save->group_id = $id;
				$save->id = $field_id;
				$save->sort_order = $sort;
				$result = $save->select();
				// If it exists, update it otherwise save it as new
				if(count($result) > 0) {
					$field_id = $save->save();
				}else{
					$save->id = NULL;
					$field_id = $save->save();	
				}
				$field_saved_list[] = $field_id;
				
				if($field['repeatable'] == 0) {
					$prev_parent_field_id = $field_id;
				}
						
				$sort++;
				// Save it's rules
				if(isset($field['rules-type']) && $field['rules-type'] == 'custom') {
					// Save the field rules now if they have been set
					$save = new CustomFieldsRulesModel($field);
					$save->field_id = $field_id;
					$save->group_id = $id;
					$save->save($field['rules']);
				}
			}
		}
		
		// Now find which ones were posted that aren't in the current list and delete them
		$sel = new CustomFieldsModel();
		$sel->group_id = $id;
		unset($sel->parent_id);
		$group_fields = $sel->select();
		$group_fields_list = array();
		if(count($group_fields) > 0) {
			foreach($group_fields as $field) {
				$group_fields_list[$field->id] = $field;
			}
		}
		
		foreach($group_fields_list as $field_id => $field) {
			// Delete it if it was not in out current list
			if(!in_array($field_id, $field_saved_list)) {
				$del = new CustomFieldsModel();
				$del->id = $field_id;
				$del->group_id = $id;
				$del->delete();
			}
		}	
		
		/*** Save to their respective group types now **/
		
		$group_cats = array();
		
		// Now depending on the type selected, save those post types or settings categories
		if(self::$type == 'cf' && isset($this->post['group-post-types'])) {
			$group_cats = $this->post['group-post-types'];
		}
		// Only one settings category can be selected, so add it to any array for the loop below
		if(self::$type == 'cs' && isset($this->post['group-settings-cat'])) {
			$group_cats = array($this->post['group-settings-cat']);
		}
		
		// Save/update all the group x post type entries
		if(isset($group_cats) && count($group_cats) > 0) {
			$group_pts = array_unique($group_cats);
			
			// Get all the group x pts for this group
			$sel = new CustomFieldsGroupsPtsModel();
			$sel->group_id = $id;
			$sel->group_type = self::$type;
			$group_current_pts = $sel->select();
			$group_pt_key_list = array();
			if(count($group_current_pts) > 0) {
				foreach($group_current_pts as $group_pt) {
					$group_pt_key_list[$group_pt->id] = $group_pt->post_type_key;
				}
			}
			
			for($i=0; $i < count($group_pts); $i++) {

				$save = new CustomFieldsGroupsPtsModel();
				// It exists, update it
				foreach($group_pt_key_list as $pt_id => $pt_key) {
					if($pt_key == $group_pts[$i]) {
						$save->id = $pt_id;	
					}
				}			
				$save->group_id = $id;
				$save->group_type = self::$type;
				$save->pt_key = $group_pts[$i];
				$new_id = $save->save();
				if(!isset($save->id)) {
					$sort = new CustomFieldsGroupsPtsModel();
					$sort->id = $new_id;
					$sort->sort_order = 1000+$i;
					$sort->update_sort_order();
				}
				
			}
			
			// Now find which ones were posted that aren't in the current list and delete them
			$sel = new CustomFieldsGroupsPtsModel();
			$sel->group_id = $id;
			$sel->group_type = self::$type;
			$group_current_pts = $sel->select();
			$group_pt_key_list = array();
			if(count($group_current_pts) > 0) {
				foreach($group_current_pts as $group_pt) {
					$group_pt_key_list[$group_pt->id] = $group_pt->post_type_key;
				}
			}
			
				
			foreach($group_pt_key_list as $pt_id => $pt_key) {
				// Delete it if it was posted but not in our current list
				if(!in_array($pt_key, $group_pts)) {
					$del = new CustomFieldsGroupsPtsModel();
					$del->id = $pt_id;
					$del->delete();
				}
			}	
		}
		
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Save Complete','kontrolwp'), __('Custom Field Group Successfully Updated.','kontrolwp'));
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
		
	}
	

	/**********************
	* Edit a CF group
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionEdit($id)
	{
		// Set the view for this action
		$this->controller_layout = 'cf-add-edit-form';
		// Load the models we need
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);		
		KontrolModel::load('custom_fields_rules', $this->controllerName);	
		KontrolModel::load('custom_fields_types', $this->controllerName);
		
		// Get all the post types assigned to this group
		$sel = new CustomFieldsGroupsPtsModel();
		$sel->group_id = $id;
		$sel->group_type = NULL;
		$this->setVar('post_type_groups', $sel->select());
		
		// Set the post types
		$post_types_wp = get_post_types(array('public'=> true),'objects');
		$post_types_cf = array();
		foreach($post_types_wp as $pt) {
			$post_types_cf[$pt->name] = $pt->label;
		}
		$this->setVar('post_types', $post_types_cf);
		
		// Get the group
		$sel = new CustomFieldsGroupsModel();
		$sel->id = $id;
		$group = $sel->select();
		$group->options = unserialize($group->options);
		
		// Get the rules for the group
		$sel = new CustomFieldsRulesModel();
		$sel->group_id = $id;
		$sel->field_id = 0;
		$group->rules = $sel->select();
		
		// Get all the fields in the group
		$sel = new CustomFieldsModel();
		$sel->group_id = $id;
		$fields = $sel->select();
		$fields_exp = array();
		
		if(count($fields) > 0) {
			foreach($fields as $field) 
			{
				// Unserialize the data
				$field = $this->prepareField($field);
				// Get any children it might have (repeatables)
				if($field->field_type->cf_key == 'repeatable') {
					// Get all the fields in the group
					$sel = new CustomFieldsModel();
					$sel->group_id = $id;
					$sel->parent_id = $field->id;
					$fields_child = $sel->select();
					$fields_child_exp = array();
					
					if(count($fields_child) > 0) {
						foreach($fields_child as $field_child) 
						{	
							// Unserialize the data
							$fields_child_exp[] = $this->prepareField($field_child);
						}
						$field->fields = $fields_child_exp;
					}
				}
				
				// Save the field
				$fields_exp[] = $field;
			}
		}
		
		$group->fields = $fields_exp;
		
		// Get the custom settings config
		$settings = get_option('kontrol_cs_settings', array());
		
		// Get the group settings categories list
		$this->setVar('group_settings_cats_list',  $settings['categories']);
		
		// Set the main template var
		$this->setVar('cf_group', $group);
		// Get the rules to use
		$this->setVar('rules', CF_Rules::generate());
		// Get a list of the current field types
		$sel = new CustomFieldsTypesModel();
		$this->setVar('field_types', $sel->select());
		
	}
	
	
		
	/**********************
	* Prepare a Field - unserialize it's data etc
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function prepareField($field)
	{
		// Unserialize the data
		$field->validation = unserialize($field->validation);
		$field->settings = unserialize($field->settings);
		
		// Get the rules for this field
		$sel = new CustomFieldsRulesModel();
		$sel->field_id = $field->id;
		$field->rules = $sel->select();	
		
		// Get the type
		$sel = new CustomFieldsTypesModel();
		$sel->key = $field->field_type;
		$field->field_type = $sel->select();
		
		return $field;
	}
	
	/**********************
	* Counts the amount of fields currently saved
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function currentFieldCount()
	{
		// Load the fields
		$load = new CustomFieldsModel();
		$load->parent_id = 0;
		return count($load->select());
	}
	
	/**********************
	* Checks to see what ver is running
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function checkVer()
	{
		// Load the fields
		$fields = $this->currentFieldCount();
		// Validate the field count
		if($fields >= 10) {
			if(KONTROL_T) {
				$this->actionManage();
			}
		}else{
			return false;
		}
	}

	
	/**********************
	* Toggle the visibility of a post type group
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionHideGroupPostType()
	{
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		// Save/Update the Custom Post Type
		$update = new CustomFieldsGroupsPtsModel();
		$update->id = $this->post['id'];
		$update->active = $this->post['flag'];
		$update->update_visibility();
	}
	
	/**********************
	* Remove a group from a post type
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionDeleteGroupPostType()
	{
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);	
		// Save/Update the Custom Post Type
		$del = new CustomFieldsGroupsPtsModel();
		$del->id = $this->post['id'];
		$del->delete();
	}
	
	/**********************
	* Update the sort order
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionUpdateGroupOrder($id, $sort)
	{
		
		KontrolModel::load('custom_fields_groups', $this->controllerName);	
		KontrolModel::load('custom_fields_groups_pts', $this->controllerName);
		
		$update = new CustomFieldsGroupsPtsModel();
		$update->id = $id;
		$update->sort_order = $sort;
		$update->update_sort_order();
		
		// Get the group
		$group_current = $update->select();
		
		// Now get all the other rows and resort them
		$update = new CustomFieldsGroupsPtsModel();
		$update->group_type = self::$type;
		$update->pt_key = $group_current->post_type_key;
		$groups = $update->select();
		
		if(!empty($groups)) {
			$index = 0;
			foreach($groups as $group) {
				
				if($group->id != $id) {
					if($index == $sort) { 
						$index++;								
					}
					$update->sort_order = $index;
					$update->id = $group->id;
					$update->update_sort_order();	
					//echo $group->id.' - '.$index.'<br>';
					$index++;
				}

			}
		}
		
		die();
	}
	
}

?>