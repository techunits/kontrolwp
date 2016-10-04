/**
* Class name: sort-rows.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Manages the rows in a 'manage' area, allows reordering of rows, rows moved from table to table and destroying rows
*/

var sort_rows;

(function($){
	
	sort_rows = new Class({
		
			Implements: [Events, Options],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{

				this.setOptions(options);
				
				// Get all the sortable containers
				if(!this.options.sortables) {
					this.sortables = $$('#kontrol .sortable');
				}else{
					this.sortables = this.options.sortables;
				}
				 
				// Make sortable containers sortable
				this.sortables.each(function(sortable) {
					this.make_sortable(sortable);		
				}.bind(this));
	
			},
			
			/**
			/* Execute an ajax action and send the vars 
			**/
			ajax_action: function(updateURL) 
			{
				
				new Request({
					url: updateURL+"&noheader=true",
					onComplete: function(resp) {
						//console.log(resp);
					},
					method: 'POST'
				}).send();
				
			},
			
			/**
			/* Makes all the sortable containers...err sortable
			**/
			make_sortable: function(sortable) 
			{
				
					var ob = this;
				
					new Sortables(sortable, {
							'handle': '.drag-row',
							'revert': { duration: 500, transition: 'elastic:out' },
							'clone': true,
							'constrain': true,
							'onStart': function(item, item_clone) {
										
									// Remove all borders on the clone
									item_clone.setStyle('border-top', '1px solid #ccc');
									item_clone.setStyle('border-bottom', '1px solid #ccc');
									item_clone.setStyle('opacity', 0.75);
									item_clone.setStyle('background-color', '#fffaf6');
									item_clone.setStyle('z-index', 99);
	
									// If its a table row, space the cells evenly when displaying the clone
									if(item_clone.get('tag') == 'tr') {
										var tds = item_clone.getElements('td.clone-resize');
										var tr_width = item_clone.getStyle('width').toInt();
										tds.setStyle('width', (tr_width/tds.length)+'px');
									}
									
							},
							'onSort': function(item, item_clone) {
									this.sort_clone = item_clone;
							},
							'onComplete': function(item) {
								
								if(this.sort_clone) {
									
									// Remove the clone
									//this.sort_clone.destroy();
									// Fire an event on the container to let other scripts know sorting has finished
									item.fireEvent('sort-updated', [this, item]);
									// Flash the item
									item.highlight('#ffd0aa', '#fff');
									// Get the order of the sorted item
									var index = 0;
									// Perform an ajax action if defined
									if(item.get('sortAction')) {
											this.serialize().each(function(current_item) {								
											if(current_item) {
												if($(current_item).get('id') == item.get('id')) {
													// Update the sort order via ajax now that we have the new sort number
													var updateURL = item.get('sortAction')+index;
													ob.ajax_action(updateURL);
												}
												index++;
											}
										});
									}
								}
									
							}
					});
			
				
			}
			
		
			
	});

})(document.id);