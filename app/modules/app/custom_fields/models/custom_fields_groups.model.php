<?php

/**********************
* Database model for the kontrol_cfs_groups table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomFieldsGroupsModel extends KontrolModel
{
	
	private $table_name = '_cfs_groups';
	private $table_groups_pts_name = '_cfs_groups_pts';
	private $data;
	
	public $table;
	public $table_groups_pts;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $key;
	
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
		$this->table_groups_pts = $wpdb->prefix.APP_ID.$this->table_groups_pts_name;
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

		if(!empty($this->key)) {
			$query .= " AND `key` = '".addslashes($this->key)."' ";
		}

		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				 	   ".$query." 
		      ORDER BY name ASC";
		
		if(!empty($this->id)) {
			$results = $this->wpdb->get_row($sql);
		}else{
			$results = $this->wpdb->get_results($sql);	
		}

		return $results;
		
	}
	
	/**********************
	* Returns a list of groups not assigned to post types
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function select_no_post_type() {
		
	
		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE id NOT IN (SELECT group_id FROM ".$this->table_groups_pts.")
		      ORDER BY name ASC";
		
		$results = $this->wpdb->get_results($sql);	
		
		return $results;
		
	}
	
	/**********************
	* Deletes a group
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function delete() {
		
		$query = NULL;
		
		if(!empty($this->id)) {
			$query = " id = '".addslashes($this->id)."' LIMIT 1";
		}
				
		$sql = "DELETE  
				  FROM ".$this->table."  
				 WHERE ".$query."";
		
		$results = $this->wpdb->get_results($sql);
		
		return $results;
	}
	
	/**********************
	* Save/Update a cf group
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save() {
		
		// Required by WP
		$this->data = stripslashes_deep($this->data);
		
		if($this->data) {
					
			$group_name = !isset($this->data['group-name']) ? 'Group Name' : $this->data['group-name'];
			$group_options = !isset($this->data['group-options']) ? '' : $this->data['group-options'];
			//$group_active = !isset($this->data['group-active']) ? '' : $this->data['group-active'];
			
			
			$group_data = array(
							'name' => $group_name, 
							'options' => serialize($group_options)
							);
							
	
			if(empty($this->id)) {
				// Insert now
				$this->wpdb->insert($this->table, $group_data);
				$this->id = $this->wpdb->insert_id;
			}else{
				// Update now
				$this->wpdb->update($this->table, $group_data, array('ID'=>$this->id));
			}

		}
		
		return $this->id;
	}
	
}

?>