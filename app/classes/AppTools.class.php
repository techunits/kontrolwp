<? 
/**********************
* General tools
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class Kontrol_Tools 
{

	
	/**********************
	* Returns the max post size in bytes
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function return_post_max($type = 'bytes') {
		
		$val = trim(ini_get('post_max_size'));
		
		if($type == 'bytes') {
		
			$last = strtolower($val[strlen($val)-1]);
			switch($last) {
				// The 'G' modifier is available since PHP 5.1.0
				case 'g':
					$val *= 1024;
				case 'm':
					$val *= 1024;
				case 'k':
					$val *= 1024;
			}
		}
			
		return $val;
	}
	
	/**********************
	* Converts bytes to a readable format
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function byte_format($bytes, $unit = "", $decimals = 0) {
		$units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 
				'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
	 
		$value = 0;
		if ($bytes > 0) {
			// Generate automatic prefix by bytes 
			// If wrong prefix given
			if (!array_key_exists($unit, $units)) {
				$pow = floor(log($bytes)/log(1024));
				$unit = array_search($pow, $units);
			}
	 
			// Calculate byte value by prefix
			$value = ($bytes/pow(1024,floor($units[$unit])));
		}
	 
		// If decimals is not numeric or decimals is less than 0 
		// then set default value
		if (!is_numeric($decimals) || $decimals < 0) {
			$decimals = 2;
		}
	 
		// Format output
		return sprintf('%.' . $decimals . 'f '.$unit, $value);
	 }
	 
	/**********************
	* Converts any urls in text to a link
	* @author David Rugendyke
	* @since 1.0.1
	***********************/
	 public static function make_clickable_links($text) {
	  	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $text);
	}
	
	/**********************
	* Converts an WP upload file/image link to an absolute one for the current wp install - handy for when a WP install has moved but still has old links, this converts them automatically for the new install
	* @author David Rugendyke
	* @since 1.0.2
	***********************/
	 public static function absolute_upload_path($url) {
		 			
	  	if(strpos($url, '/wp-content/') !== false) {
			$parts = explode('/wp-content/', $url);
			$absolute_url = site_url().'/wp-content/'.$parts[1];
			return $absolute_url;
		}
	}
	
	/**********************
	* Walks an array and converts 'true', 'false', int strings to their boolean, int equivalents
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function array_convert_types(&$item, $key) {
		
		 if(strtolower($item) == 'true') {
			$item = true;	 
		 }
		 
		 if(strtolower($item) == 'false') {
			$item = false; 
		 }
		 
		 if(is_numeric($item)) {
			$item = (int) $item; 
		 }
	}
	
	/**********************
	* Walks an array and converts single quotes into their htmlchar equiv - used to store json arrays in data attribute tags on html elements
	* @author David Rugendyke
	* @since 1.0.4
	***********************/
	function array_store_as_safe_json(&$item, $key) {
		
		 $item = htmlentities($item, ENT_QUOTES, 'UTF-8');
		
	}
	
	/**********************
	* Creates a nice custom WP pages array that's indented - only works with get_pages default options
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function page_list_array_indented($pt_filter = 'page') {	
		$pages = array();
		$pages_wp = wp_dropdown_pages(array(
			'echo'=>0,
			'post_type'=>$pt_filter,
			'post_status' => 'publish'
		));
		preg_match_all('/<option.*?value="(.*?)">(.*?)<\/option>/', $pages_wp, $out, PREG_SET_ORDER);
		// Do some formatting
		if(count($out) > 0) {
			foreach($out as $page) {
				// Make the page ID the key and the value is the page title with indentation
				$pages[$page[1]] = $page[2];	
			}
		}
		
		return $pages;
	}
	
	/**********************
	* Creates a nice custom WP post category list that's indented
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function post_category_list_array_indented($taxonomy = 'category') {	
		$post_cats = array();
		$pages_wp = wp_dropdown_categories(array('echo'=>0,'hierarchical'=>1,'hide_empty'=>0,'orderby'=>'title', 'taxonomy'=>$taxonomy));
		preg_match_all('/<option.*?value="(.*?)">(.*?)<\/option>/', $pages_wp, $out, PREG_SET_ORDER);
		// Do some formatting
		if(count($out) > 0) {
			foreach($out as $post_cat) {
				// Make the page ID the key and the value is the page title with indentation
				$post_cats[$post_cat[1]] = $post_cat[2];	
			}
		}
		
		return $post_cats;
	}
	
	/**********************
	* Returns a list of the post formats supported by this theme in a nice(r) array
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function post_formats_list_array() {	
		$post_formats_wp = get_theme_support('post-formats');
		$post_formats = array('0'=>'Standard');
		if(count($post_formats_wp[0]) > 0) {
			foreach($post_formats_wp[0] as $format) {
				$post_formats[$format] = ucwords($format);	
			}
		}
		return $post_formats;
	}
	
	/**********************
	* Returns a list of the user roles in a nice array
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function user_roles_array() {	
		global $wp_roles;
		$roles = array();
		foreach($wp_roles->role_names as $role_val => $role_title) {
			$roles[$role_val] = $role_title;
		}
		return $roles;
	}
	
	/**********************
	* Cleans all meta data
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function clean_meta_data(&$arr)
	{
		 if (is_array($arr)){
			foreach ($arr as $i => $v){
				if (is_array($arr[$i]))	{
					$this->clean_meta_data($arr[$i]);
					if (!count($arr[$i]))	{
						unset($arr[$i]);
					}
				}
				else{
					if (trim($arr[$i]) == '')	{
						unset($arr[$i]);
					}
				}
			}
			if (!count($arr))	{
				$arr = NULL;
			}
		}
	}
	
	/**********************
	* Removes a domain name from a url
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function return_absolute_url_path($url)
	{
		if($url) {
			$path = parse_url($url);
			return $path['path'];
		}
	}
}

/**********************
* Sets the i18n (internationalization) language
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.3
***********************/
class Kontrol_Init_Language
{
	public function load() {
		load_plugin_textdomain('kontrolwp', false, APP_PATH_ID.'/languages/');	
	}
}

/**********************
* Stores a message to display after a redirect, then clears that msg
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/
class Kontrol_Alert
{
	
	private $key = 'kontrol_alert';
	
	/**********************
	* Sets a msg in the wp_options table
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function set_message($title, $msg) {
		// WP Method
		update_option($this->key, $title.']['.$msg);
	}
	
	/**********************
	* Checks to see if a msg is in the wp_options table
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function check_message() {
		// WP Method
		$msg = get_option($this->key);
		
		if(!empty($msg)) {
			// Empty the msg now in the DB and return the current one
			update_option($this->key, '');
			$msg_parts = explode('][', $msg);
			return $msg_parts;	
		}else{
			return FALSE;	
		}
	}

}


/**********************
* Parses template vars and converts them to their WP equivalent
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/
class Kontrol_Parse_Template_Vars
{
	
	/**********************
	* Parses some set template style tags - check the 'app/views/template-parse-list.php' directory for a list
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function parse($line) {
		
		global $post;
		
		if(isset($line) && !empty($line)) {
			
			//echo '<pre>';
			//print_r($post);
			//echo '</pre>';
			
			// Site Information
			$line = strpos($line, '[[sitename]]') !== false ? str_replace('[[sitename]]', get_bloginfo('title'), $line) : $line;
			$line = strpos($line, '[[sitedesc]]') !== false ? str_replace('[[sitedesc]]', get_bloginfo('description', 'display'), $line) : $line;
			
			if(!empty($post)) {
			
				// Post Information
				if(strpos($line, '[[date(') !== false) {
					 // Get the date format
					 preg_match_all("/\((.*?)\)/is", $line, $matches);
					 foreach($matches[1] as $date) {
						$line = str_replace('[[date('.$date.')]]', get_the_time($date, $post), $line); 
					 }
				}
	
				$line = strpos($line, '[[title]]') !== false ? str_replace('[[title]]', $post->post_title, $line) : $line;
	
				if(strpos($line, '[[excerpt]]') !== false) {
					 $length = 153;
					 $excerpt = $post->post_excerpt;
					 if(empty($excerpt)) {
						 // Auto generate if it doesn't exist
						 $excerpt = $post->post_content;
					 }
					 if(strlen($excerpt) > $length) {
						 $excerpt = substr($excerpt, 0, $length).'...'; 
					 }
					 $line = str_replace('[[excerpt]]', $excerpt, $line);
				}
				
				if(strpos($line, '[[excerpt_only]]') !== false) {
					 $length = 153;
					 $excerpt = $post->post_excerpt;
					 if(strlen($excerpt) > $length) {
						 $excerpt = substr($excerpt, 0, $length).'...'; 
					 }
					 $line = str_replace('[[excerpt_only]]', $excerpt, $line);
				}
				
				if(strpos($line, '[[tags]]') !== false) {
					$posttags = get_the_tags();
					if ($posttags) {
						 $tags = array();
						 foreach($posttags as $tag) {
							$tags[] = $tag->name; 
						  }
					  $line = str_replace('[[tags]]', implode(', ',$tags), $line);
					}
					 
				}
				
				if(strpos($line, '[[categories]]') !== false) {
					$post_categories = wp_get_post_categories($post->ID);
					$cats = array();
					foreach($post_categories as $c){
						$cat = get_category( $c );
						$cats[] = $cat->name;
					}
					$line = str_replace('[[categories]]', implode(', ',$cats), $line);
									 
				}
				
				if(strpos($line, '[modified(') !== false) {
					 // Get the date format
					 preg_match_all("/\((.*?)\)/is", $line, $matches);
					 foreach($matches[1] as $date) {
						$line = str_replace('[modified('.$date.')]]', date($date, strtotime($post->post_modified)), $line); 
					 }
				}
				
				$line = strpos($line, '[[id]]') !== false ? str_replace('[[id]]', $post->ID, $line) : $line;
				
			}
			
			//Author Information
			global $current_user;
      		get_currentuserinfo();
			$line = strpos($line, '[[author_name]]') !== false ? str_replace('[[author_name]]', $current_user->display_name, $line) : $line;
			$line = strpos($line, '[[author_firstname]]') !== false ? str_replace('[[author_firstname]]', $current_user->user_firstname, $line) : $line;
			$line = strpos($line, '[[author_surname]]') !== false ? str_replace('[[author_surname]]', $current_user->user_lastname, $line) : $line;
			$line = strpos($line, '[[author_id]]') !== false ? str_replace('[[author_id]]', $current_user->ID, $line) : $line;
			
			// Date & Time
			if(strpos($line, '[[current_date_time(') !== false) {
				 // Get the date format
				 preg_match_all("/\((.*?)\)/is", $line, $matches);
				 foreach($matches[1] as $date) {
					$line = str_replace('[[current_date_time('.$date.')]]', date($date), $line); 
				 }
			}
			
			// Current Search
			if ( is_search() ) {
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
				$line = strpos($line, '[[search_phrase]]') !== false ? str_replace('[[search_phrase]]', get_search_query(), $line) : $line;
			}
			
		}
		
		return $line;
	}

}

/**********************
* Contains a list of reasons to upgrade, picks one at random - didn't need to be a class, but what the hell ;)
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/
class Kontrol_Upgrade_Reasons_Print
{
	/**********************
	* Select a reason and return it at random
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	function select() {
		
		
	}
	
}


?>