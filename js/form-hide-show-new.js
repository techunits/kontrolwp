/**
* Class name: from-hide-show.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Hides and shows various form fields depending on a value that is selected/entered in a field
*/

var kontrol_form_hide_show_new;

(function($){
	
	kontrol_form_hide_show_new = new Class({
		
			Implements: [Options],
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.setOptions(options);
				// Get all the hideshow elements
				this.hideshows = $$('#kontrol .hide-show');
				// Hide or show classes straight away on load
				this.hideshows.each(function(el) {
					this.check_hide_show_elements(el);
				}.bind(this));
				
				if(!this.options.noListeners) {
					// Add the event listeners
					this.listeners();
				}
		
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Listen for changes in hide/show select fields
				$('kontrol').addEvent('change:relay(select.hide-show)', function(e) {
					this.check_hide_show_elements(e.target);
				}.bind(this));
				
				// Listen for changes in hide/show span click events
				$('kontrol').addEvent('click:relay(span.hide-show)', function(e) {
					this.check_hide_show_elements(e.target);
				}.bind(this));
				
			},
			
			/**
			/* Hide or show various classes depending on the results on some fields with the .hide-show class
			**/
			check_hide_show_elements: function(el) {
				   // Element type
				   var type = el.tagName.toLowerCase();
				   var selected = null;
				   
				   // Get the selected element by type
				   if(type == 'select') {
						selected = el.getSelected()[0];
				   }else{
					   selected = el;
				   }
				   				   
				   // Global select params
				   var disable_fields = el.get('data-disable-fields-on-hide');
				   // Sometimes we need to limit the range of classes that are hidden/shown to a certain parent
				   var parent = el.get('data-hide-show-parent');
				   if(parent) {
						parent = el.getParent(parent);   
				   }else{
						parent = $('kontrol');  
				   }
				   // Are we toggling or hide/showing?
				   if(selected.get('data-toggle-classes')) {
					   var classes = selected.get('data-toggle-classes');
					   this.hide_or_show('toggle', classes, parent, disable_fields);
				   }else{
					   // Get the classes we should show
					   var classes = selected.get('data-show-classes');
					   this.hide_or_show('show', classes, parent, disable_fields);
					   // Get the classes we should hide
					   var classes = selected.get('data-hide-classes');
					   this.hide_or_show('hide', classes, parent, disable_fields);
				   }
				
			},
			
			/**
			/* Hide or show various classes depending on the results on some fields with the .hide-show class
			**/
			hide_or_show: function(action, classes, parent, disable_fields) 
			{
				var class_array = [];
				
				if(classes) {
				     class_array = classes.split(',');
				}
				
				// Toggling?
				if(action == 'toggle') {
					class_array.each(function(class_name) {
						parent.getElements('.'+class_name).each(function(el) {
							if(el.isDisplayed()) {
								el.hide();	
							}else{
								el.show();	
							}
						});
					});
				}
				
				// We hiding or showing?
				if(action == 'hide') {
					class_array.each(function(class_name) {
						// Hide the element
						parent.getElements('.'+class_name).setStyle('display', 'none');
						// Disable form elements in it
						if(disable_fields != 'no') {
							this.disable_form_elements(true, class_name, parent);
						}
					}.bind(this));
				}
				
				if(action == 'show') {
					class_array.each(function(class_name) {
						parent.getElements('.'+class_name).setStyle('display', 'block');
						this.disable_form_elements(false, class_name, parent);
					}.bind(this));	
				}
			},
			
			/**
			/* Disable/Enable form elements within the hidden/shown ones
			**/
			disable_form_elements: function(flag, class_name, parent) {
				
				  // Disable any inputs in it from submitting
				  parent.getElements('.'+class_name+' input').set('disabled', flag);
				  parent.getElements('.'+class_name+' select').set('disabled', flag);
				  parent.getElements('.'+class_name+' textarea').set('disabled', flag);
			
			}
			
	});

})(document.id);