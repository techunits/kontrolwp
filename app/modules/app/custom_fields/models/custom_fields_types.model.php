<?php

/**********************
* Database model for the kontrol_cfs_types table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomFieldsTypesModel extends KontrolModel
{
	
	private $table_name = '_cfs_types';
	private $data;
	
	public $table;
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
			$query .= " AND `cf_key` = '".addslashes($this->key)."' ";
		}

		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				 	   ".$query." 
		      ORDER BY name ASC";
		
		$results = $this->wpdb->get_results($sql);
		
		if(count($results) == 1) {
			return $results[0];
		}else{
			return $results;	
		}

		return $results;
		
	}
	
}

?>