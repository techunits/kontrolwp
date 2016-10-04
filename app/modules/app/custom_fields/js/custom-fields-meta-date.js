/**
* Class name: custom-fields-meta.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* A special date picker for custom fields with a number of custom fixes/additions
*/

var kontrol_custom_fields_meta_date;

window.addEvent('domready', function() {
	
	// Only start on the post body screens
	(function($){
		if($('post')) {
			new kontrol_custom_fields_meta_date();
		}
	})(document.id);
});

(function($){
	
	kontrol_custom_fields_meta_date = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				// Get all the date picker fields	
				this.current_pickers = $$('.kontrol-metabox .kontrol-datepicker-field');
				// Attach pickers to them
				this.current_pickers.each(function(picker) {
					this.attach_picker(picker);
				}.bind(this));
			},
			
			/**
			* Attach a picker
			*/
			attach_picker: function(picker_el)
			{
				// console.log(picker_el);
				
			},
			
			
	});
	
	


})(document.id);