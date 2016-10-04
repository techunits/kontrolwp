<?php

/**********************
* Database model for the kontrol_taxonomies table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class TaxonomiesModel
{
	
	private $table_name = '_taxonomies';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $active;
	public $type;
	public $key;
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function __construct($data = NULL) {
		
		global $wpdb;
		$this->wpdb = &$wpdb;
		$this->data = $data;
		$this->table = $wpdb->prefix.APP_ID.$this->table_name;
	}
	
	/**********************
	* Returns a list of taxonomies
	* @author David Rugendyke
	* @param type - the type of taxonomy - native or custom
	* @since 1.0.0
	***********************/
	public function select() {
		
		$query = NULL;
		
		if(!empty($this->id)) {
			$query .= " AND `id` = '".addslashes($this->id)."' ";
		}
		
		if(!empty($this->type)) {
			$query .= " AND `type` = '".addslashes($this->type)."' ";
		}
		
		if(!empty($this->key)) {
			$query .= " AND `tax_key` = '".addslashes($this->key)."' ";
		}
		
		if(isset($this->active)) {
			$query .=  " AND active = ".addslashes($this->active)." ";
		}
		
		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				 	   ".$query." 
		      ORDER BY sort_order ASC";
		
		$results = $this->wpdb->get_results($sql);
		
		
		return $results;
		
	}
	
	/**********************
	* Makes a custom post type visible/hidden
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_visibility() {
		
		if(is_numeric($this->active) && isset($this->id)) {
			// Update now
			$this->wpdb->update($this->table, array('active'=>$this->active), array('ID'=>$this->id));
		}
		
	}
	
	/**********************
	* Updates the sort order
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_sort_order() {
		

		if($this->id) {
			// Update now
			$this->wpdb->update($this->table, array('sort_order'=>$this->sort_order), array('ID'=>$this->id));
		}
		
	}
	
	/**********************
	* Delete a CPT
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function delete() {
		

		if($this->id) {
			// Delete now
			$this->wpdb->query("DELETE FROM ".$this->table." WHERE id = '".addslashes($this->id)."' LIMIT 1");
		}
		
	}
	
	/**********************
	* Save/Update a taxonomy
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save() {
		
		// Required by WP
		$this->data = stripslashes_deep($this->data);
		
		if($this->data) {
			// Make them active by default
			if(empty($this->id)) {
				$this->data['active'] = 1;
			}
			
			// Make them the top sort by default
			if(empty($this->data['sort_order'])) {
				$this->data['sort_order'] = -1;
			}
			
					
			// Convert any 'true', 'false', integer strings to their boolean/integer counterparts
			array_walk_recursive($this->data, 'Kontrol_Tools::array_convert_types');
			
			$new_labels = array();
			
			// Add some extra key IDs to the labels
			foreach($this->data['args']['labels'] as $label => $value) {
				$new_labels[$label] = _x($value,$this->data['key']);		
			}
			
			$tax_data = array(
							'tax_key' => $this->data['key'], 
							'name' => $this->data['args']['labels']['name'],
							'arguments' => serialize($this->data['args']),
							'active' => $this->data['active'],
							'sort_order' => $this->data['sort_order'],
							'type' => 'custom',
							'updated' => time()
							);
							
	
			if(empty($this->id)) {
				// Insert now
				$this->wpdb->insert($this->table, $tax_data);
				$this->id = $this->wpdb->insert_id;
			}else{
				// Update now
				$this->wpdb->update($this->table, $tax_data, array('ID'=>$this->id));
			}
			
			// If the taxonomy key ID has changed, update all posts associated with it if instructed too
			if(isset($this->data['current-key']) && $this->data['current-key'] != $this->data['key']) {
					
					// Now update the posts ID
					$update = new TermTaxonomyModel();
					$update->taxonomy = $this->data['current-key'];
					$update->update_terms_taxonomy_key($this->data['key']);
			}
			
		}
		
		return $this->id;
	}


}

?>