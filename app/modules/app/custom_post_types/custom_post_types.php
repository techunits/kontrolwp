<?php
/**********************
* Controls the custom post type core 
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class CustomPostTypesController extends AdminController
{
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();

		// Load the model
		KontrolModel::load('custom_post_types', $this->controllerName);		
		
		// Current PTs
		$this->setVar('pt_count', $this->currentPTCount());
		
	}
	
		
	
	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		// See if we have an active post types, send to add new if we dont
		$cpts = new CustomPostTypesModel();
		$results = $cpts->select();
		
		//if(count($results) > 0) {
			$this->actionManage();
			$this->setVar('action', 'manage');
		//}else{
		//	$this->actionAdd();
		//	$this->setVar('action', 'add');
		//}
	}
	
	
	/**********************
	* Manage custom post types
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionManage()
	{
		// Page layout for this controller
		$this->controller_layout = 'cpt-manage';
		
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
		// Init the taxonomies/cpt model
		$load = new CustomPostTypesTaxonomiesModel();
		
		// Set the view for this action
		$this->controller_layout = 'cpt-manage';
		
		$data = array();
		
		// Get all the active cpts
		$cpts = new CustomPostTypesModel();
		$results = $cpts->select();
		
		if(is_array($results)) {
			foreach($results as $cpt) {
				
				$cpt->args = unserialize($cpt->arguments);
				$cpt->columns = unserialize($cpt->columns);
				$load->cpt_id = $cpt->id;
				$data[] = array('cpt' => $cpt, 'taxonomies' => $load->select());
			}
		}	
			
		$this->setVar('current_cpts', $data);
		
		
		// Get all the native cpts
		$cpts = new CustomPostTypesModel();
		$cpts->type = 'native';
		$results = $cpts->select();
		
		$data = array();
		
		$use_only = array('post', 'page');
		
		if(is_array($results)) {
			foreach($results as $cpt) {
				if(in_array($cpt->cpt_key, $use_only)) {

					$cpt->columns = unserialize($cpt->columns);
					$load->cpt_id = $cpt->id;
					
					$cpt->obj = get_post_type_object($cpt->cpt_key);
					$taxonomies = get_object_taxonomies($cpt->cpt_key, 'objects');

					$data[] = array('cpt' => $cpt, 'custom_taxonomies' => $load->select(), 'taxonomies' => $taxonomies);
				}
			}
		}	
			
		$this->setVar('native_pts', $data);
		
	}
	
	/**********************
	* Add a new custom post type
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionAdd()
	{
		// Check ver
		$this->checkVer();
		// Get all the taxonomies
		KontrolModel::load('taxonomies', $this->controllerName);	
		$tax = new TaxonomiesModel();
		$tax->type = 'native';
		$tax_native = $tax->select();
		$tax->type = 'custom';
		$tax_custom = $tax->select();
		
		$this->setVar('tax_native', $tax_native);
		$this->setVar('tax_custom', $tax_custom);
		
		// Set the view for this action
		$this->controller_layout = 'cpt-add-edit-form';
			
	}
	
	/**********************
	* Edit a custom post type
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionEdit($id)
	{
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
		
		// Set the view for this action
		$this->controller_layout = 'cpt-add-edit-form';
		
		// Get all the taxonomies
		KontrolModel::load('taxonomies', $this->controllerName);	
		$tax = new TaxonomiesModel();
		$tax->type = 'native';
		$tax_native = $tax->select();
		$tax->type = 'custom';
		$tax_custom = $tax->select();
		
		$this->setVar('tax_native', $tax_native);
		$this->setVar('tax_custom', $tax_custom);
		
		// Get all taxonomies attached to this pt
		$load = new CustomPostTypesTaxonomiesModel();
		$load->cpt_id = $id;
		$load->order_by = 'tax_name';
		$this->setVar('attached_taxonomies', $load->select());
		
		// Get the cpt
		$cpts = new CustomPostTypesModel();
		
		if(!empty($id)) {
			$cpts->id = $id;
			$result = $cpts->select();
			
			$cpt = $result[0];
			$cpt->args = unserialize($cpt->arguments);
			
			$this->setVar('cpt', $cpt);
		}else{
			$this->actionAdd();
		}
		
	}
	
	/**********************
	* Save/Update custom post type
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSave($id = NULL)
	{
		
		// Load the required models
		KontrolModel::load('posts', $this->controllerName);	
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
		KontrolModel::load('taxonomies', $this->controllerName);	
			
		// Save/Update the Custom Post Type
		$save = new CustomPostTypesModel($this->post);
		if(!empty($id)) {
			$save->id = $id;
		}
		
		$id = $save->save();
		
		// Remove all associated taxonomies first
		$del = new CustomPostTypesTaxonomiesModel();
		$del->cpt_id = $id;
		$del->delete();
				
		// Save the selected taxonomies
		if(isset($this->post['args']['taxonomies']) && count($this->post['args']['taxonomies']) > 0) {
			$save = new CustomPostTypesTaxonomiesModel($this->post);
			$save->cpt_id = $id;
			foreach($this->post['args']['taxonomies'] as $tax) {
				// Get the taxonomy id
				$load = new TaxonomiesModel();
				$load->key = $tax;
				$tax_ob = $load->select();
				$save->tax_id = $tax_ob[0]->id;
				$save->save();
			}
		}
		
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Save Complete','kontrolwp'), __('Post Type Successfully Updated.','kontrolwp'));
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
	}
	
	/**********************
	* Toggle the visibility
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionVisible($id, $flag)
	{
		
		// Save/Update the Custom Post Type
		$update = new CustomPostTypesModel();
		$update->id = $id;
		$update->active = $flag;
		$update->update_visibility();
		$cpt = $update->select();
		
		if($flag != 0) {
			$msg = __('Active','kontrolwp');
		}else{
			$msg = __('Hidden','kontrolwp');	
		}
					
	
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Updated','kontrolwp'), __('Post Type','kontrolwp').' <span>'.$cpt[0]->name.'</span> '.__('Made','kontrolwp').' '.$msg.'.');
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
	}
	
	/**********************
	* Delete the CPT
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionDelete($id)
	{
		
		$delete = new CustomPostTypesModel();
		$delete->id = $id;
		$cpt = $delete->select();
		$delete->delete();
		
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Updated','kontrolwp'), __('Post Type','kontrolwp').' <span>'.$cpt[0]->name.'</span> '.__('Deleted','kontrolwp'));
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);
	}
	
	/**********************
	* Update the sort order
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionUpdateSortOrder($id, $sort)
	{
		
		// Save/Update the Custom Post Type
		$update = new CustomPostTypesModel();
		$update->id = $id;
		$update->sort_order = $sort;
		$update->update_sort_order();
		
		// Get the CPT
		$cpt = $update->select();
							
		// Now get all the other rows and resort them
		$update = new CustomPostTypesModel();
		//$update->active = $cpt[0]->active;
		$cpts = $update->select();
		if(!empty($cpts)) {
			$index = 0;
			foreach($cpts as $cpt) {
				
				if($cpt->id != $id) {
					if($index == $sort) { 
						$index++;								
					}
					$update->sort_order = $index;
					$update->id = $cpt->id;
					$update->update_sort_order();	
					//echo $cpt->id.' - '.$index.'<br>';
					$index++;
				}

			}
		}
		
		die();
	}
	
	/**********************
	* Save the columns for a CPT
	* @author David Rugendyke
	* @since 1.0.1
	***********************/
	public function actionSaveCols($id)
	{
		if(isset($this->post['columns']) && !empty($id)) {
			$update = new CustomPostTypesModel();
			$update->id = $id;
			$update->columns = serialize(array_values($this->post['columns']));
			$update->update_columns();
		}
	}
	
	/**********************
	* Counts the amount of pts currently saved
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function currentPTCount()
	{
		// Load the fields
		$load = new CustomPostTypesModel();
		$load->type = 'custom';
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
		$fields = $this->currentPTCount();
		// Validate the field count
		if($fields >= 2) {
			if(KONTROL_T) {
				$this->actionManage();
			}
		}else{
			return false;
		}
	}
}

?>