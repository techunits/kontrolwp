<?php
/**********************
* Controls the taxonomies core 
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class TaxonomiesController extends AdminController
{
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		// Load the model
		KontrolModel::load('taxonomies', $this->controllerName);		
		
		// Current Taxes
		$this->setVar('tax_count', $this->currentTaxCount());
	
	}
	
			
	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		// See if we have an active taxonomies, send to add new if we dont
		$taxs = new TaxonomiesModel();
		$taxs->type = 'custom';
		$results = $taxs->select();
		
		//if(count($results) > 0) {
			$this->actionManage();
			$this->setVar('action', 'manage');
		//}else{
		//	$this->actionAdd();
		//	$this->setVar('action', 'add');
		//}
		
	}
	
	
	/**********************
	* Manage taxonomies
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionManage()
	{
		// Page layout for this controller
		$this->controller_layout = 'tax-manage';
		
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
			
		// Init the taxonomies/cpt model
		$load = new CustomPostTypesTaxonomiesModel();
		
		// Get all the active custom taxonomies
		$tax = new TaxonomiesModel();
		$tax->type = 'custom';
		$tax_active = $tax->select();
		
		$data = array();
		
		if(is_array($tax_active)) {
			foreach($tax_active as $tax) {
				
				$tax->args = unserialize($tax->arguments);
				$load->tax_id = $tax->id;
				$data[] = array('tax' => $tax, 'post_types' => $load->select());
			}
		}
		
		
		$this->setVar('tax_custom', $data);
		
		$data = array();
		
		// Get all the active custom taxonomies
		$tax = new TaxonomiesModel();
		$tax->type = 'native';
		$tax_hidden = $tax->select();
		
		if(is_array($tax_hidden)) {
			foreach($tax_hidden as $tax) {
				
				$tax->args = unserialize($tax->arguments);
				$tax->obj = get_taxonomy($tax->tax_key);
				$load->tax_id = $tax->id;
				$data[] = array('tax' => $tax, 'post_types' => $load->select());
			}
		}
		
		$this->setVar('tax_native', $data);
	}
	
	/**********************
	* Add a new taxonomy
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionAdd()
	{
		
		// Check ver
		$this->checkVer();
		// Set the view for this action
		$this->controller_layout = 'tax-add-edit-form';
		
		// Load required models
		KontrolModel::load('custom_post_types', $this->controllerName);
		
		// Get all the native post types
		$cpts = new CustomPostTypesModel();
		$cpts->type = 'native';
		$this->setVar('pt_native', $cpts->select());
		
		// Get all the custom post types
		$cpts = new CustomPostTypesModel();
		$cpts->type = 'custom';
		$this->setVar('pt_custom', $cpts->select());
		
	}
	
	/**********************
	* Edit a taxonomy
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionEdit($id)
	{
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);
		
		// Set the view for this action
		$this->controller_layout = 'tax-add-edit-form';
		
		// Load required models
		KontrolModel::load('custom_post_types', $this->controllerName);
		// Get all the native post types
		$cpts = new CustomPostTypesModel();
		$cpts->type = 'native';
		$this->setVar('pt_native', $cpts->select());
		
		// Get all the custom post types
		$cpts = new CustomPostTypesModel();
		$cpts->type = 'custom';
		$this->setVar('pt_custom', $cpts->select());
		
		// Get all post types attached to this taxonomy
		$load = new CustomPostTypesTaxonomiesModel();
		$load->tax_id = $id;
		$load->order_by = 'cpt_name';
		$this->setVar('attached_post_types', $load->select());
		
		// Get the taxonomy
		$tax = new TaxonomiesModel();
		
		if(!empty($id)) {
			$tax->id = $id;
			$result = $tax->select();
			
			$tax = $result[0];
			$tax->args = unserialize($tax->arguments);
			
			$this->setVar('tax', $tax);
		}else{
			$this->actionAdd();
		}
		
	}
	
	/**********************
	* Save/Update custom taxonomy
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSave($id = NULL)
	{
		
		// Load the required models
		KontrolModel::load('terms_taxonomy', $this->controllerName);	
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
		KontrolModel::load('custom_post_types', $this->controllerName);
			
		// Save/Update the Custom Post Type
		$save = new TaxonomiesModel($this->post);
		if(!empty($id)) {
			$save->id = $id;
		}
		
		$id = $save->save();
		
		// Remove all associated cpts first
		$del = new CustomPostTypesTaxonomiesModel();
		$del->tax_id = $id;
		$del->delete();
				
		// Save the selected post type objects
		if(isset($this->post['args']['post_types']) && count($this->post['args']['post_types']) > 0) {
			$save = new CustomPostTypesTaxonomiesModel($this->post);
			$save->tax_id = $id;
			foreach($this->post['args']['post_types'] as $pt) {
				// Get the cpt id
				$load = new CustomPostTypesModel();
				$load->type = '';
				$load->key = $pt;
				$cpt_ob = $load->select();
				$save->cpt_id = $cpt_ob[0]->id;
				$save->save();
			}
		}
		
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Save Complete','kontrolwp'), __('Taxonomy Successfully Updated.','kontrolwp'));
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
		$update = new TaxonomiesModel();
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
		$alert->set_message(__('Updated','kontrolwp'), __('Taxonomy','kontrolwp').' <span>'.$cpt[0]->name.'</span> '.__('Made','kontrolwp').' '.$msg.'.');
		// Redirect now
		$this->redirect(URL_WP_OPTIONS_PAGE.'&url='.$this->controllerName);

	}
	
	/**********************
	* Delete the Taxonomy
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionDelete($id)
	{
		
		$delete = new TaxonomiesModel();
		$delete->id = $id;
		$cpt = $delete->select();
		$delete->delete();	
					
		// Display a Kontrol update message
		$alert = new Kontrol_Alert();
		$alert->set_message(__('Updated','kontrolwp'), __('Taxonomy','kontrolwp').' <span>'.$cpt[0]->name.'</span> '.__('Deleted','kontrolwp'));
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
		$update = new TaxonomiesModel();
		$update->id = $id;
		$update->sort_order = $sort;
		$update->update_sort_order();
		
		// Get the taxonomy
		$tax = $update->select();
								
		// Now get all the other rows and resort them
		$update = new TaxonomiesModel();
		$update->type = 'custom';
		$update->active = $tax[0]->active;
		$taxs = $update->select();
		if(!empty($taxs)) {
			$index = 0;
			foreach($taxs as $tax) {
				
				if($tax->id != $id) {
					if($index == $sort) { 
						$index++;								
					}
					$update->sort_order = $index;
					$update->id = $tax->id;
					$update->update_sort_order();	
					//echo $tax->id.' - '.$index.'<br>';
					$index++;
				}

			}
		}
		
		die();
	}
	
	/**********************
	* Counts the amount of taxs currently saved
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	private function currentTaxCount()
	{
		// Load the fields
		$load = new TaxonomiesModel();
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
		$fields = $this->currentTaxCount();
		// Validate the field count
		if($fields >= 4) {
			if(KONTROL_T) {
				$this->actionManage();
			}
		}else{
			return false;
		}
	}
	
}

?>