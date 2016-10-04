
<!-- Module CSS -->
<? if(isset($css_files) && is_array($css_files)) { 
	foreach($css_files as $css) { ?>
		<link rel="stylesheet" type="text/css" href="<?=$css?>" />
<? 		}
	} ?>
    
<!-- Module JS -->
<? if(isset($js_files) && is_array($js_files)) { 
	foreach($js_files as $js) { ?>
		<script type='text/javascript' src='<?=$js?>'></script>
<? 		}
	} ?>

<!-- WP styled page -->
<div id="kontrol-wp-page" class="wp-page">
	<div class="wrap">
               
        <?=$layoutContent?>
        
	</div>
</div>
    




