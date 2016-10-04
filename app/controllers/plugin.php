<?php

/**********************
* Installs, Uninstalls - Kontrol Plugin
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class PluginController extends Lvc_PageController
{
	
	private $app_version;
	private $db_version;
	
	public $wpdb;
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		global $wpdb;
		$this->wpdb = $wpdb; 
		
		// Needed to perform the DB operations
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		// Check to see if we already have an installed version of Kontrol, return 1.0 if we don't
		$this->app_version = get_option('kontrol_version', APP_VER);
		
	}
	
	
	/**********************
	* Installation
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function actionInstall() {
		
		// Don't output anything during installation
		$this->loadDefaultView = false;
		$table_data = array();
		
		// Check for a verify cache option
		$cache = get_option('kontrol_verify_cache');
		if(empty($cache)) {
			update_option('kontrol_verify_cache', '');
		}
				
		// Loop through each module and run their install file to create their DB tables - each module should save it's version number in the DB too
	    foreach(glob(APP_MODULE_PATH.'*/install/install.php', GLOB_NOSORT) as $install) {  
			  require_once($install);
			  // Update the version of this module now
			  update_option("kontrol_module_".$module_name, $module_version);	

		}	
		
		// Update with the current version
	    update_option("kontrol_version", APP_VER);

	}
	
	/**********************
	* Performs a index key check on a table to see if it already exists
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function index_key_exists($table, $key_name) {
		
		$sql = "SELECT COUNT(1) FROM INFORMATION_SCHEMA.STATISTICS WHERE table_schema = '".$this->wpdb->dbname."' AND table_name = '".$table."' AND index_name = '".$key_name."'";
		$check = $this->wpdb->get_var($sql);
		
		if(!empty($check)) {
			return TRUE;
		}else{
			return FALSE;	
		}

	}
	
	/**********************
	* Performs a foreign key check on a table to see if it already exists
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function foreign_key_exists($table, $column, $f_table, $f_column) {
		
		$sql = "SELECT COUNT(1) FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE `CONSTRAINT_SCHEMA` = '".$this->wpdb->dbname."' AND `TABLE_NAME` = '".$table."' AND `COLUMN_NAME` = '".$column."' AND `REFERENCED_TABLE_SCHEMA` = '".$this->wpdb->dbname."' AND `REFERENCED_TABLE_NAME` = '".$f_table."' AND `REFERENCED_COLUMN_NAME` = '".$f_column."'";
		$check = $this->wpdb->get_var($sql);
		
		//echo $sql.'<p>'.$check;
		
		if(!empty($check)) {
			return TRUE;
		}else{
			return FALSE;	
		}

	}
	
	
	
	

}

?>