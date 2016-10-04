/**
* Class name: from-hide-show.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Hides and shows various form fields depending on a value that is selected/entered in a field
*/

var kontrol_form_hide_show;

(function($){
	
	kontrol_form_hide_show = new Class({
		
			Implements: [Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				// Get all the hideshow elements
				this.hideshows = $$('#kontrol .hide-show');
				// Hide or show classes straight away on load
				this.hideshows.each(function(el) {
					this.check_hide_show_elements(el);
				}.bind(this));
				
				// Add the event listeners
				this.listeners();
							
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Listen for changes in hide/show fields
				this.hideshows.addEvent('change', function(e) {
					this.check_hide_show_elements(e.target);					
				}.bind(this));
				
			},
			
			/**
			/* Hide or show various classes depending on the results on some fields with the .hide-show class
			**/
			check_hide_show_elements: function(el) {
				
				   var val = el.get('value');
				   var hideshowtype = el.get('hideShowType');
				   var hs_val = el.get('hideShowVal');
				   var hs_classes = el.get('hideShowClasses');
				   var hs_disable_fields = el.get('hideShowDisableFields');
					   // Has this hide/show el been triggered?
				   if(val == hs_val) {
					   // Ok now hide/or show all its assigned classes
					   this.hide_or_show(hideshowtype, hs_classes, hs_disable_fields);
				   }else{
					   var opp = (hideshowtype == 'hide') ? 'show':'hide';
					   this.hide_or_show(opp, hs_classes, hs_disable_fields);
				   }
				
			},
			
			/**
			/* Hide or show various classes depending on the results on some fields with the .hide-show class
			**/
			hide_or_show: function(action, classes, hs_disable_fields) 
			{
				var class_array = classes.split('|');
				// We hiding or showing?
				if(action == 'hide') {
					class_array.each(function(class_name) {
						// Hide the element
						$$('.'+class_name).setStyle('display', 'none');
						// Disable form elements in it
						if(hs_disable_fields != 'no') {
							this.disable_form_elements(true, class_name);
						}
					}.bind(this));
				}else{
					class_array.each(function(class_name) {
						$$('.'+class_name).setStyle('display', 'block');
						// Enable form elements in it
						if(hs_disable_fields != 'no') {
							this.disable_form_elements(false, class_name);
						}
					}.bind(this));	
				}
			},
			
			/**
			/* Disable/Enable form elements within the hidden/shown ones
			**/
			disable_form_elements: function(flag, class_name) {
				
				  // Disable any inputs in it from submitting
				  $$('.'+class_name+' input').set('disabled', flag);
				  $$('.'+class_name+' select').set('disabled', flag);
				  $$('.'+class_name+' textarea').set('disabled', flag);
			
			}
			
	});

})(document.id);