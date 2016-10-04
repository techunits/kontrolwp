/**
* Class name: custom-fields.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields admin section
*/

var kontrol_custom_fields_admin;

(function($){
	
	kontrol_custom_fields_admin = new Class({
		
			Implements: [Options, Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				// Set the passed options
				this.setOptions(options);
				// The main container of the form
				this.cf_form = $('kontrol').getElement('#cf-add');
				// Get all the field rows and show their settings for the selected field
				this.field_type_dds = $('kontrol').getElements('.field-type-dd');
				// Set all the appropriate field settings now on init
				this.field_type_dds.each(function(dd) {
					this.show_field_settings(dd);		
				}.bind(this));
				// Set a flag to make the user check if they have saved their current group
				this.saved_flag = false;
				// Apply the date picker to any required fields
				this.add_date_pickers($('kontrol'));
				// Remove any repeatable fields that aren't needed
				this.repeatable_fields_remove();
				// Add the main event listeners
				this.listeners();
					
			},
			
			/***
			/* Add date pickers to any form elements requiring it
			**/
			add_date_pickers: function(element) 
			{
				var pickers = element.getElements('.date-picker');
				new Picker.Date(pickers, {
							positionOffset: {x: 0, y: 0},
							format: '%Y, %a %b %d',
							useFadeInOut: false
				});
			},
			
					
			/**
			/* Set the field settings to show the one for the dropdown
			**/
			show_field_settings: function(dd) 
			{
				// Type
				var type = dd.get('value');
				// Get the groups parent container
				var container = dd.getParent('.row');
				var settings = container.getElement('.settings');
				// Hide all the settings that don't match the selected
				var field_settings = settings.getElement('.field-'+type);
				if(field_settings) {
					settings.setStyle('display', 'block');
					field_settings.getSiblings('div').setStyle('display', 'none');
					field_settings.setStyle('display', 'block');
					field_settings.getElements('input, select, textarea').set('disabled', false);	
					field_settings.getSiblings('div input, div select, div textarea').set('disabled', true);	
				}else{
					settings.setStyle('display', 'none');			
				}
			},
			
			
				
			/**
			/* Opens/Closes the field form for a row
			**/
			toggle_field_form: function(row) 
			{
				var form = row.getElement('.row-form');
				// Check to see if there are any open form fields
				var open_form_row = row.getParent('.field-rows').getElement('.edit-fields');
				if(open_form_row) {
						var open_form = open_form_row.getElement('.row-form');
						open_form_row.removeClass('edit-fields');
						new Fx.Reveal(open_form, {duration: 500, 
							onComplete: function() {
								this.open_field_form(form);						
							}.bind(this)
						}).dissolve();
				}else{
					new Fx.Reveal(form, {duration: 0, onComplete: function() {
						this.open_field_form(form);
						}.bind(this)
					}).dissolve();
				}
			},
			
			/**
			/* Opens the field form for a row
			**/
			open_field_form: function(form) 
			{	
				(function() {
					form.getParent('.row').addClass('edit-fields')
					new Fx.Reveal(form, {duration: 1000, onComplete: function() { 
					}}).reveal();
				}).delay(30);
			},
			
			/**
			/* Perform a few actions when adding a new repeatable field
			**/
			repeatable_fields_new: function(new_field_el) 
			{	
				// Check to see if this is a repeatable field first
				if(new_field_el.getParent('.repeatable-fields')) {
					var repeatable = new_field_el.getParent('.repeatable-fields');
					// Grab it's parents ID and update it's row with it
					var parent_field_id = repeatable.getParent('.row').getElement('.field-id').get('value');
					// Add a flag
					new_field_el.getElement('.field-repeatable').set('value', 1);
					// Update the new row with it's parents id
					new_field_el.getElement('.field-parent-id').set('value', parent_field_id);
					// Remove any repeatable fields now that require it
					this.repeatable_fields_remove();
				};
			},
			
			/**
			/* Removes any fields that need aren't required for a repeatable field
			**/
			repeatable_fields_remove: function() 
			{	
				// Only look in a repeatable field for them
				this.cf_form.getElements('.repeatable-fields .repeatable-remove').destroy();
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{

				// Save the field when the save button is pressed
				this.cf_form.addEvent('click:relay(.save-field)', function(e) {
					// Validate the form
					if(fields_validator.validate()) {
						// Remove the editing class so it won't be destroyed if they try to add another
						e.target.getParent('.row').removeClass('edit-fields');
						// Save the form
						new Fx.Reveal(e.target.getParent('.row-form'), {duration: 500}).dissolve();					
					}
				}.bind(this));
				
				// Group Rules select
				if(this.cf_form.getElement('#group-rules-select')) {
					if(this.cf_form.getElement('#group-rules-select').get('value') == 'custom') {
						$('group-default-options').removeClass('hide');	
					}
					this.cf_form.getElement('#group-rules-select').addEvent('change', function(e) {
						var value = e.target.get('value');
						if(value == 'custom') {
							$('group-default-options').removeClass('hide');	
						}else{
							$('group-default-options').addClass('hide');	
						}
					});
				}
				
				
				// For each rules section, show more fields if the choice is 'custom'
				this.cf_form.addEvent('change:relay(.rules-type-select)', function(e) {
					var value = e.target.get('value');
					var parent = e.target.getParent('.item.field-rules');
					if(value == 'custom') {
						parent.getElement('.fields').removeClass('hide');
					}else{
						parent.getElement('.fields').addClass('hide');
					}
				});
						
				// Update several fields based on the field name
				this.cf_form.addEvent('keyup:relay(.form-field-name)', function(e) {
					// Remove the editing class so it won't be destroyed if they try to add another
					var row = e.target.getParent('.row');
					var text = e.target.get('value');
					var key_text = row.getElement('.form-field-key').get('value');
					row.getElement('.field-name').set('text',  text);
					var field_key = row.getElement('.form-field-key');
					// Remove the edited class if it's empty
					if(field_key.get('value').length == 0 && field_key.hasClass('edited')) {
						field_key.removeClass('edited');
					}
					// Only update the field key if they haven't manually edited it yet
					if(!row.getElement('.form-field-key').hasClass('edited')) {
						var key_safe_text = restrict_safe_characters_now(text);
						row.getElement('.form-field-key').set('value',  key_safe_text);
						row.getElement('.field-key').set('text',  key_safe_text);
					}
				}.bind(this));
				
				// Update the key field label when editing
				this.cf_form.addEvent('keyup:relay(.form-field-key)', function(e) {
					var row = e.target.getParent('.row');
					var text = e.target.get('value');
					e.target.addClass('edited');
					row.getElement('.field-key').set('text', restrict_safe_characters_now(text));
				}.bind(this));
				
				// Update the validation label when editing
				this.cf_form.addEvent('change:relay(.form-field-required)', function(e) {
					var row = e.target.getParent('.row');
					var text = e.target.get('value');
					var label = null;
					if(text == 'required') { label = kontrol_i18n_js.label_required; }
								       else{ label = kontrol_i18n_js.label_optional; }
					e.target.addClass('edited');
					row.getElement('.field-required').set('text', label);
				}.bind(this));
				
				// Show the settings depending on what field type is selected
				this.cf_form.addEvent('change:relay(.field-type-dd)', function(e) {
					// Show the settings for that field type
					this.show_field_settings(e.target);
					// Update the row label 
					var row = e.target.getParent('.row');
					var selected = e.target.getSelected();
					var selected_val = selected[0].get('value');
					// Update the label for that row now
					row.getElement('.cpt-updated').set('text', selected[0].get('text'));
				}.bind(this));
					
				// When a rule set type is changed, show it's options
				this.cf_form.addEvent('change:relay(.main-rules-select)', function(e) {
					var selected = e.target.getSelected();
					var targetEl = this.getParent('div.field').getElement('.'+selected[0].get('data-show-values'));
					targetEl.getElement('select,input').set('disabled', false);
					var siblings = targetEl.getSiblings('div');
					siblings.addClass('hide');	
					// Disable any hidden selects so that they don't get submitted
					siblings.getElement('select,input').set('disabled', true);
					// Show this dropdown now
					targetEl.removeClass('hide');
				
				});
						
				// Listen for a new row button being clicked
				this.cf_form.addEvent('click:relay(.new-cf)', function(e) {
					// Check version
					if($('kver').get('value') == '1' && parseInt($('kver').get('data-field-count')) >= 10) {
						alert(kontrol_i18n_js.error_max_cf);	
					}else{
						// Get the add new template for a cf item and add it to the bottom of the fields table
						var new_fields_el = $('kontrol').getElement('#new-field-form').clone();
						// Add any date pickers to it
						this.add_date_pickers(new_fields_el);
						// Add it to the bottom
						e.target.getParent('.group-fields').getElement('.field-rows').grab(new_fields_el, 'bottom');	
						// It's a new field, we need to replace it's field key with a unique ID
						var key = String.uniqueID();
						// Update the field key with a unique one in field elements
						new_fields_el.getElements('input, textarea, select').each(function(el) {
							if(el.get('name')) {
								el.set('name', el.get('name').replace('[key_id]','['+key+']'));
							}
						}.bind(this));
						// Update the field key with a unique one in field image upload elements
						new_fields_el.getElements('div.kontrol-file-upload').each(function(el) {
							if(el.get('data-filereturninputname')) {
								el.set('data-filereturninputname', el.get('data-filereturninputname').replace('[key_id]','['+key+']'));
							}
						}.bind(this));
						// Remove any repeatable fields that need removing now ie. Rules
						this.repeatable_fields_new(new_fields_el);
						// Update the sortable elements now
						new sort_rows();
						// Hide/show any classes required;
						new kontrol_form_hide_show_new({'noListeners':true});
						// Attach any image upload instances
						new kontrol_file_upload({
							'container': new_fields_el,
							'file_size_max': kontrol_upload_size_limit,
							'app_path': kontrol_app_path
						});	
						// Open the form area now
						this.toggle_field_form(new_fields_el);
					}
				}.bind(this));
				
				// When a field edit button is clicked, reveal the field form
				this.cf_form.addEvent('click:relay(.edit-field)', function(e) {
					var row = e.target.getParent('div.row');
					// Did they click edit on a row thats already open? if so, just close it
					if(row.hasClass('edit-fields')) {
						// First check to see if all fields are valid before we hide it
						if(fields_validator.validate()) {
							row.getElement('.row-form').hide();
							row.removeClass('edit-fields');
						}
					}else{
						this.toggle_field_form(e.target.getParent('div.row'));
					}
				}.bind(this));
				
				// Delete the field when the delete button is pressed
				this.cf_form.addEvent('click:relay(.delete-field)', function(e) {
					var field = e.target.getParent('.row');
					// Delete the field
					var check = confirm(kontrol_i18n_js.delete);
					if(check) {
						field.destroy();
					}
				}.bind(this));
				
				// Hide the field when the hide button is pressed
				this.cf_form.addEvent('click:relay(.hide-field)', function(e) {
						var field = e.target.getParent('.row');
						// Get the value of the hidden active field 
						var hidden_field = field.getElement('.field-active');
						var hidden_val = hidden_field.get('value');
						if(hidden_val == 0) {
								field.setStyle('opacity', 1);	
								hidden_field.set('value', 1);
						}else{
							field.setStyle('opacity', 0.5);		
							hidden_field.set('value', 0);
						}		
				}.bind(this));
				
				// Clone the field when the clone button is pressed
				this.cf_form.addEvent('click:relay(.clone-field)', function(e) {
						var field = e.target.getParent('.row');
						// Clone it
						var new_clone_row = field.clone();
						// Works on repeatable fields this way
						new_clone_row.getElements('.form-field-name').each(function(el) {
							var parent_row = el.getParent('.row');
							
							var field_title_el = parent_row.getElement('.form-field-name');
							var field_key_el = parent_row.getElement('.form-field-key');
							var field_name_text_el = parent_row.getElement('.field-name');
							var field_key_text_el = parent_row.getElement('.field-key');
							
							var new_name = field_title_el.get('value')+' Clone';
							var new_key = field_key_el.get('value')+'-'+Number.random(10, 100);
							
							// Set the new clone title and key and labels
							//field_title_el.set('value', new_name);
							field_key_el.set('value', new_key);
							//field_name_text_el.set('text', new_name);
							field_key_text_el.set('text', new_key);
							
							// It's a new field, we need to replace it's field cloned ID with a unique ID
							var key = String.uniqueID();
							parent_row.getElements('input, textarea, select').each(function(el) {
								if(el.get('name')) {
									var parent_id = el.get('name').match(/field\[(.*?)\]/); 
									// Replace it's parents ID with a new one so it doesn't overwrite its parent 
									el.set('name', el.get('name').replace('field['+parent_id[1]+']','field['+key+']'));
								}
							}.bind(this));
									
						});
						
						

						// Add it
						new_clone_row.inject(field,'after');
						new_clone_row.highlight('#ffe7b3');
						
				}.bind(this));
				
				// When a field rule is changed for post_types, make sure it matches one for the group or it wont show
				$('kontrol').addEvent('change:relay(#group-post-types select)', function(e) {
					// Check to see if this not a post type selected for the group
					this.update_field_post_type_options();
				}.bind(this));
				
				// When a field rule is removed/added for post_types, make sure it matches one for the group or it wont show by lsitening to the duplication event
				window.addEvent('duplication-event-completed', function(el, parent) {
					if(parent.hasClass('group-post-type')) {
						this.update_field_post_type_options();	
					}
				}.bind(this));
				
				// When the groups post types are changed, add those to the select options for the fields
				this.update_field_post_type_options();
				
				// Add a flag check for when the submit button is pressed
				$('kontrol').getElement('#cf-add').addEvent('submit', function() {
					this.saved_flag = true;
				}.bind(this));
				
				
				// Delete a group button
				if($('kontrol').getElement('#group-delete-button')) {
					$('kontrol').getElement('#group-delete-button').addEvent('click', function(e) {
						var check = confirm(kontrol_i18n_js.delete_cf_group_warning);
						if(check) {
							this.saved_flag = true;
							$('kontrol').getElement('#group-delete-flag').set('value', 1);
							e.target.getParent('form').submit();
						}
					}.bind(this));
				}
										
				// Do a check to see if the user needs to save the group before moving on
				window.onbeforeunload = function() { 
				 	if(this.saved_flag == false) {
						return kontrol_i18n_js.leave_without_saving_cf;
					}
				}.bind(this);
				
			},
			
			
			/**
			/* Add the select options to a fields 'post_types' rule options select based on the groups
			**/
			update_field_post_type_options: function() 
			{	
				var pt_options = [];
				$('kontrol').getElements('#group-post-types select').each(function(select, index) {
					var selected = select.getSelected();
					pt_options[index] = selected[0].clone();
				});
							
				// Now find all the fields post type rules fields and update them
				$('kontrol').getElements('.rule-val.post_type > select').each(function(select) {
					// Maintain the select one
					var selected = select.getSelected();
					var selected_val = selected[0].get('value');
					select.empty();
					// If the selected value matches that of one of the pt_options, add it back
					pt_options.each(function(option, index) {
						var option_clone = option.clone();
						// Add the option now
						select.grab(option_clone, 'bottom');
					});
					// If they had one selected previously, reselect it
					select.getElements('option').each(function(option, index) {
						if(option.get('value') == selected_val) {
							select[index].selected = true;
						}
					});
					
				});
			}
			
			
			
	});
	
	


})(document.id);