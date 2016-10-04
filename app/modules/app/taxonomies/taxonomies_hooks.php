<?php
/**********************
* Controls the taxonomies hooks
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class TaxonomiesHooksController extends HookController
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
			
	}
	
	/**********************
	* The controller will add any hooks it needs to here for the WP environment - is called everytime the app runs
	* @author David Rugendyke
	* @param: ob - Reference of $this
	* @since 1.0.0
	***********************/
	public function actionSetHooks()
	{
		add_action('init', array(&$this,'setTaxonomies'));
	}
	
	/**********************
	* Sets the custom taxonomies - native ones are set in the custom post types controller as part of the post type
	* @author David Rugendyke
	* @param: ob - Reference of $this
	* @since 1.0.0
	***********************/
	public function setTaxonomies()
	{
		// echo ' TAX HOOKS! ';
		
		// Load the model
		KontrolModel::load('custom_post_types_taxonomies', $this->controllerName);	
		
		// Get all the active taxonomies
		$load = new TaxonomiesModel();
		$load->active = 1;
		$load->type = 'custom';
		$taxs = $load->select();
		
		if(is_array($taxs) && count($taxs) > 0) {
			foreach($taxs as $tax) {
				$pt_attached = array();
				// Now get each ones assigned post types 
				$load = new CustomPostTypesTaxonomiesModel();
				$load->tax_id = $tax->id;
				$load->cpt_active = 1;
				$pts = $load->select();
				
				if(is_array($pts) && count($pts) > 0) {
					foreach($pts as $pt) {
						$pt_attached[] = $pt->cpt_key;
					}
				}
				
				$args = unserialize($tax->arguments);
				
				/*
				echo 'TAX KEY: '.$tax->key;
				echo '<pre>';
				print_r($args);
				print_r($pt_attached);
				echo '</pre>';
				*/

				register_taxonomy($tax->tax_key, $pt_attached, $args);
			}
		}

	}
	
}

?>