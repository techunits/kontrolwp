<?php 
	// Generate some unique class names for when this is used in a repeatable
	$rand_func_key = rand(0, 99999); 
	$field_name = 'colour-'.$field->field_key.'-'.$rand_func_key;
	$start_colour = !empty($field_value) && (substr($field_value, 0, 1) == '#') ? $field_value : '#ffffff';
?>

<script type="text/javascript">
window.addEvent('domready', function() {
	(function($){
		kontrol_colour_picker_<?php echo $rand_func_key?>($('<?php echo $field_name?>'));
	})(document.id);	
});

  // Colour picker settings
  var kontrol_colour_picker_<?php echo $rand_func_key?> = function(field_el) {	
  
		new MooRainbow(field_el, {
				    id: field_el.get('data-picker-id'),
			   imgPath: '<?php echo URL_CSS?>moorainbow/images/',
			startColor: '<?php echo $start_colour?>',
			  onChange: function(color) {
				field_el.getPrevious('.colour-box').setStyle('background-color', color.hex);
				field_el.set('value', color.hex);
			  }
		});		
  }
			
</script>

<div class="colour-box"></div>
<input id="<?php echo $field_name?>" data-picker-id="<?php echo $rand_func_key?>-kontrol_row_id" type="text" name="_kontrol[<?php echo $field->field_key?>]" value="<?php echo $start_colour;?>" class="<?php echo $field_validation?> kontrol-colour-picker-field" data-repeater-func="kontrol_colour_picker_<?php echo $rand_func_key?>" />

  