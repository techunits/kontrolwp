<?php
/*
Plugin Name: KontrolWP
Plugin URI: http://www.kontrolwp.com
Description: KontrolWP - Wordpress Developer Kit is an advanced Wordpress package for managing custom post types, advanced custom fields, admin menu editing and much more through an easy to use interface. 
Version: 2.0.2
Author: Euphern Technology Pvt. Ltd. & David Rugendyke 
Author URI: http://URL.ironcode.com.au/
Copyright: Euphern Technology Pvt. Ltd. & David Rugendyke 
Requirements: PHP version 5.2.4 or greater, MySQL version 5.0 or greater
*/

$plugin_path = explode('/', plugin_basename(__FILE__));
define('APP_NAME', 'KontrolWP');
define('APP_ID', 'kontrolwp');
define('APP_PATH_ID', $plugin_path[0]);
define('APP_VER', '2.0.3');
define('APP_URL', 'http://www.kontrolwp.com');
define('APP_PLUGIN_URL', 'http://www.kontrolwp.com/plugin/wordpress-developer-kit');
define('APP_PLUGIN_LANG_URL', 'http://www.kontrolwp.com/plugin/wordpress-developer-kit/languages-supported');
define('APP_UPGRADE_URL', 'https://www.kontrolwp.com/upgrade');
define('APP_UPGRADE_ACTIVATE_URL', 'https://www.kontrolwp.com/activate');

// Main Paths
define('PLUGIN_PATH', dirname(dirname(dirname(__FILE__))) . '/');
define('APP_PATH', PLUGIN_PATH . 'app/');
define('APP_MODULE_PATH', APP_PATH . 'modules/app/');
define('APP_MODEL_PATH', APP_PATH . 'models/');
define('APP_LIB_PATH', APP_PATH . 'lib/');
define('APP_VIEW_PATH', APP_PATH . 'views/');
define('APP_CONFIG_PATH', APP_PATH . 'config/');

define('URL_SITE', get_bloginfo('url'));
define('URL_PLUGIN', plugins_url().'/'.APP_PATH_ID.'/');
define('URL_APP', URL_PLUGIN.'app/');
define('URL_MODULES', URL_APP.'modules/app/');
define('URL_WP_ADMIN', admin_url());
define('URL_WP_SETTINGS_PAGE', URL_WP_ADMIN.'admin.php?page=kontrolcs');
define('URL_WP_OPTIONS_PAGE', URL_WP_ADMIN.'options-general.php?page=kontrolwp');
define('URL_CSS', URL_PLUGIN . 'css/');
define('URL_JS', URL_PLUGIN . 'js/');
define('URL_IMAGE', URL_PLUGIN . 'images/');

// Currently supported languages other than English, comma delimited
define('LANG_SUPPORTED', '');
define('WPLANG', get_locale());

?>