<?php
/**********************
* Generates the rules custom fields
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class CF_Rules
{
	
	/**********************
	* Generate the rules needed
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function generate()
	{
		// Post Types
		$post_types_wp = get_post_types(array('public'=> true),'objects');
		$post_types_cf = array();
		foreach($post_types_wp as $pt) {
			$post_types_cf[$pt->name] = $pt->label;
		}
		
		// Pages
		$pages_cf = array();
		
		foreach($post_types_cf as $pt_name => $pt_label) {
			// Skip posts and media
			if($pt_name != 'post' && $pt_name != 'media') {
				$pt_options = Kontrol_Tools::page_list_array_indented($pt_name);
				if(count($pt_options) > 0) {
					$pages_cf[$pt_label]['values'] = $pt_options;	
					$pages_cf[$pt_label]['id'] = $pt_name;
				}
			}
		}
		
		// Page Types
		$page_types = array('parent'=>'Parent Page', 'child'=>'Child Page');
		// Page Parent
		$page_parent = $pages_cf;
		// Page Templates and resort the array a bit
		$page_templates_wp = get_page_templates();
		$page_templates = array();
		if(count($page_templates_wp) > 0) {
			foreach($page_templates_wp as $name => $file) {
				$page_templates[$file] = $name;	
			}
		}
		// Get the posts, order by title
		$posts_wp = get_posts(array( 'numberposts' => -1, 'order'=> 'ASC', 'orderby' => 'title' ));
		$posts = array();
		if(count($posts_wp) > 0) {
			foreach($posts_wp as $post) {
				$posts[$post->ID] = $post->post_title;	
			}
		}
		// Post Categories
		$posts_cats = Kontrol_Tools::post_category_list_array_indented();
		// Post Formats
		$post_formats = Kontrol_Tools::post_formats_list_array();
		// User Roles
		$user_roles = Kontrol_Tools::user_roles_array();
		// Registered Taxonomies
		$taxes_wp = get_taxonomies(array('public'=> true),'objects');
		$taxes_cf = array();
		$prev_name = NULL;
		
		foreach($taxes_wp as $tax) {
			// Skip post tags
			if($tax->name != 'post_tag') {
				$taxes_options = Kontrol_Tools::post_category_list_array_indented($tax->name);
				if(count($taxes_options) > 0) {
					$taxes_cf[$tax->label]['values'] = $taxes_options;	
					$taxes_cf[$tax->label]['id'] = $tax->name;
				}
			}
		}
		
			
		$rules = array();
		$rules['Wordpress'][] = array('key'=>'post_type', 'label'=>'Post Type', 'data'=>$post_types_cf, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'page', 'label'=>'Page', 'data'=>$pages_cf, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'page_type', 'label'=>'Page Type', 'data'=>$page_types, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'page_parent', 'label'=>'Page Parent', 'data'=>$page_parent, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'page_template', 'label'=>'Page Template', 'data'=>$page_templates, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'post', 'label'=>'Post', 'data'=>$posts, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'post_cats', 'label'=>'Post Categories', 'data'=>$posts_cats, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'post_formats', 'label'=>'Post Format', 'data'=>$post_formats, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'user_roles', 'label'=>'User Roles', 'data'=>$user_roles, 'data_type'=>'select');
		$rules['Wordpress'][] = array('key'=>'taxonomies', 'label'=>'Taxonomy', 'data'=>$taxes_cf, 'data_type'=>'select');
		$rules['Kontrol'][] = array('key'=>'kontrol_cf', 'label'=>'Custom Field', 'data'=>NULL, 'data_type'=>'text', 'custom_select'=>array('customValFormat'=>'kontrol_cf:%s', 'customLabelFormat'=>'Custom Field (%s)', 'confirmText'=>'Enter the Kontrol custom field key.'));         
		
		return $rules;
		
	}
	
}

?>