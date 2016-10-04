/**
* Class name: drag-rows.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Manages the tables in a 'manage' area, allows reordering of rows, rows moved from table to table and destroying rows
*/

var manage_tables;

(function($){
	
	manage_tables = new Class({
		
			Implements: [Events],
			
			/**
			* Constructor
			*/
			initialize: function()
			{
				// Get all the sortable containers
				this.manage = $$('#kontrol table.manage');
				 
				this.manage.each(function(table) {
					// Make mootools tables of them
					new HtmlTable(table)
					
					// Sortable tables
					if(table.hasClass('sortable')) {
						// Make sortable containers sortable
						this.make_sortable(table);
					}
					/*
					
					// Check to see how many rows they have and if we should display a 'no results' type msg
					this.check_table_rows_show_message(table);
					
					// Add events to the row options
					var rows = table.getElements('tbody > tr');
					rows.each(function(row) {
						row.getElements('.row-option').each(function(option) {
							// If it has a click event
							if(option.hasClass('click')) {
								option.addEvent('click', function(e) {
									// Does it have an ajax action and vars?
									var action = option.get('ajaxAction');
									var vars = option.get('ajaxVars');
									// Execute the action now
									this.ajax_action(action, vars);
									// Now check what to do with the row
									this.option_action(option);
									
								}.bind(this))	
							}
						}.bind(this));
					}.bind(this));
					*/
					
				}.bind(this));
				
	
				
			},
			
			/**
			/* Execute an ajax action and send the vars 
			**/
			ajax_action: function(action, vars) 
			{
				
				
				
			},
			
			/**
			/* Rows have different options to execute
			**/
			option_action: function(option) 
			{
			
				var row = option.getParent('tr');
				// Are we moving this row to another table?
				var action = option.get('rowAction');
				
				if(option.get('rowVars')) {
					// Rowvars should be an JSON object stored as a string	
					var vars = JSON.decode(option.get('rowVars'));
				}
						
				// Are we transferring this row to another table?
				if(action == 'transfer') {
					// Set the new transfer table to it's existing one
					var current_table = row.getParent('table').get('id');
					// Add it to it's target table
					var destination = $(vars.table).retrieve('HtmlTable');
					option.set('rowVars', JSON.encode({'table':current_table}));
					destination.push(row, null, null, null, 'top')
					
					// Fire an event now
					$(current_table).fireEvent('rows-altered', [$(current_table), row]);
					$(current_table).fireEvent('row-removed', [$(current_table),row]);
					// Fire an event now
					$(destination).fireEvent('rows-altered', [$(destination),row]);
					$(destination).fireEvent('row-added', [$(destination),row]);
				}
			},
			
			/**
			/* If there are no rows displayed in a table, show the no rows message
			**/
			check_table_rows_show_message: function(table) 
			{
				var table_id = table.get('id');
				if(table.getElements('tbody tr').length > 1) {
					table.getElement('#no-'+table_id+'-rows').setStyle('display', 'none');
				}else{
					table.getElement('#no-'+table_id+'-rows').setStyle('display', 'block');
				}
										
				// Add events to listen for changes in the table
				table.removeEvents('rows-altered');

				table.addEvent('rows-altered', function(table1) {
					this.check_table_rows_show_message(table1);
				}.bind(this));
			},
			
			
			/**
			/* Makes all the sortable tables...err sortable
			**/
			make_sortable: function(sortable) 
			{
				
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
									//console.log(item_clone);	
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
			
				
			}
			
		
			
	});

})(document.id);