<?php
/**********************
* Controls the custom fields hooks
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class SEOHooksController extends HookController
{
	protected $layout = 'meta/layout';
	public $group;
	
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();

	}
	
	/**********************
	* The controller will add any hooks it needs to here for the WP environment - is called everytime the app runs
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionSetHooks()
	{
	
		$this->settings = get_option('kontrol_seo_settings', array());

		// Only if the module is active
		if(isset($this->settings) && isset($this->settings['seo_enabled'])) {
			
			$this->defaults = get_option('kontrol_seo_defaults', array());
			
			if (is_admin()) {
				// Metabox CSS
				add_action('admin_print_styles', array(&$this, 'loadCSS'));
				// JS - Go Go Mootools :D - also add the cf types to the head as a JS array
				add_action('admin_print_scripts', array(&$this, 'loadJS'));
				// Add the meta boxes to the admin post edit screens
				add_action('add_meta_boxes', array(&$this,'setSEOMetaBox'));
				// Add a callback function to save any data from the metabox
				add_action('save_post',array(&$this,'saveSEOMetaBox'));
			}else{		
				// Set hooks for SEO on the frontend titles
				add_filter( 'wp_title', array(&$this,'frontendTitles'));	
				// Set hooks for SEO on the frontend meta tags/head
				add_action('wp_head', array(&$this,'frontendMeta'));
				// Redirect
				add_action('wp', array(&$this,'frontendRedirect'));
				// Remove default canonical urls, we make our own
				remove_action('wp_head', 'rel_canonical');
				// Robots
				
			}
		}
	}
	
	/**********************
	* The frontend SEO titles
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function frontendTitles($title)
	{
		global $post;
		$settings = $this->settings;
		$defaults = $this->defaults;
		$seo_data = get_post_meta($post->ID, '_kontrol_seo', TRUE);
		$hard_set = FALSE;
		$post_set = FALSE;
		
		if(isset($seo_data['title']) && !empty($seo_data['title'])) {
			$title = Kontrol_Parse_Template_Vars::parse($seo_data['title']);
			$post_set = TRUE;
		}
		
		// Various Hooks/Checks
		if(is_front_page()) {
			// Get the homepage defaults - defaults override post settings in these static cases
			if(isset($defaults['custom']['home']) && !empty($defaults['custom']['home']['title'])) {
				$title = Kontrol_Parse_Template_Vars::parse($defaults['custom']['home']['title']);
				$hard_set = TRUE;
			}
		}
		
		// Archive
		if(is_archive()) {
			if(isset($defaults['custom']['archive']) && !empty($defaults['custom']['archive']['title'])) {
				$title = Kontrol_Parse_Template_Vars::parse($defaults['custom']['archive']['title']);
				$hard_set = TRUE;
			}
		}
		
		// Search
		if(is_search()) {
			if(isset($defaults['custom']['search']) && !empty($defaults['custom']['search']['title'])) {
				$title = Kontrol_Parse_Template_Vars::parse($defaults['custom']['search']['title']);
				$hard_set = TRUE;
			}
		}
		
		// 404 Page
		if(is_404()) {
			if(isset($defaults['custom'][404]) && !empty($defaults['custom'][404]['title'])) {
				$title = Kontrol_Parse_Template_Vars::parse($defaults['custom'][404]['title']);
				$hard_set = TRUE;
			}
		}
		
		// Post Types - The defaults do not override the current SEO settings here
		if(!$hard_set && !$post_set) {
			if(isset($defaults['pt'])) {
				$pt = get_post_type($post->ID);	
				if(isset($defaults['pt'][$pt]) && !empty($defaults['pt'][$pt]['title'])) {
					$title = Kontrol_Parse_Template_Vars::parse($defaults['pt'][$pt]['title']);
				}
			}
		}
		
		return $title;
	}
	
	/**********************
	* The frontend SEO Meta
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function frontendMeta()
	{
		global $post;
		$settings = $this->settings;
		$defaults = $this->defaults;
		$seo_data = get_post_meta($post->ID, '_kontrol_seo', TRUE);
		$desc = NULL;
		$hard_set = FALSE;
		$post_set = FALSE;
		
		//print_r($seo_data);
		
		
		if(isset($seo_data['desc']) && !empty($seo_data['desc'])) {
			$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($seo_data['desc']));
			$post_set = TRUE;
		}
		
		// Various Hooks/Checks
		if(is_front_page()) {
			// Get the homepage defaults
			if(isset($defaults['custom']['home']) && !empty($defaults['custom']['home']['desc']) && !$post_set) {
				$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($defaults['custom']['home']['desc']));
				$hard_set = TRUE;
			}
		}

		// Archive
		if(is_archive()) {
			if(isset($defaults['custom']['archive']) && !empty($defaults['custom']['archive']['desc'])) {
				$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($defaults['custom']['archive']['desc']));
				$hard_set = TRUE;
			}
		}
		
		// Search
		if(is_search()) {
			if(isset($defaults['custom']['search']) && !empty($defaults['custom']['search']['desc'])) {
				$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($defaults['custom']['search']['desc']));
				$hard_set = TRUE;
			}
		}
		
		// 404
		if(is_404()) {
			if(isset($defaults['custom'][404]) && !empty($defaults['custom'][404]['desc'])) {
				$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($defaults['custom'][404]['desc']));
				$hard_set = TRUE;
			}
		}
		
		// Post Types - The defaults do not override the current SEO settings here
		if(!$hard_set) {
			if(isset($defaults['pt'])) {
				$pt = get_post_type($post->ID);	
				if(isset($defaults['pt'][$pt]) && !empty($defaults['pt'][$pt]['desc']) && !$post_set) {
					$this->frontendMetaPrint('description', Kontrol_Parse_Template_Vars::parse($defaults['pt'][$pt]['desc']));
				}
			}
		}

		/* Keywords **********/
		if($settings['keywords'] == TRUE) {
			if(isset($seo_data['keywords']) && !empty($seo_data['keywords'])) {
				$this->frontendMetaPrint('keywords', Kontrol_Parse_Template_Vars::parse($seo_data['keywords']));	
			}
		}
		
		/* Canonical URL *****/
		if(isset($seo_data['canonical_url'])) {
			$url = !empty($seo_data['canonical_url']) ? $seo_data['canonical_url'] : get_permalink($post->ID);
			echo "<link rel='canonical' href=\"".$url."\" />\n";	
		}
		
		/* Meta Robots *******/
		if(isset($seo_data['meta_index']) && isset($seo_data['meta_follow'])) {
			$extra_commands = isset($seo_data['meta_robot']) && count($seo_data['meta_robot']) > 0 ? ','.implode(',',$seo_data['meta_robot']) : NULL;
			echo "<META name=\"robots\" CONTENT=\"".$seo_data['meta_index'].",".$seo_data['meta_follow'].$extra_commands."\">\n";	
		}
		
	}
	
	/**********************
	* The frontend SEO Meta Print
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function frontendMetaPrint($type, $content)
	{
		echo "<META NAME='".$type."' CONTENT='".htmlentities(strip_tags(trim($content)))."' />\n";
	}
	
	/**********************
	* The frontend SEO Rdirect
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function frontendRedirect()
	{
		global $post;
		$seo_data = get_post_meta($post->ID, '_kontrol_seo', TRUE);
		
		// Internal redirect
		if(isset($seo_data['redirect_internal']) && !empty($seo_data['redirect_internal']) && is_numeric($seo_data['redirect_internal'])) {
			// Get permalink and redirect
			wp_redirect(get_permalink($seo_data['redirect_internal']), 301);
		}
		
		// External redirect
		if(isset($seo_data['redirect_external']) && !empty($seo_data['redirect_external'])) {
			// Get permalink and redirect
			wp_redirect($seo_data['redirect_external'], 301);
		}
	
	}
	
	
	/**********************
	* The CSS for the meta boxes/fields
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function loadCSS()
	{
		// Load our metabox CSS
		wp_register_style('kontrol-seo-meta', $this->app_module_current_url.'/css/meta.css');
        wp_enqueue_style('kontrol-seo-meta');
	}
	
	/**********************
	* The JS for the meta boxes/fields
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function loadJS()
	{
		// Load our metabox JS
		wp_enqueue_script('kontrolmoo-cf-meta-repeatable',  $this->app_module_current_url.'/js/seo-meta.js',  array('kontrolmoo-core', 'kontrolmoo-more'));
	}
	
		
	/**********************
	* Sets the SEO meta box
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function setSEOMetaBox()
	{
		// Get the current post type
		$post_type = $GLOBALS['current_screen']->post_type;
		$settings = get_option('kontrol_seo_settings', array());
		if(!isset($settings['post_types'])) { $settings['post_types'] = array(); }
		$pt_ob = get_post_type_object($post_type);
		// Check to see if this post type is not excluded
		if(!in_array($post_type, $settings['post_types']) && $pt_ob->public) {
			// Create a meta box for this group now
			add_meta_box(
				'kontrol-SEO',	
				'Kontrol '.esc_html__('SEO', 'kontrolwp'),		// Title
				array(&$this,'setSEOMetaBoxContent'),		// Callback function
				$post_type,					// Admin page (or post type)
				'normal',		// Context
				$settings['position'],
				array('settings'=>$settings)	
			);
		
		}

	}
	
	/**********************
	* Sets the SEO meta box
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function setSEOMetaBoxContent($post, $args)
	{
	    // Use nonce for verification
	    wp_nonce_field('kontrol_SEO_submit', 'kontrol_seo_noncename' );
	    // Settings
	    $setttings = $args['args']['settings'];
		// Defaults
	    $defaults =  array_map('stripslashes_deep', get_option('kontrol_seo_defaults', array()));
		// PT Type
		$post_type = $GLOBALS['current_screen']->post_type;
		// Defaults
		$default_title = NULL;
		$default_desc = NULL;
		// Current data
		$seo_data = get_post_meta($post->ID, '_kontrol_seo', TRUE);
		// Get the title and desc defaults if need be
		if(isset($defaults['pt'][$post_type]['title'])) {
			$default_title = strip_tags(Kontrol_Parse_Template_Vars::parse($defaults['pt'][$post_type]['title']));
		}
		// Meta Desc
		if(isset($defaults['pt'][$post_type]['desc'])) {
			$default_desc = strip_tags(Kontrol_Parse_Template_Vars::parse($defaults['pt'][$post_type]['desc']));
		}
		
		

		// Filter the title/desc
	   // $seo_data['desc'] = Kontrol_Parse_Template_Vars::parse($seo_data['desc']);
		
		
		// Set vars and load the view
		$this->setVar('post', $post);
		$this->setVar('settings', $setttings);
		$this->setVar('default_title', $default_title);
		$this->setVar('default_desc', $default_desc);
		$this->setLayoutVar('settings', $setttings);
		$this->setVar('seo_data', $seo_data);
		// Load the fields view
		$this->loadView('meta/seo-box');	
	  
	}
	
	/**********************
	* Saves the SEO Meta box
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function saveSEOMetaBox($post_id)
	{
		
		if(isset($_POST['kontrol_seo_noncename'])) {
						
			if(!wp_verify_nonce($_POST['kontrol_seo_noncename'], 'kontrol_SEO_submit')) {
					die('Kontrol Security Check: Form submitted late or from external server location.');
			}
			
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { 
				return; 
			}
		
			// Get the correct post id (not a revision)
			if (wp_is_post_revision($post_id)) {
				$post_id = wp_is_post_revision($post_id);
			}
	
			$field_key = '_kontrol_seo';
	
			$new_data = $_POST[$field_key];
		
			if(isset($new_data)) {
					
				  $current_data = get_post_meta($post_id, $field_key, TRUE); 
				  if ($current_data) {
					  if (empty($new_data)) {
						  delete_post_meta($post_id, $field_key);
					  }else{
						  update_post_meta($post_id, $field_key, $new_data);
					  }
				  }
				  elseif (!empty($new_data)) {
					  add_post_meta($post_id, $field_key, $new_data, TRUE);
				  }
					
			}
		}
		
		
		return $post_id;

	}
	
	
	
	
	
}