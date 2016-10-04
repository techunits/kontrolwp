/**
* Class name: custom-fields-validation.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields meta boxes validation
*/

var kontrol_custom_fields_validation;

window.addEvent('domready', function() {
	
	if(kontrol_i18n_lang) {
		// Set the language to use for validation error msgs
		Locale.use(kontrol_i18n_lang);
	}
	
	// Only start on the post body screens
	(function($){
		if($('post')) {
			new kontrol_custom_fields_validation();
		}
	})(document.id);
});

(function($){
	
	kontrol_custom_fields_validation = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				// Grab the form
				this.form = $('post');
				// Init the validation
				this.init_validation();	
				// Custom validation
				this.custom_validation();
				// Validate on preview too - not working properly atm, still opens new window but validates
				if($('post-preview')) {
					$('post-preview').addEvent('click', function(e) {
						if(!this.form_validation.validate()) {
							e.stop();
						}
					}.bind(this));
				}
				
			},	
			
			/**
			* Adds some custom validation for special fields/elements
			*/
			custom_validation: function()
			{
				// Validated file uploads
				this.required_file_uploads();
				// Validate multi selects
				this.multi_select_limit();
				// Validate checkbox limits
				this.checkbox_select_limit();
			},
			
			/**
			* Adds the validation for required file uploads which aren't validated normally
			*/
			required_file_uploads: function()
			{
				// Add an extra check for required file uploads
				this.form.getElements('.upload-el.required').each(function(el) {
					el.addClass('file-upload-required');
				});	
				
				// Add a check for it now
				this.form_validation.add('file-upload-required', {
					errorMsg: kontrol_i18n_js.error_upload_required+'.',
					test: function(element){
						if(element.getSiblings('ul').getElement('li.file')) { 
								if(element.getSiblings('ul').getElement('li.file:not(.removed)').length > 0) {
									return false; 
								}else{
									return true;	
								}
						}else{
							return true;	
						}
					}
				});
			},
			
			/**
			* Adds the validation for a multiselect field with limited number of option selections available
			*/
			multi_select_limit: function()
			{
				// Add an extra check for required file uploads
				$$('.kontrol-metabox').getElements('select[multiple]').each(function(multi) {
					multi.addClass('multi-select-limit');
				});	
				
				// Add a check for it now
				this.form_validation.add('multi-select-limit', {
					errorMsg: function(element, props){
							return kontrol_i18n_js.error_max_choices+' '+ element.get('data-max-val') +'.';
					},
					test: function(element){
						if(element.getNext('.kontrol-smart-box').getElement('.rows').getElements('> .row:not(.new-row)').length  > parseInt(element.get('data-max-val'))) { 
							return false; 
						}else{
							return true;	
						}
					}
				});
			},
			
			/**
			* Adds the validation for a checkbox fields
			*/
			checkbox_select_limit: function()
			{
				// Add an extra check for required file uploads
				$$('.kontrol-metabox').getElements('input[type=checkbox][data-max-val]').each(function(checkbox) {
					checkbox.addClass('checkbox-limit-check');
				});	
				
				// Add a check for it now
				this.form_validation.add('checkbox-limit-check', {
					errorMsg: function(element, props){
							return kontrol_i18n_js.error_max_choices+' '+ element.get('data-max-val') +'.';
					},
					test: function(element){
						if(element.getParent().getElements('input[type=checkbox]:checked').length > parseInt(element.get('data-max-val'))) { 
							return false; 
						}else{
							return true;	
						}
					}
				});
			},
			
			/**
			* Adds the validation to the form
			*/
			init_validation: function()
			{
				this.form_validation = new Form.Validator.Inline(this.form, {
					useTitles: false,
					onFormValidate: function(passed, form, e) {
						// If it failed, rehide some Wordpress elements
						if(!passed) {
							$$('.ajax-loading').hide();
							$('publish').removeClass('button-primary-disabled');
						}
					}
					
				});	
			}
			
		
	});
	
	


})(document.id);