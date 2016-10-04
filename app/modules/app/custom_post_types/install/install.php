<?php

/**********************
* Installs, Uninstalls a Kontrol module  - Custom Post Types & Taxonomies
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

$module_name = 'cpt_tax';
$module_version = '1.0.1';

// **** The cpt table ******************************
$table_name = $this->wpdb->prefix.APP_ID."_cpts";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			cpt_key VARCHAR( 20 ) NOT NULL,
			name VARCHAR( 150 ) NOT NULL,
			arguments TEXT NOT NULL,
			columns TEXT NOT NULL,
			active TINYINT( 1 ) NOT NULL DEFAULT '1',
			type VARCHAR( 20 ) NOT NULL,
			sort_order INT( 7 ) NOT NULL,
			updated INT NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";

dbDelta($sql);

// Add indexs - Check to see if the index exists first, so we don't double up
if(!$this->index_key_exists($table_name, 'active')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( active )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( sort_order )");
}

// Add native objects
$table_data = array();
$table_data[] = array('name' => 'Post', 'cpt_key' => 'post', 'type' => 'native', 'sort_order' => 0, 'updated' => time());
$table_data[] = array('name' => 'Page', 'cpt_key' => 'page', 'type' => 'native', 'sort_order' => 1, 'updated' => time());
$table_data[] = array('name' => 'Media Page', 'cpt_key' => 'mediapage', 'type' => 'native', 'sort_order' => 2, 'updated' => time());
$table_data[] = array('name' => 'Attachment', 'cpt_key' => 'attachment', 'type' => 'native', 'sort_order' => 3, 'updated' => time());
$table_data[] = array('name' => 'Revision', 'cpt_key' => 'revision', 'type' => 'native', 'sort_order' => 4, 'updated' => time());
$table_data[] = array('name' => 'Nav Menu Item', 'cpt_key' => 'nav_menu_item', 'type' => 'native', 'sort_order' => 5, 'updated' => time());

foreach($table_data as $data) {
	// Check to see if we have these taxonomies in the table already
	$sql = "SELECT * FROM ".$table_name." WHERE cpt_key = '".$data['cpt_key']."' AND type = 'native' LIMIT 1";
	$results = $this->wpdb->get_results($sql);
			
	if(count($results) == 0) {
		// Add the modules to the table
		$this->wpdb->insert($table_name, $data);
	}
}


// **** The taxonomies table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_taxonomies";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 7 ) NOT NULL AUTO_INCREMENT,
			name VARCHAR( 150 ) NOT NULL,
			tax_key VARCHAR( 20 ) NOT NULL,
			arguments TEXT NOT NULL,
			active TINYINT( 1 ) NOT NULL DEFAULT '1',
			type VARCHAR( 20 ) NOT NULL,
			sort_order INT( 7 ) NOT NULL,
			updated INT NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";

dbDelta($sql);

// Add indexs - Check to see if the index exists first, so we don't double up
if(!$this->index_key_exists($table_name, 'active')) {
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( active )");
	$this->wpdb->get_results("ALTER TABLE " . $table_name . " ADD INDEX ( sort_order )");
}


// Add native taxonomies
$table_data = array();
$table_data[] = array('name' => 'Categories', 'tax_key' => 'category', 'type' => 'native', 'sort_order' => 0, 'updated' => time());
$table_data[] = array('name' => 'Post Tags', 'tax_key' => 'post_tag', 'type' => 'native', 'sort_order' => 1, 'updated' => time());

foreach($table_data as $data) {
	// Check to see if we have these taxonomies in the table already
	$sql = "SELECT * FROM ".$table_name." WHERE tax_key = '".$data['tax_key']."' AND type = 'native' LIMIT 1";
	$results = $this->wpdb->get_results($sql);
			
	if(count($results) == 0) {
		// Add the modules to the table
		$this->wpdb->insert($table_name, $data);
	}
}


// **** The cpt x taxonomies table ***********************
$table_name = $this->wpdb->prefix.APP_ID."_cpts_taxs";

$sql = "CREATE TABLE " . $table_name . " (
			id INT( 9 ) NOT NULL AUTO_INCREMENT,
			cpt_id INT( 9 ) NOT NULL,
			tax_id INT( 9 ) NOT NULL,
			PRIMARY KEY  (id)
		) ENGINE = InnoDB DEFAULT CHARSET=utf8;";

dbDelta($sql);


// Add foreign keys - Check to see if they exist first, so we don't double up
if(!$this->foreign_key_exists($table_name, 'cpt_id', $this->wpdb->prefix.APP_ID."_cpts", 'id')) {
	$sql = "ALTER TABLE ".$table_name." ADD FOREIGN KEY ( cpt_id ) REFERENCES ".$this->wpdb->prefix.APP_ID."_cpts (id) ON DELETE CASCADE ON UPDATE CASCADE;";
	dbDelta($sql);
	$sql = "ALTER TABLE ".$table_name." ADD FOREIGN KEY ( tax_id ) REFERENCES ".$this->wpdb->prefix.APP_ID."_taxonomies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
	dbDelta($sql);
}

	