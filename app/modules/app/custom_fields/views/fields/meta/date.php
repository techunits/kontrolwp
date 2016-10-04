<? 
	// Generate some unique class names for when this is used in a repeatable
	$rand_func_key = rand(0, 99999); 
	$field_name = 'date-'.$field->field_key.'-'.$rand_func_key;

?>

<script type="text/javascript">
window.addEvent('domready', function() {
	(function($){
		kontrol_date_picker_<?=$rand_func_key?>($('<?=$field_name?>'));
	})(document.id);	
});

  // Date settings
  var kontrol_date_picker_<?=$rand_func_key?> = function(field_el) {	
  
			var date_picker_field_el = field_el;
			var date_picker_field_value_el = field_el.getNext('input[type=hidden]');
	
			var date_format = '<?=empty($field->settings['date_format']) ? '%d/%m/%Y' : $field->settings['date_format']?>';
			var date_value_format = '<?=empty($field->settings['date_value_format']) ? '%d/%m/%Y' : $field->settings['date_value_format']?>';
			
			// Remove autocomplete
			date_picker_field_el.autocomplete = 'off';
			
			// Formats date values correctly into a native JS date object
			var date_format_native = function(date, date_format) {
					// Timestamps are not formatted correctly natively, so do it here
					var current_date_parsed = (date_format == '%s') ? new Date(parseInt(date) * 1000) : new Date.parse(date, date_format);
					return current_date_parsed;
			};
			
			<? // Add extra JS for Date Ranges
			   $range_class = NULL;
			   if(isset($field->settings['date_range']) && $field->settings['date_range'] == TRUE) {
				   $range_class = '.Range';
				   $range_dates = explode('||', $field_value); 
				   $range_dates[1] = !isset($range_dates[1]) ? $range_dates[0] : $range_dates[1];
			   }
			?>
			
			var picker = new Picker.Date<?=$range_class?>(date_picker_field_el, {
							timePicker: <?=!$field->settings['date_time_picker'] ? 'false' : 'true'?>,
							positionOffset: {x: 0, y: 0},
							pickerPosition: 'bottom',
							format: date_format,
							pickOnly: <?=!$field->settings['date_pick_only'] ? 'false' : "'".$field->settings['date_pick_only']."'"?>,
							useFadeInOut: false,
							<? if(isset($field->settings['date_limit_specific']) && !empty($field->settings['date_limit_specific'])) { ?>
								availableDates: <?=$field->settings['date_limit_specific']?>,
							<? } ?>
							<? if(isset($field->settings['date_limit_specific_invert']) && !empty($field->settings['date_limit_specific_invert'])) { ?>
								invertAvailable: <?=$field->settings['date_limit_specific_invert'] ? 'true':'false'?>,
							<? } ?>
							<? if(isset($field->settings['date_limit_min']) && !empty($field->settings['date_limit_min'])) { ?>
								minDate: date_format_native('<?=$field->settings['date_limit_min']?>', '%Y, %a %b %d'),
							<? } ?>
							<? if(isset($field->settings['date_limit_max']) && !empty($field->settings['date_limit_max'])) { ?>
								maxDate: date_format_native('<?=$field->settings['date_limit_max']?>', '%Y, %a %b %d'),
							<? } ?>
							<? if(!$range_class) { ?>
								onSelect: function(date){
									date_picker_field_value_el.set('value', date.format(date_value_format));
								} 
							<? }else{ ?>
								onSelect: function(){
									date_picker_field_value_el.set('value', Array.map(arguments, function(date){
										return date.format(date_value_format);
									}).join('||'));
								},
								setStartEndDate: function() {
									arguments[0].set('value', Array.map(arguments[1], function(date){
										return date.format(date_format);
									}).join(' - '));
								},
								getStartEndDate: function() {
									return date_picker_field_value_el.get('value').split('||').map(function(date){
										var parsed = date_format_native(date, date_value_format);
										return Date.isValid(parsed) ? parsed : null;
									}).clean();
								}
						<? } ?>
				});
				
						
			<? 
			// Some issues arose parsing %s timestamps, so do it natively
			if(!empty($field_value) && !$range_class) { ?>
				picker.select(date_format_native('<?=$field_value?>', date_value_format));
			<? } ?>
			<?
			// Date picker using a range needs to be initalised differently
			if(!empty($field_value) && $range_class) { ?>
				picker.options.setStartEndDate.call(picker, date_picker_field_el, [date_format_native('<?=$range_dates[0]?>', date_value_format), date_format_native('<?=$range_dates[1]?>', date_value_format)]);
			<? } ?>
			
  }
			
</script>

<input id="<?=$field_name?>" type="text" value="" class="<?=str_replace('validate-date', '', $field_validation)?> kontrol-datepicker-field" data-repeater-func="kontrol_date_picker_<?=$rand_func_key?>" />
<input id="<?=$field_name?>-value" type="hidden" name="_kontrol[<?=$field->field_key?>]" value="<?=!empty($field_value) ? $field_value : '';?>"  />
  