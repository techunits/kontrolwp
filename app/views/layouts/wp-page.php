
<!-- Module CSS -->
<? if(isset($css_files) && is_array($css_files)) { 
	foreach($css_files as $css) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $css?>" />
<? 		}
	} ?>
    
<!-- Module JS -->
<? if(isset($js_files) && is_array($js_files)) { 
	foreach($js_files as $js) { ?>
		<script type='text/javascript' src='<?php echo $js?>'></script>
<? 		}
	} ?>

<!-- WP styled page -->
<div id="kontrol-wp-page" class="wp-page">
	<div class="wrap">
               
        <?php echo $layoutContent?>
        
	</div>
</div>
    




