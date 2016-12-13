<?php
	$flag_url = NULL;
	// Determine the country flag to show if possible
	if(strpos(WPLANG, '_') !== false) {
		$parts = explode('_', WPLANG);
		$code = strtolower($parts[1]);
		if(file_exists(PLUGIN_PATH.'images/flags/'.$code.'.png')) {
			$flag_url = URL_IMAGE.'flags/'.$code.'.png';
		}
	}

?>

<script type="text/javascript">

	window.addEvent('domready', function() {	
	
		// Hide the WP header bar
		//$('wphead').setStyle('display', 'none');
		//$('screen-meta').setStyle('display', 'none');
				
		// Kontrol alert
		<?php if($app_alert_msg) { ?>
			new kontrol_notification({
					'duration': 2000,
					'msg_title': "<?php echo $app_alert_msg[0]?>",
					'msg_text': "<?php echo $app_alert_msg[1]?>"
					});
		<?php } ?>
	});
	
</script>

<!-- Module CSS -->
<?php if(isset($css_files) && is_array($css_files)) { 
	foreach($css_files as $css) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $css?>" />
<?php 		}
	} ?>
    
<!-- Module JS -->
<?php if(isset($js_files) && is_array($js_files)) { 
	foreach($js_files as $js) { ?>
		<script type='text/javascript' src='<?php echo $js?>'></script>
<?php 		}
	} ?>


<div id="kontrol">
	<!-- Header -->
	<div class="header">
    	<div class="orange">
        	<div class="logo"></div>
            <?php if(KONTROL_T) { ?>
            	<div class="upgrade"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><img src="<?php echo URL_IMAGE?>/upgrade.png" /></a></div>
            <?php } ?>
        </div>
        <!-- Nav -->
        <div class="nav-modules">
        	<?php foreach($modules as $module) { 	 
					// For i18n purposes and the fact that modules initialise before the language does, we need the labels printed here instead of in the module.php file
					switch ($module['controller_file']) {
						case 'custom_fields':
							$module['name'] = __('Custom Fields', 'kontrolwp');
							break;
						case 'custom_settings':
							$module['name'] = __('Custom Settings', 'kontrolwp');
							break;
						case 'custom_post_types':
							$module['name'] = __('Custom Post Types', 'kontrolwp');
							break;
						case 'taxonomies':
							$module['name'] = __('Custom Taxonomies', 'kontrolwp');
							break;
						case 'seo':
							$module['name'] = __('SEO', 'kontrolwp');
						break;
						case 'admin_menu':
							$module['name'] = __('Admin Menu Editor', 'kontrolwp');
						break;
					}
			?>
        		<div class="item inline <?php echo ($module['controller_file'] == $app_current_controller) ? 'in':''?>"><a href="<?php echo URL_WP_OPTIONS_PAGE?>&url=<?php echo $module['controller_file']?>"><?php echo $module['name']?></a></div>
            <?php } ?>
            <div class="nav-kontrol-links">
                 <?php if(KONTROL_T) { ?>
                 	<!--div class="item inline"><a href="<?php echo URL_WP_OPTIONS_PAGE?>&url=register"><?php echo __('Enter Upgrade Key', 'kontrolwp')?></a></div-->
				<?php } ?>
                <div class="item inline"><a href="<?php echo APP_PLUGIN_URL?>" target="_blank"><?php echo __('Guide', 'kontrolwp')?></a></div>
                <div class="item inline"><a href="<?php echo APP_URL?>" target="_blank"><?php echo APP_NAME ?> <?php echo APP_VER?></a></div>
                <?php if(!empty($flag_url)) { ?>
                	<div class="item inline"><img src="<?php echo $flag_url?>" title="<?php echo WPLANG?>" /></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Main Content Area -->
    <div class="content">
    	<div class="cols">
        	<?php echo $layoutContent?>
    </div>
</div>
    




