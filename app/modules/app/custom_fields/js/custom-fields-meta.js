/**
* Class name: custom-fields.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields meta boxes / validation
*/

var kontrol_custom_fields_meta;

window.addEvent('domready', function() {
	
	// Only start on the post body screens
	(function($){
		if($('post')) {
			new kontrol_custom_fields_meta();
			new kontrol_file_upload({
				'file_size_max': kontrol_upload_size_limit,
				'app_path': kontrol_app_path
			});		
			
		}
	})(document.id);
});

(function($){
	
	kontrol_custom_fields_meta = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.container = $('post');
				if($('post_type')) { this.post_type = $('post_type').get('value'); }
				if($('post_ID')) { this.post_id = $('post_ID').get('value'); }
				this.post_data = kontrol_post_data;
							
				// Add our class to any postmeta boxes that are made by Kontrol and collect ours into a nice array as we go
				this.meta_boxes = $$('.postbox[id*="kontrol-group"]');
				this.meta_boxes.each(function(box) {
					box.addClass('kontrol-metabox');	
					box.show();
				});
				
				// Remove the box class from any groups that have that style
				$$('.postbox[id*="kontrol-group-nobox"]').each(function(box) {
					box.removeClass('postbox');
				});
				
				// Validate each rule type now on load using an external list of cf types made by Kontrol
				kontrol_cf_types.each(function(rule_type) {
					this.rule_validate(rule_type);
				}.bind(this));
				
				// Hide any empty groups
				this.container.getElements('.kontrol-metabox').each(function(box) {
					if(!box.getElements('.kontrol-field').isDisplayed().contains(true)) {
						//box.hide();
					}
				});
				
				// Remove the visual editor/html editor buttons on wysiwigs
				this.container.getElements('.kontrol-metabox .kontrol-wysiwyg').each(function(wysiwyg) {
					wysiwyg.getElements('.wp-switch-editor').destroy();
					// Check to see if the media buttons are shown, if not remove that div
					if(!wysiwyg.getElement('.add_media')) {
						wysiwyg.getElement('.wp-editor-tools').destroy();
					}
				});		
				
				// Add tool tips
				new kontrol_tool_tips({'container':'post'});
						
				// Common Field Events
				this.field_event_delegations();

				// Add the main event listeners
				this.rule_events();
					
			},
			
			/*** 
			* Common field event delegations - more advanced ones are located within that fields view
			**/
			field_event_delegations: function()
			{
				
				// If the user double clicks the field title, it will copy the field key to the clipboard - a shortcut for devs mostly
				$$('.kontrol-metabox').addEvent('dblclick:relay(.kontrol-field .title)', function(e) {
					// Copy the field key to the clipboard
					window.prompt(kontrol_i18n_js.copy_field_key, e.target.get('data-copy'));
				}.bind(this));
				
				// Field effects
				$$('.kontrol-metabox').addEvent('focus:relay(input[type=text], select, textarea)', function(e) {
					// Change the bg colour on focus
					TweenLite.to(this, 2, {backgroundColor: '#fffcf1'});
				});
				
				$$('.kontrol-metabox').addEvent('blur:relay(input[type=text], select, textarea)', function(e) {
					// Revert the bg to white on blur
					TweenLite.to(this, 2, {backgroundColor: '#fff'});
				});

				
				// Multiple select boxes in a smart box
				$$('.kontrol-metabox').addEvent('change:relay(select[multiple][data-smart-box])', function(e) {
						
						var option_select = e.target;
						var smart_box_target = option_select.getNext('.kontrol-smart-box');
						var smart_box_vals = smart_box_target.getElements('input[type=hidden]').get('value');
						
						// Process each option - this can be done way better but IEs don't have event handlers for options which makes it difficult :|
						option_select.getElements('option').each(function(option) {
							// Add any selected that don't already exist the in smart box
							if(option.get('selected')) {
								if(!smart_box_vals.contains(option.get('value'))) {
									// It's not in there, add it - create a new row based on a copy 
									var new_row = smart_box_target.getElement('.new-row').clone();
									// Create the label and replace &nbsp; with -
									var label = option.get('text').replace(/\u00a0/g, "- ");
									// If it's part of an option group, add it to the label
									if(option.getParent('< optgroup')) {
										label = '<b>'+option.getParent('optgroup').get('label')+'</b> &nbsp;&nbsp;&nbsp; '+label+'';
									}
									// Add it our data to the new row
									new_row.set('html', new_row.get('html').replace('[[LABEL]]', label));
									new_row.set('html', new_row.get('html').replace('[[VALUE]]', option.get('value')));
									// Fire the smart box event now						
									smart_box_target.fireEvent('smart-box-row-add', [smart_box_target, new_row]);
								};
							}else{
								// Remove it if it exists in the smart box
								if(smart_box_vals.contains(option.get('value'))) {
									smart_box_target.fireEvent('smart-box-delete-row', [smart_box_target, smart_box_target.getElement('input[type=hidden][value='+option.get('value')+']').getParent('.row')]);
								}
							}
	
					});
				});
				
				// Search fields for select boxes
				$$('.kontrol-metabox').addEvent('click:relay(.select-search-box input)', function(e) {
					// Hide the search label
					this.getNext('.select-search-box-label').hide();
				});
				
				$$('.kontrol-metabox').addEvent('keyup:relay(.select-search-box input)', function(e) {
					// Create a clone of the select options the first time
					var parent = this.getParent('div');
					var select = parent.getNext('select');
					// Store a clone of the options so that we can filter them
					if(!parent.getElement('div.options-storage')) {
						var storage = new Element('div', {'class':'options-storage'});
						storage.grab(select.clone());
						parent.grab(storage);
					}
					
					var clone_select = parent.getElement('div.options-storage select').clone();
					var options = clone_select.getElements('option');
					// Get the select element
					options.each(function(option) {
						if(!option.get('text').toLowerCase().contains(this.get('value').toLowerCase())) {
							option.destroy();
						}
					}.bind(this));
					// Replace the original options with them
					clone_select.replaces(select);
					
				});
			},
			
			/**
			/* Event Listeners for the field rules
			**/
			rule_events: function() 
			{
				
				// Add Taxonomy events
				this.container.getElements('.categorydiv').addEvent('click', function(e) {
						(function() { this.rule_validate('taxonomies'); }.bind(this)).delay(150);
						// We need a minor delay to catch when a checkbox is 'unchecked' before validation
						(function() { this.rule_validate('post_cats'); }.bind(this)).delay(150);
				}.bind(this));
				

				// Add custom field events now
				this.container.getElements('.kontrol-metabox .kontrol-field[data-rule-kontrol_cf]').each(function(field) {
					// Get the custom field key we need to check
					var cf_field_keys = $(field).get('data-key-kontrol_cf').split(',');
					// Loops through each key
					cf_field_keys.each(function(cf_field_key) {
						// Get the target field
						var target_fields = this.container.getElements('[name*=_kontrol['+cf_field_key+']');
						if(target_fields && target_fields.length > 0) {
							// Add the required events for checking to that field
							target_fields.each(function(target_field) {
								// Get the field type to determine to event trigger to add
								var target_field_tag = target_field.tagName.toLowerCase();
								var events = Array();
								// Input fields
								if(target_field_tag == 'input') {
									var target_field_type = target_field.get('type').toLowerCase();
									// Text fields - Keyup, Blur
									if(target_field_type == 'text') {
										events.push('keyup');
										events.push('blur');
									}
									// Radio Box && Checkbox
									if(target_field_type == 'radio' || target_field_type == 'checkbox') {
										events.push('click');
									}
								}
								// Textarea fields
								if(target_field_tag == 'textarea') {
										events.push('blur');
								}
								// Textarea fields
								if(target_field_tag == 'select') {
										events.push('change');
								}
								// Add the events now
								events.each(function(event) {
									target_field.addEvent(event, function() {
										this.rule_validate('kontrol_cf');
									}.bind(this));
								}.bind(this));	
							}.bind(this));
						}
					}.bind(this));
				}.bind(this));
				// ^ That's a lot of binding ;)
										
				if(this.post_type == 'post') {
					// Post Formats
					if(this.container.getElement('#post-formats-select')) {
						this.container.getElement('#post-formats-select').addEvent('click:relay(input[type=radio])', function(e) { 
							this.rule_validate('post_formats');
						}.bind(this));	
					}
				}else{
					
					// Other post types Page IDs & Page Types
					if(this.container.getElement('#parent_id')) {
						this.container.getElement('#parent_id').addEvent('change', function(e) {
							this.rule_validate('page');
							this.rule_validate('page_type');
							this.rule_validate('page_parent');
						}.bind(this)); 
					}
					// Page Templates
					if(this.container.getElement('#page_template')) {
						this.container.getElement('#page_template').addEvent('change', function(e) {
							this.rule_validate('page_template');
						}.bind(this)); 	
					}
					
				}
			},
			
			/**
			/* Validates a give rule type
			**/
			rule_validator: function(type, rule_val, op, key, field) 
			{
				var valid = false;
				
				//console.log(type);
				
				// Our stored operators for comparing as easy to use functions in an object
				var compare = {
					'=': function(a, b) { 
							if(typeof(a) != 'object') {
								// Do an ordinary comparison if it's not an object
								return a == b;
							}else{
								// It's an object, check in it for the value
								return a.contains(b);	
							}
						},
					'!=': function(a, b) { 
							if(typeof(a) != 'object') {
								// Do an ordinary comparison if it's not an object
								return a != b;
							}else{
								// It's an object, check in it for the value
								return (!a.contains(b)) ? true : false;
							}
						},
					'%value': function(a, b) { 
							if(typeof(a) != 'object' && typeof(b) != 'object') {
								// Do an partial regex comparison if it's not an object, we can't do partial matches on objects
								return a.test(b.escapeRegExp()+'$', 'i');
							}
						},
					'value%': function(a, b) { 
							if(typeof(a) != 'object' && typeof(b) != 'object') {
								// Do an partial regex comparison if it's not an object, we can't do partial matches on objects
								return a.test('^'+b.escapeRegExp(), 'i');
							}
						},
					'%value%': function(a, b) { 
							if(typeof(a) != 'object' && typeof(b) != 'object') {
								// Do an partial regex comparison if it's not an object, we can't do partial matches on objects
								return a.test(b.escapeRegExp(), 'i');
							}
						}
				};
				
				// All
				switch(type) 
					{
					  case 'post_type':
						 valid = compare[op](this.post_type, rule_val);
					  break;
					  
					  case 'taxonomies':
							valid = compare[op](this.container.getElements('.categorydiv input[value='+rule_val+']:checked').get('value'), rule_val);
					  break;
					  
					  // Custom CF Fields = Values
					  case 'kontrol_cf':
					  		var results = Array();
					  		var rule_matches = this.rule_validate_kontrol_cf(rule_val, key);
							// Rule matches is an array, an item only needs to match once in the array to be successful
							if(rule_matches.length > 0) {
								rule_matches.each(function(rule_match) {
									results.push(compare[op](rule_match, rule_val));
								});
							}
							valid = results.contains(true);
					  break;
				}
					
				// Pages
				//if(this.post_type == 'page') {
					switch(type) 
					{
					  case 'page':
						 valid = compare[op](this.post_id, rule_val);
					  break;
					  
					  case 'page_type':
					  		var rule_match = this.rule_validate_page_type(rule_val);
							valid = compare[op](rule_match, rule_val);
					  break;
					  
					  case 'page_parent':
					  	if($('parent_id')) {
							 var rule_match = this.rule_validate_page_parent(rule_val);
							 valid = compare[op](rule_match, rule_val);
						}
					  break;

					   case 'page_template':
					   	 if($('page_template')) {
							 valid = compare[op](this.container.getElement('#page_template').get('value'), rule_val);
						 }
					  break;
					}
				//}
							
				// Posts
				//if(this.post_type == 'post') {
					switch(type) 
					{
					  case 'post':
						 valid = compare[op](this.post_id, rule_val);
					  break;
					  
					  case 'post_cats':
					  	if($('taxonomy-category')) {
			 			 	valid = compare[op](this.container.getElements('#taxonomy-category input[type=checkbox]:checked').get('value'), rule_val);
						}
					  break;
					  
					  case 'post_formats':
					  	if($('post-formats-select')) {
			 			    valid = compare[op](this.container.getElement('#post-formats-select input[type=radio]:checked').get('value'), rule_val);
						}
					  break;
					}
				//}
				
				return valid;
			},
			
			/**
			/* Returns the value needed for matching against this rule - custom field = value in this case
			**/
			rule_validate_kontrol_cf: function(rule_val, cf_field_key, field) 
			{
				var rule_matches = Array();

				// Get that field now
				var target_fields = this.container.getElements('[name*=_kontrol['+cf_field_key+']');
				if(target_fields && target_fields.length > 0) {
					target_fields.each(function(target_field) {
						var add_value = true;
						var target_field_tag = target_field.tagName.toLowerCase();
						if(target_field_tag == 'input') {
								var target_field_type = target_field.get('type').toLowerCase();
								// For checkboxes and radio buttons, only check if it's currently checked
								if(target_field_type == 'radio' || target_field_type == 'checkbox') {
									if(!target_field.checked) {
										add_value = false;
									}
								}
						}
						// Add the value in the array to check against?
						if(add_value) {
							rule_matches.push(target_field.get('value'));	
						}

					}.bind(this));
				}
								
				return rule_matches;
			},
			
			/**
			/* Returns the value needed for matching against this rule
			**/
			rule_validate_page_type: function(rule_val) 
			{
				var rule_match = null;
				// $('parent_id') will not appear if there's no posts in a post type, so use the stored var in that case
				if($('parent_id')) {
					// If it has no value it's a parent
					if(!this.container.getElement('#parent_id').getSelected()[0].get('value')) {
						rule_match = 'parent';	
					}else{
						rule_match = 'child';	
					}
				}else{
					if(this.post_data.post_parent == 0) {
						rule_match = 'parent';	
					}else{
						rule_match = 'child';	
					}
				}
				
				return rule_match;
			},
			
			/**
			/* Returns the value needed for matching against this rule
			**/
			rule_validate_page_parent: function(rule_val) 
			{
				var selected = this.container.getElement('#parent_id').getSelected()[0];
				
				/*
				var target_parent = null;
				if(selected.get('value')) {
					var parent_level_current = parseInt(selected.get('class').replace('level-',''));
					var target_level = parent_level_current - 1;
					
					// Now go back from this element until the level class changes, the first one is its parent
					 selected.getAllPrevious('option').each(function(option) {
						 if(option.get('class') == 'level-'+target_level && !target_parent) {
							target_parent = option;
						 }
					 });
				}*/
				if(rule_val == selected.get('value')) {
					return selected.get('value');	
				}else{
					return false;	
				}
			},
				
					
			
			/**
			/* Validates a fields rule
			**/
			rule_validate: function(rule_type) 
			{
				// Get all the fields for this type
				var fields = this.container.getElements('.kontrol-metabox .kontrol-field[data-rule-'+rule_type+']');

				if(fields.length > 0) {
					// Process each fields rules now
					fields.each(function(field) {
						var results;
						// Get the operator
						var operator = field.get('data-cond');
						// If the operator equals 'AND', we just need to see if all it's rules match
						if(operator == 'AND') {
							results = this.rule_validate_field_rules(field);
							
							// Is there a false result?
							if(results.contains(false)) {
								this.field_disable(field);	
							}else{
								this.field_enable(field);	
							}
						}
						// If the operator equals 'OR', we just need to see if one of the rules is true
						if(operator == 'OR') {
							results = this.rule_validate_field_rules(field);
							// Is there a false result?
							if(results.contains(true)) {
								this.field_enable(field);	
							}else{
								this.field_disable(field);	
							}
						}
						// Count how many fields are visible in the group, hide it if there are none, otherwise show it
						var group = field.getParent('.kontrol-metabox');
						if(!group.getElements('.kontrol-field').isDisplayed().contains(true)) {
							group.hide();
						}else{
							// Fire an event to let any listeners know that box is showing now
							group.fireEvent('show', group, 500);
							// Show the box
							group.show();	
							//TweenLite.fromTo(group, 1, {autoAlpha:0}, {autoAlpha:1});
						};
					}.bind(this));
				}
				
			},
			
			
			/**
			/* Validates all of a fields rules
			**/
			rule_validate_field_rules: function(field) 
			{
				var results = Array();
				// Get all of the fields vars
				for (var i = 0; i < field.attributes.length; i++) {
				  var attrib = field.attributes[i];
				  if (attrib.specified == true) {
					// Check to see if it's a rule
					if(attrib.name.test('data-rule')) {
						// A rule type can hold multiple values and operators seperated by a comma
						var type = attrib.name.replace('data-rule-','');
						// Get the value(s)
						var values = attrib.value.split(',');
						// Get the operator(s)
						var ops = field.get('data-op-'+type).split(',');
						// Get the parameter keys(s)
						var keys = field.get('data-key-'+type).split(',');
						// Match/Validate them all now
						for (x=0; x < values.length; x++) {
							// Add this fields rule result to the array
							results.push(this.rule_validator(type, values[x], ops[x], keys[x], field));
						}
						
					}
				  }
				}
				
				//console.log(results);
				
				return results;
			},
			
			/**
			/* Disable a field and hide it
			**/
			field_disable: function(field) 
			{
				// Hide the field
				field.hide();
				//TweenLite.to(field, 2, {autoAlpha:0, delay:0});
				field.getElements('input, select, textarea').set('disabled', true);			
			},
			
			/**
			/* Enable a field and its inputs
			**/
			field_enable: function(field) 
			{
				// Show the field
				if(!field.isDisplayed()) {
					field.show();
					TweenLite.fromTo(field, 2, {autoAlpha:0}, {autoAlpha:1});
				}
			
				if(field.hasClass('kontrol-repeatable')) {
					// Enable inputs - but only if it isn't a 'new-row' used by repeatables
					field.getElements('input, select, textarea').each(function(form_field) {
						if(!form_field.getParent('.row.new-row')) {
							form_field.set('disabled', false);
						}
					});
				}else{
					field.getElements('input, select, textarea').set('disabled', false);	
				}
			}
			
	});
	
	


})(document.id);