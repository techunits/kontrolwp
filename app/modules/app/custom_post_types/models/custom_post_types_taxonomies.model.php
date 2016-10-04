<?php

/**********************
* Database model for the kontrol_cpts_taxs table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomPostTypesTaxonomiesModel
{
	
	private $table_name = '_cpts_taxs';
	private $data;
	private $cpt_ext = '_cpts';
	private $tax_ext = '_taxonomies';
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	private $cpt_table;
	private $tax_table;
	
	public $id;
	public $cpt_id;
	public $tax_id;
	public $tax_type;
	public $cpt_type;
	public $tax_active;
	public $cpt_active;
	public $tax_args;
	public $cpt_args;
	public $tax_key;
	public $cpt_key;
	
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
		$this->cpt_table = $wpdb->prefix.APP_ID.$this->cpt_ext;
		$this->tax_table = $wpdb->prefix.APP_ID.$this->tax_ext;
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
			$query .=  " AND id = '".addslashes($this->id)."' ";
		}
		
		if(!empty($this->cpt_id)) {
			$query .=  " AND cpt_id = '".addslashes($this->cpt_id)."' ";
		}
		
		if(!empty($this->tax_id)) {
			$query .=  " AND tax_id = '".addslashes($this->tax_id)."' ";
		}
		
		if(!empty($this->tax_type)) {
			$query .=  " AND ".$this->tax_table.".type = '".addslashes($this->tax_type)."' ";
		}
		
		if(!empty($this->cpt_type)) {
			$query .=  " AND ".$this->cpt_table.".type = '".addslashes($this->cpt_type)."' ";
		}
		
		if(!empty($this->tax_active)) {
			$query .=  " AND ".$this->tax_table.".active = ".$this->tax_active;
		}
		
		if(!empty($this->cpt_active)) {
			$query .=  " AND ".$this->cpt_table.".active = ".$this->cpt_active;
		}
		
		if(isset($this->order_by)) {
			$query .=  " ORDER BY ".$this->order_by." ".$this->order_by_dir." ";
		}
		
		
		$sql = "SELECT ".$this->table.".*, 
					   ".$this->tax_table.".type AS tax_type, 
					   ".$this->tax_table.".tax_key AS tax_key, 
					   ".$this->tax_table.".name AS tax_name, 
					   ".$this->tax_table.".active AS tax_active, 
					   ".$this->tax_table.".arguments AS tax_arguments, 
					   ".$this->cpt_table.".type AS cpt_type, 
					   ".$this->cpt_table.".cpt_key AS cpt_key,
					   ".$this->cpt_table.".name AS cpt_name,
					   ".$this->cpt_table.".active AS cpt_active,
					   ".$this->cpt_table.".arguments AS cpt_arguments
				  FROM ".$this->table."  
		     LEFT JOIN ".$this->tax_table." 
				    ON ".$this->table.".tax_id = ".$this->tax_table.".id  
			 LEFT JOIN ".$this->cpt_table." 
				    ON ".$this->table.".cpt_id = ".$this->cpt_table.".id  
				 WHERE 1 = 1
				  	   ".$query."
		      ";
			  
		//echo $sql;
				
		$results = $this->wpdb->get_results($sql, $this->results_type);
		
		return $results;
		
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
			
			$cpt_data = array(
							'cpt_id' => $this->cpt_id, 
							'tax_id' => $this->tax_id
							);
							
			if(empty($this->id)) {
				// Insert now
				$this->wpdb->insert($this->table, $cpt_data);
			}else{
				// Update now
				$this->wpdb->update($this->table, $cpt_data, array('ID'=>$this->id));
			}
			
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
		
		if(!empty($this->cpt_id)) {
			$query .= " `cpt_id` = '".addslashes($this->cpt_id)."' ";
		}
		
		if(!empty($this->tax_id)) {
			$query .= " `tax_id` = '".addslashes($this->tax_id)."' ";
		}
		
		$sql = "DELETE  
				  FROM ".$this->table."  
				 WHERE ".$query."";
		
		$results = $this->wpdb->get_results($sql);
		
		return $results;
	}
}

?>