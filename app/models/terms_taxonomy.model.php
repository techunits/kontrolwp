<?php

/**********************
* Database model for the term_taxonomy table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class TermTaxonomyModel
{
	
	private $table_name = 'term_taxonomy';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $taxonomy;
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function __construct($data = NULL) {
		
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->data = $data;
		$this->table = $wpdb->prefix.$this->table_name;
	}
	
		
	/**********************
	* Update a taxonomy key
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_terms_taxonomy_key($taxonomy) {
		
		// Only update posts if the id is set and has changed
		if(!empty($taxonomy) && $taxonomy != $this->taxonomy) {			
			// Update now
			$this->wpdb->update($this->table, array('taxonomy'=>stripslashes($taxonomy)), array('taxonomy'=>$this->taxonomy));
		}
	}

}

?>