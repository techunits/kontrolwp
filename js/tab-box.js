/**
* Class name: tab-box.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Creates an easy to use tab box 
*/

var kontrol_tab_box;

window.addEvent('domready', function() {
	
	// Only start if we have some to work with
	(function($){
		if($$('.kontrol-tab-box').length > 0) {
			new kontrol_tab_box();
		}
	})(document.id);
});

(function($){
	
	kontrol_tab_box = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.boxes = $$('.kontrol-tab-box');
				// Add the main events
				this.listeners();					
			},
			
			select_tab: function(box)
			{
				// Hide all content slides
				box.getElements('.kontrol-tab-slide').hide();
				// Show the desired one
				box.getElement('#'+box.getElement('.in').get('data-tab-load')).show();
			},
			
			/**
			* Main event listeners for a smart box
			*/
			listeners: function(box)
			{
				this.boxes.each(function(box) {
					
					// Select the initial tab
					this.select_tab(box);
					
					// All the events
					box.addEvents({
						'click:relay(.kontrol-tab a)' : function(e) {
							var tab = e.target.getParent('div');
							tab.getSiblings().removeClass('in');
							tab.addClass('in');
							this.select_tab(box);
						}.bind(this)
					});
				}.bind(this));
				
			}
	
	});
	
	


})(document.id);