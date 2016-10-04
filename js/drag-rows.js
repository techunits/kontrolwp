/**
* Class name: drag-rows.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Creates a class that allows rows to be dragged, fires events when they are
*/

var drag_rows;

(function($){
	
	drag_rows = new Class({
		
			Implements: [Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				
				// Get all the sortable containers
				this.sortables = $$('#kontrol .sortable');
				// Make sortables out of each sortable element container
				this.sortables.each(function(sortable) {
						// Make mootools tables of them
						new HtmlTable(sortable)
						// If it's a table, make it sortable by the tbody to avoid the thead
						if(sortable.getElement('> tbody')) {
							sortable = sortable.getElement('> tbody');
						}
						new Sortables(sortable, {
								'handle': '.drag-row',
								'revert': { duration: 500, transition: 'elastic:out' },
								'clone': true,
								'onStart': function(item, item_clone) {
										// Get all the widths from the td elements
										if(item_clone.getElement('td')){
											var row_width = item_clone.getStyle('width').toInt();
											item_clone.getElements('td').each(function(td) {
												// Change the size of the td's width to fill up the row when cloning
												var width = td.get('width').toInt();
												td.setStyle('width', ((td.get('width').toInt()/100)*row_width)+'px');
											});
										}
										
										// Remove all borders on the clone
										item_clone.setStyle('border-top', '1px solid #ccc');
										item_clone.setStyle('border-bottom', '1px solid #ccc');
										item_clone.setStyle('opacity', 0.75);
										item_clone.setStyle('background-color', '#fffaf6');
										//table.grab(item_clone);
										//item_clone = table;
										console.log(item_clone);	
								},
								'onSort': function(item, item_clone) {
										// Fire an event on the container to let other scripts know sorting has finished
										sortable.fireEvent('sort-updated', item);
								},
								'onComplete': function(item) {
										// Flash the item
										item.highlight('#ffd0aa', '#fff')
								}
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
				
				
				
			}
			
	});

})(document.id);