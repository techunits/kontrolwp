<?php

/**********************
* Database model for the posts table
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class PostsModel
{
	
	private $table_name = 'posts';
	private $data;
	
	public $table;
	public $wpdb;
	public $results_type = OBJECT;
	
	public $id;
	public $post_type_id;
	
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
	* Update a set of posts to a new post type ID
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function update_post_type_id($new_post_type_id) {
		
		// Only update posts if the id is set and has changed
		if(!empty($new_post_type_id) && $new_post_type_id != $this->post_type_id) {			
			// Update now
			$this->wpdb->update($this->table, array('post_type'=>stripslashes($new_post_type_id)), array('post_type'=>$this->post_type_id));
		}
	}

}

?>