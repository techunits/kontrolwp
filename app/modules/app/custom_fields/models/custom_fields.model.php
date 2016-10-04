<?php

/**********************
* Database model for the kontrol_cfs_fields table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomFieldsModel extends KontrolModel
{
	
	private $table_name = '_cfs_fields';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $active;
	public $group_id;
	public $parent_id = 0;
	public $field_key;
	public $sort_order;
	public $order_by = 'sort_order, name';
	public $order_by_dir = 'ASC';
	public $limit = NULL;

	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function __construct($data = NULL) {
		
		global $wpdb;
		
		$this->wpdb = $wpdb;
		$this->data = $data;
		$this->table = $wpdb->prefix.APP_ID.$this->table_name;
	}
	
	/**********************
	* Returns a list of cf types
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function select() {
		
		$query = NULL;
		
			
		if(!empty($this->id)) {
			$query .= " AND `id` = '".addslashes($this->id)."' ";
		}
		
		if(isset($this->active)) {
			$query .=  " AND active = ".addslashes($this->active)." ";
		}
		
		if(isset($this->parent_id)) {
			$query .=  " AND parent_id = ".addslashes($this->parent_id)." ";
		}

		if(!empty($this->group_id)) {
			$query .= " AND `group_id` = '".addslashes($this->group_id)."' ";
		}
		
		if(!empty($this->field_key)) {
			$query .= " AND `field_key` = '".addslashes($this->field_key)."' ";
		}
		
		if(isset($this->order_by)) {
			$query .=  " ORDER BY ".addslashes($this->order_by)." ".addslashes($this->order_by_dir)." ";
		}
		
		if(isset($this->limit)) {
			$query .=  " LIMIT ".addslashes($this->limit)." ";
		}
		

		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				 	   ".$query."";
		
							   
		if(!empty($this->id) || !empty($this->field_key)) {
			$results = $this->wpdb->get_row($sql);
		}else{
			$results = $this->wpdb->get_results($sql);	
		}

		return $results;
		
	}
	
	/**********************
	* Makes a field visible/hidden
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_visibility() {
		
		if(is_numeric($this->active) && !empty($this->id)) {
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
	* Delete a field
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function delete() {

		if($this->id || $this->group_id) {
			
			$query = NULL;
			
			if(!empty($this->id)) {
				$query .= " AND `id` = '".addslashes($this->id)."' ";
			}
			
			if(isset($this->group_id)) {
				$query .=  " AND group_id = '".addslashes($this->group_id)."' ";
			}
			
			if(!empty($query)) {
				// Delete now
				$this->wpdb->query("DELETE FROM ".$this->table." WHERE 1 = 1 ".$query."");
			}
		}
		
	}
	
	/**********************
	* Save/Update a cf 
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save() {
		
		// Required by WP
		$this->data = stripslashes_deep($this->data);
		
		$id = $this->id;
		
		if($this->data && !empty($this->group_id)) {

		
			array_walk_recursive($this->data, 'Kontrol_Tools::array_convert_types');
			
			// Its a sub repeatable field with no rules
			if(!isset($this->data['rules-type']) && $this->data['parent_id'] > 0) {
				$this->data['rules-type'] = 'parent';
			}

			// CF 		
			$cf_data = array(
					  'group_id' => $this->group_id, 
					  'parent_id' => $this->data['parent_id'],
					  'name' => $this->data['name'],
					  'field_key' => $this->data['key'],
					  'field_type' => $this->data['type'],
					  'rule_type' => $this->data['rules-type'],
					  'validation' => serialize($this->data['validation']),
					  'settings' => serialize($this->data['settings']),
					  'instructions' => $this->data['instructions'],
					  'sort_order' => $this->sort_order,
					  'active' => $this->data['active']
					  );
			
			if(empty($id)) {
				// Insert now
				$this->wpdb->insert($this->table, $cf_data);
				$this->id = $this->wpdb->insert_id;
			}else{
				// Update now
				$this->wpdb->update($this->table, $cf_data, array('ID'=>$id));
			}
			
		}
		
		return $this->id;
	}
	
}

?>