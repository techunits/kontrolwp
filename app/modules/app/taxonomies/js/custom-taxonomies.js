/**
* Class name: custom-taxonomies.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the taxonomies admin section
*/

var kontrol_tax_auto_fill;

(function($){
	
	// Prepopulates other fields when adding a new custom post type
	kontrol_tax_auto_fill = new Class({
		
			Implements: [Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				// First get the field we want to listen too in order to populate the other fields based on it
				this.post_name = $('kontrol').getElement('#tax-name');
				// The key field
				this.post_key = $('kontrol').getElement('#key');
				// Run an initial update straight away
				if(this.post_name.get('value').length > 0) {
					this.update_auto_fields();	
				}
				// Get a json encoded list of all the current taxonomies
				this.cpts = JSON.decode($('kontrol').getElement('#taxonomies').get('value'));
				// Add the main event listeners
				this.listeners();
				
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Add an event listener to fire an event in turn when the field is typed in
				this.post_name.addEvent('keyup', function(e) {
						this.update_auto_fields();				
				}.bind(this));
				
				this.post_name.addEvent('blur', function(e) {
						this.update_auto_fields();				
				}.bind(this));
				
								
				// Make sure they don't enter an existing post type
				this.post_key.addEvent('blur', function(e) {
					var val = e.target.get('value');
					if(Object.contains(this.cpts, val)) {
						alert(e.target.get('data-error-msg'));
						e.target.set('value', '');	
						this.post_key.focus();
					}
				}.bind(this));
			},
			
			/**
			* Updates all the fields that require it based on the post-name change
			* @param: option - The option slide down menu element
			**/
			update_auto_fields: function()
			{
				$('kontrol').getElements('.auto-fill').each(function(el) {
						var update_text = '';
						var current_text = this.post_name.get('value');
						// Now work out what type we are, singular, plural or do we also have some text to append? myStr.slice(0, -1)
						if(el.hasClass('singular')) {
							var last_char = current_text.substr((current_text.length-1),current_text.length);
							if(last_char.toLowerCase() == 's') {
								current_text = current_text.slice(0, -1);
							}
							update_text = update_text+current_text;
						}
						if(el.hasClass('plural')) {
							update_text = update_text+current_text;
						}
						
						if(el.hasClass('append')) {
							if(el.get('appendLabelText')) {
								if(current_text) {
									var append_text = el.get('appendLabelText');
									// Substitute the post value into the append text where an [] is encountered, otherwise just place it at the end
									if(append_text.contains('[]')) {
										// Check to see if we are making it uppercase
										if(append_text.contains('[]u')) {
											update_text = append_text.replace('[]u', current_text);
										}else{
											update_text = append_text.replace('[]', current_text.toLowerCase());
										}
									}else{
										// Get the text we need to append
										update_text = append_text+' '+update_text;
									}
								}
							}
							
						}
						
						// Now update that field
						el.set('value', update_text);
				}.bind(this));
			}
			
	});
	
	


})(document.id);