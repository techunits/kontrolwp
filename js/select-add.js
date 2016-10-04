/**
* Class name: select-add.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Allows you to select items out of a dropdown list that are then automatically added as a hidden field
*/

var kontrol_select_add;

(function($){
	
	// Could be written better though, but it does pretty well - Dave
	kontrol_select_add = new Class({
		
			Implements: [Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				this.select_class = '.kontrol-select-add';
				this.select_results_class = '.kontrol-select-results';
				
				// Get the main selectors
				$$('#kontrol '+this.select_class).each(function(selector) {
						// Add the main event listeners to it
						this.listeners(selector);			
				}.bind(this));
				
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function(selector) 
			{
				// Add an event listener to fire an event in turn when the field is typed in
				selector.getElement('select').addEvent('change', function(e) {
			
					this.add_new_feature(e.target);			
				}.bind(this));
				
				// Remove a feature if it is clicked
				selector.getElement(this.select_results_class).addEvent('click:relay(.feature)', function(e) {
					this.destroy();
				});
				
			},
			
			/**
			* Updates all the fields that require it based on the post-name change
			* @param: option - The option slide down menu element
			**/
			add_new_feature: function(select_el)
			{
				var parent = select_el.getParent(this.select_class);
				var results = parent.getElement(this.select_results_class);
				var selected = select_el.getSelected();
				var val = selected[0]['value'];
				var add = true;

				if(val) {
					
					// Don't let them add it if it's already in the feature list
					var current_items = results.getElements('.feature > input[type=hidden]');
					current_items.each(function(item) {
						if(item.get('value') == val) {
							add = false;	
						}
					});
					
					if(add == true) {
						var new_value = new Element('input', {'type':'hidden','name':select_el.get('nameToAdd'),'value':val});
						var new_feature  = new Element('div', {'class':'feature','text':selected[0]['text']});
						new_feature.grab(new_value);
						results.grab(new_feature);				
					}
					
				}
			}
			
	});

})(document.id);