/**
* Class name: select-custom-value.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Allows a select form element to have a custom value which updates the select element when entered
*/

var kontrol_select_custom;

(function($){
	
	kontrol_select_custom = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
			
				// Add the main event listeners
				this.listeners();
				
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Listen for when the select changes to see if it's a custom value
				$('kontrol').addEvent('change:relay(.custom-select)', function(e) {
					// Is it custom?
					var selected = this.getSelected();
					if(selected[0].hasClass('custom-val')) {
						var default_value = '';
						// Default value for the confirm box
						if(selected[0].get('confirmDefaultVal')) {
						    default_value = selected[0].get('confirmDefaultVal');
						}
						var custom = prompt(selected[0].get('confirmText'), default_value);
						if(custom) {
							
							var value = custom;
							var text_label = 'Custom [ '+custom+' ]';

							// Save the value in a special format if it's present
							if(selected[0].get('customValFormat')) {
								value = selected[0].get('customValFormat').replace('%s', custom);
							}
							
							// Save the label in a special format if it's present
							if(selected[0].get('customLabelFormat')) {
								text_label = selected[0].get('customLabelFormat').replace('%s', custom);
							}
							
							selected[0]['text'] = text_label;
							selected[0]['value'] = value;
						}else{
							this.selectedIndex = 0;
						}
					}
				});
			}
			
	});

})(document.id);