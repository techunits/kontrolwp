/**
* Class name: collapse-expand-section.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Hides and shows various sections on the form 
*/

var kontrol_collapse_show;

(function($){
	
	kontrol_collapse_show = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				// Get all the collapsible sections
				this.collapsibles = $$('#kontrol .collapsible');
				// Now set their effects and hide them
				this.collapsibles.each(function(collapse) {
					
					var sections = collapse.getElements('.collapsible-section');
					
					sections.each(function(section) {
						// Set the effects and hide them
						new Fx.Reveal(section, {duration: 0}).dissolve();
						section.store('status', 'closed');
						// Set the effects now
						section.set('reveal', {duration: 550, transition: Fx.Transitions.Quad.easeOut, transitionOpacity: false,
											  onComplete: function() {
												  if(this.retrieve('status') == 'closed') {
													  this.store('status', 'open');
												  }else{
													  this.store('status', 'closed');
													  
												  }
											  }.bind(section)
						});
					});
				});
				// Add the main event listeners
				this.listeners();
				
			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Add events for the label being clicked to reveal the options
				this.collapsibles.each(function(collapse) {
					
					var buttons = collapse.getElements('.button-collapse');
					
					buttons.each(function(button) {
						button.addEvent('click', function(e) {
							button.toggleClass('expand');
							var section = null;
							// Check for a target to collapse/show, if not found use the class
							if(button.get('data-collapse-target')) {
								section = collapse.getElement('.'+button.get('data-collapse-target'));
							}else{
								section = collapse.getElement('.collapsible-section');
							}
							this.toggle_options_slider(section);
						}.bind(this));
					}.bind(this));
				}.bind(this));
			},
			
			/**
			* Toggles open/close the collapsible
			* @param: option - The option slide down menu element
			**/
			toggle_options_slider: function(collapse)
			{
				// Is it already open?
				if(collapse.retrieve('status') == 'open') {
					collapse.dissolve();
				}else{
					collapse.reveal();
				}
			}
			
	});

})(document.id);