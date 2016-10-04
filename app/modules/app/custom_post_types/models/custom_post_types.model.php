<?php

/**********************
* Database model for the kontrol_cpts table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomPostTypesModel
{
	
	private $table_name = '_cpts';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $active;
	public $columns;
	public $key;
	public $type = 'custom';
	public $type_ignore = FALSE;
	public $sort_order;
	public $dont_sort = FALSE;
	public $order_by;
	public $order_by_dir = 'ASC';
	
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
	* Returns a list of cpts
	* @author David Rugendyke
	* @param type - the type of taxonomy - native or custom
	* @since 1.0.0
	***********************/
	public function select() {
		
		$query = NULL;
		
		if(empty($this->order_by) && $this->dont_sort == FALSE) {
			$this->order_by = 'sort_order, name';	
		}
		
		if(!empty($this->id)) {
			$query .=  " AND id = '".addslashes($this->id)."' ";
		}
		
		if(isset($this->active)) {
			$query .=  " AND active = ".addslashes($this->active)." ";
		}
		
		if(!empty($this->key)) {
			$query .= " AND `cpt_key` = '".addslashes($this->key)."' ";
		}
		
		if(!$this->type_ignore) {
			if(isset($this->type) && !empty($this->type)) {
				$query .=  " AND type = '".addslashes($this->type)."' ";
			}
		}
		
		if(isset($this->order_by)) {
			$query .=  " ORDER BY ".$this->order_by." ".$this->order_by_dir." ";
		}
		
		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				  	   ".$query."
		      ";
		
		//echo $sql;
		$results = $this->wpdb->get_results($sql, $this->results_type);
		
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
	* Updates the columns 
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_columns() {
		

		if($this->id) {
			// Update now
			$this->wpdb->update($this->table, array('columns'=>$this->columns), array('ID'=>$this->id));
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
	* Save/Update a custom post type
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save() {
		
		// Required by WP
		$this->data = stripslashes_deep($this->data);
		
		if($this->data) {
			// Make them active by default
			if(!empty($this->id)) {
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
			
			$cpt_data = array(
							'cpt_key' => $this->data['key'], 
							'name' => $this->data['args']['labels']['name'],
							'arguments' => serialize($this->data['args']),
							'active' => $this->data['active'],
							'sort_order' => $this->data['sort_order'],
							'type' => 'custom',
							'updated' => time()
							);
							
	
			if(empty($this->id)) {
				// Insert now
				$this->wpdb->insert($this->table, $cpt_data);
				$this->id = $this->wpdb->insert_id;
			}else{
				// Update now
				$this->wpdb->update($this->table, $cpt_data, array('ID'=>$this->id));
			}
			
			// If the post type key ID has changed, update all posts associated with it if instructed too
			if(isset($this->data['current-key']) && $this->data['current-key'] != $this->data['key']) {
					
					// Now update the posts ID
					$update = new PostsModel();
					$update->post_type_id = $this->data['current-key'];
					$update->update_post_type_id($this->data['key']);
			}
			
		}
		
		return $this->id;
	}

}

?>