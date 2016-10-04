<?php

/**********************
* Installs, Uninstalls a Kontrol module - Custom Fields
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

$module_name = 'cf';
$module_version = '1.1';



// **** The custom fields types table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cfs_types";

$sql = "CREATE TABLE " . $table_name . " (
			 id INT( 7 ) NOT NULL AUTO_INCREMENT,
			 name VARCHAR( 150 ) NOT NULL,
			 cf_key VARCHAR( 20 ) NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";

dbDelta($sql);

		
// CF Types
$table_data = array();
$table_data[] = array('name' => 'Text', 'cf_key' => 'text');
$table_data[] = array('name' => 'Text Area', 'cf_key' => 'text-area');
$table_data[] = array('name' => 'Wysiwyg Editor', 'cf_key' => 'wysiwyg');
$table_data[] = array('name' => 'Image', 'cf_key' => 'image');
$table_data[] = array('name' => 'File', 'cf_key' => 'file');
$table_data[] = array('name' => 'Date Picker', 'cf_key' => 'date');
$table_data[] = array('name' => 'Repeatable', 'cf_key' => 'repeatable');
$table_data[] = array('name' => 'Colour Picker', 'cf_key' => 'colour');
$table_data[] = array('name' => 'Select', 'cf_key' => 'select');
$table_data[] = array('name' => 'Checkbox', 'cf_key' => 'checkbox');
$table_data[] = array('name' => 'Radio Button', 'cf_key' => 'radio');
$table_data[] = array('name' => 'True / False', 'cf_key' => 'boolean');
$table_data[] = array('name' => 'Page Link / Object', 'cf_key' => 'page-link');
//$table_data[] = array('name' => 'Google Maps', 'cf_key' => 'gmaps');

foreach($table_data as $data) {
	// Check to see if we have these rows in the table already
	$sql = "SELECT * FROM ".$table_name." WHERE cf_key = '".$data['cf_key']."' LIMIT 1";
	$results = $this->wpdb->get_results($sql);
			
	if(count($results) == 0) {
		// Add the modules to the table
		$this->wpdb->insert($table_name, $data);
	}
}



// **** The custom fields groups table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cfs_groups";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			name VARCHAR( 150 ) NOT NULL,
			options TEXT NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";
		
dbDelta($sql);


// **** The custom fields rules table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cfs_rules";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			group_id INT( 9 ) NOT NULL,
			field_id INT( 9 ) NOT NULL,
			param VARCHAR( 150 ) NOT NULL,
			operator VARCHAR( 10 ) NOT NULL,
			value VARCHAR( 200 ) NOT NULL,
			cond VARCHAR( 10 ) NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";
		
dbDelta($sql);

// Add indexs - Check to see if the index exists first, so we don't double up
if(!$this->index_key_exists($table_name, 'group_id')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( group_id )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( field_id )");
}

// Add foreign keys - Check to see if they exist first, so we don't double up
if(!$this->foreign_key_exists($table_name, 'group_id', $this->wpdb->prefix.APP_ID."_cfs_groups", 'id')) {
	$sql = "ALTER TABLE ".$table_name." ADD FOREIGN KEY ( group_id ) REFERENCES ".$this->wpdb->prefix.APP_ID."_cfs_groups (id) ON DELETE CASCADE ON UPDATE CASCADE;";
	dbDelta($sql);
}



// **** The custom fields table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cfs_fields";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			group_id INT( 9 ) NOT NULL,
			parent_id INT( 9 ) NOT NULL DEFAULT '0',
			name VARCHAR( 250 ) NOT NULL,
			field_key VARCHAR( 250 ) NOT NULL,
			field_type VARCHAR( 250 ) NOT NULL,
			rule_type VARCHAR( 50 ) NOT NULL,
			validation TEXT NOT NULL,
			settings TEXT NOT NULL,
			instructions TEXT NOT NULL, 
			active TINYINT( 1 ) NOT NULL DEFAULT '1',
			sort_order INT( 7 ) NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";
		
dbDelta($sql);

// Add indexs - Check to see if the index exists first, so we don't double up
if(!$this->index_key_exists($table_name, 'group_id')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( group_id )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( parent_id )");
}

// Add foreign keys - Check to see if they exist first, so we don't double up
if(!$this->foreign_key_exists($table_name, 'group_id', $this->wpdb->prefix.APP_ID."_cfs_groups", 'id')) {
	$sql = "ALTER TABLE ".$table_name." ADD FOREIGN KEY ( group_id ) REFERENCES ".$this->wpdb->prefix.APP_ID."_cfs_groups (id) ON DELETE CASCADE ON UPDATE CASCADE;";
	dbDelta($sql);
}

// **** The custom fields x post types table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cfs_groups_pts";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			group_id INT( 9 ) NOT NULL,
			group_type VARCHAR( 5 ) NOT NULL DEFAULT 'cf',
			post_type_key VARCHAR( 250 ) NOT NULL,
			sort_order INT( 7 ) NOT NULL,
			active TINYINT( 1 ) NOT NULL DEFAULT '1',
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";
		
dbDelta($sql);

// Add indexs - Check to see if the index exists first, so we don't double up
// 1.0.0
if(!$this->index_key_exists($table_name, 'post_type_key')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( post_type_key )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( group_id )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( active )");
}
// 1.0.2
if(!$this->index_key_exists($table_name, 'group_type')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( group_type )");
}

// Add foreign keys - Check to see if they exist first, so we don't double up
if(!$this->foreign_key_exists($table_name, 'group_id', $this->wpdb->prefix.APP_ID."_cfs_groups", 'id')) {
	$sql = "ALTER TABLE ".$table_name." ADD FOREIGN KEY ( group_id ) REFERENCES ".$this->wpdb->prefix.APP_ID."_cfs_groups (id) ON DELETE CASCADE ON UPDATE CASCADE;";
	dbDelta($sql);
}




		
		
		
		