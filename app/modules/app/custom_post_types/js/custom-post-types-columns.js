/**
* Class name: custom-post-types-columns.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Allows column sorting on the custom post types
*/

var kontrol_cpt_columns;

(function($){
	
	// Prepopulates other fields when adding a new custom post type
	kontrol_cpt_columns = new Class({
		
			Implements: [Events, Options],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				this.setOptions(options);
				
				this.col_containers = $$('#kontrol .row-cols');
				
				// Set the listeners
				this.listeners();
				
				this.col_containers.getElements('.col .custom-select').each(function(select_el) {
						this.col_type_selected(select_el);
				}.bind(this));
				
			},
			
				
			/**
			* Save the columns
			*/
			save_cols: function(container) {
				
				// Change the icon to normal
				container.getElement('.save-cols').addClass('saved');
				// Get all the columns values and save
				var cpt_id = container.get('data-cpt-id');
						
				new Request({
					url: this.options.ajax_url+"/savecols/"+cpt_id+"&noheader=true",
					data: container.toQueryString(),
					method: 'POST',
					onComplete: function(resp) {
						// Change the icon to 'saved'
						container.getElement('.save-cols').removeClass('saved');
					}
					
				}).send();
				
			},
			
			/**
			* When the column type is selected
			*/
			col_type_selected: function(select_el) {
				
				var value = select_el.get('value');
				
				// Hide the post links checkbox if it's default options
				if(value == 'default' || value == '') {
					TweenLite.fromTo(select_el.getNext('.col-post-link'), 1, 
						{css: {rotationY: 0, z: 0, rotationX: 0, alpha: 1}, ease:Expo.easeOut}, 
						{css: {rotationY: -180, z: -500, rotationX: 180, alpha: 0}} 
						
					);
				}else{
					TweenLite.to(select_el.getNext('.col-post-link'), 2, 
						{css: {rotationY: 0, z: 0, rotationX: 0, alpha: 1}, ease:Expo.easeOut} 
					);
				}
				
			},
			
			/**
			* Main event listeners
			*/
			listeners: function() {
				
				// Listen for when a new col is created, make it sortable
				window.addEvent('duplication-event-completed', function(duplicate, parent) {
					// Makes the rows sortable
					new sort_rows();
				});
				
				// Saving cols
				this.col_containers.getElement('.save-cols').addEvent('click', function(e) {
						this.save_cols(e.target.getParent('.row-cols'));
				}.bind(this));
				
				// If the value selected is default, hide the post link
				this.col_containers.each(function(container) {
						container.addEvent('change:relay(.custom-select)', function(e) {
							this.col_type_selected(e.target);
						}.bind(this));
				}.bind(this));
				
			}
		
			
	});

})(document.id);