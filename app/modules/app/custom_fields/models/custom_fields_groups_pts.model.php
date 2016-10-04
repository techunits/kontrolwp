<?php

/**********************
* Database model for the kontrol_cfs_groups_pts table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomFieldsGroupsPtsModel
{
	
	private $table_name = '_cfs_groups_pts';
	private $data;
	private $groups_ext = '_cfs_groups';
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	private $cpt_table;
	private $tax_table;
	
	public $id;
	public $group_id;
	public $group_type = 'cf';
	public $active;
	public $pt_key;
	public $sort_order;

	
	public $order_by = 'sort_order';
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
		$this->groups_table = $wpdb->prefix.APP_ID.$this->groups_ext;
	}
	
	/**********************
	* Returns a list of cpts
	* @author David Rugendyke
	* @param type - the type of taxonomy - native or custom
	* @since 1.0.0
	***********************/
	public function select() {
		
		$query = NULL;
		
		if(!empty($this->id)) {
			$query .=  " AND ".$this->table.".id = '".addslashes($this->id)."' ";
		}
		
		if(!empty($this->active)) {
			$query .=  " AND ".$this->table.".active = '".addslashes($this->active)."' ";
		}
			
		if(!empty($this->group_id)) {
			$query .=  " AND group_id = '".addslashes($this->group_id)."' ";
		}
		
		if(!empty($this->group_type)) {
			$query .=  " AND group_type = '".addslashes($this->group_type)."' ";
		}
		
		if(!empty($this->pt_key)) {
			$query .=  " AND post_type_key = '".addslashes($this->pt_key)."' ";
		}
		
		if(!empty($this->order_by)) {
			$query .=  " ORDER BY ".addslashes($this->order_by)." ".addslashes($this->order_by_dir)." ";
		}
		
		
		$sql = "SELECT ".$this->table.".*, 
					   ".$this->groups_table.".id AS group_id,
					   ".$this->groups_table.".name AS group_name, 
					   ".$this->groups_table.".options AS group_options  
				  FROM ".$this->table."  
		     LEFT JOIN ".$this->groups_table." 
				    ON ".$this->table.".group_id = ".$this->groups_table.".id  
				 WHERE 1 = 1
				  	   ".$query."
		      ";
				
		if(!empty($this->id)) {
			$results = $this->wpdb->get_row($sql);
		}else{
			$results = $this->wpdb->get_results($sql);	
		}
		
		return $results;
		
	}
	
	/**********************
	* Makes a custom post type group visible/hidden
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_visibility() 
	{
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
	* Save/Update a post type / group od
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save() {
		
		// Required by WP
		$data = array(
					'group_id' => $this->group_id, 
					'group_type' => $this->group_type, 
					'post_type_key' => $this->pt_key
					);
						
		if(empty($this->id)) {
			// Insert now
			$this->wpdb->insert($this->table, $data);
			return $this->wpdb->insert_id;
		}else{
			// Update now
			$this->wpdb->update($this->table, $data, array('ID'=>$this->id));
		}
			
		
	}


	/**********************
	* Deletes a list of taxonomies and cpt combinations
	* @author David Rugendyke
	* @param type - the type of taxonomy - native or custom
	* @since 1.0.0
	***********************/
	public function delete() {
		
		$query = NULL;
		
		if(!empty($this->id)) {
			$query = " id = '".addslashes($this->id)."' LIMIT 1";
		}
				
		if(!empty($this->group_id)) {
			$query = " group_id = '".addslashes($this->group_id)."' ";
		}
		
		$sql = "DELETE  
				  FROM ".$this->table."  
				 WHERE ".$query."";
		
		$results = $this->wpdb->get_results($sql);
		
		return $results;
	}
}

?>