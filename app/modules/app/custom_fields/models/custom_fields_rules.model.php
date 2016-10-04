<?php

/**********************
* Database model for the kontrol_cfs_rules table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class CustomFieldsRulesModel extends KontrolModel
{
	
	private $table_name = '_cfs_rules';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $group_id = 0;
	public $field_id = 0;

	
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
		
		if(!empty($this->group_id)) {
			$query .= " AND `group_id` = '".addslashes($this->group_id)."' ";
		}

		if(isset($this->field_id)) {
			$query .= " AND `field_id` = '".addslashes($this->field_id)."' ";
		}

		$sql = "SELECT *  
				  FROM ".$this->table."  
				 WHERE 1 = 1
				 	   ".$query."";
		
		$results = $this->wpdb->get_results($sql);	
		
		return $results;
		
	}
	
	/**********************
	* Delete a rule
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function delete() {
	
		if(!empty($this->group_id)) {
			// Delete now
			$this->wpdb->query("DELETE FROM ".$this->table." WHERE group_id = '".addslashes($this->group_id)."'");
		}
		if(!empty($this->field_id)) {
			// Delete now
			$this->wpdb->query("DELETE FROM ".$this->table." WHERE field_id = '".addslashes($this->field_id)."'");
		}
	}
	
	/**********************
	* Save/Update a cf rules
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function save($rule_set) {
		
		// Required by WP
		$this->data = stripslashes_deep($this->data);
		
		if($this->data && (!empty($this->group_id) || !empty($this->field_id))) {
			
			//echo '<br><br>';
			//echo '<pre>';
			//print_r($rule_set);
			//echo '</pre>';
			
			for($i=0; $i < count($rule_set['param']); $i++) {
				  // Rule 		
				  $rules_data = array(
							'group_id' => $this->group_id,
							'field_id' => $this->field_id, 
							'param' => $rule_set['param'][$i],
							'operator' => $rule_set['operator'][$i],
							'value' => $rule_set['value'][$i],
							'cond' => $rule_set['cond']
							);
				  // Insert now
				  $this->wpdb->insert($this->table, $rules_data);
			}
		}
	}
	
}

?>