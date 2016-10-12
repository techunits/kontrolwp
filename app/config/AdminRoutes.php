<?php

$controller = NULL;
$action = 'index';

// Some preset path defaults
if(isset($_GET['page'])) {
	// The default kontrol centre controller
	if($_GET['page'] == 'kontrolwp') {
		$controller = 'custom_fields';
	}
	// The default custom settings page
	if($_GET['page'] == 'kontrolcs') {
		$controller = 'custom_settings';
		$action = 'SettingsPage';
	}
}

// Format of regex => parseInfo
$regexRoutes = array(
	
	// Map nothing to the home page.
	'#^$#' => array(
		'controller' => $controller,
		'action' => $action
	),
	
	// Map controler/action/params
	'#^([^/]+)/([^/]+)/?(.*)$#' => array(
		'controller' => 1,
		'action' => 2,
		'additional_params' => 3,
	),
	
	// Map controllers to a default action (not needed if you use the
	// Lvc_Config static setters for default controller name, action
	// name, and action params.)
	'#^([^/]+)/?$#' => array(
		'controller' => 1,
		'action' => 'index',
	),
	
);

?>