/**
* Class name: smart-box.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Creates an easy to use smart box that is sortable, add rows, delete rows etc.
*/

var kontrol_smart_box;

window.addEvent('domready', function() {
	
	// Only start if we have some to work with
	(function($){
		if($$('.kontrol-smart-box').length > 0) {
			new kontrol_smart_box();
		}
	})(document.id);
});

(function($){
	
	kontrol_smart_box = new Class({
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.boxes = $$('.kontrol-smart-box');
				// Perform some initial checks
				this.boxes.each(function(box) {
					// Check for auto-add an initial row
					if(box.get('data-auto-add-row') == 'true' && box.getElement('.rows').getElements('> .row:not(.new-row)').length == 0) {
						var new_row_default = box.getElement('.new-row');
						// Clone it and its events
						var new_row = new_row_default.clone().cloneEvents(new_row_default);
						// Add it
						this.add_new_row(box, new_row);
					}
					// Hide or show the add row button depending on the amount of rows
					this.toggle_row_button(box);
					// Hide empty boxes
					this.hide_when_empty(box);
				}.bind(this));
				// Make existing rows sortable
				this.make_sortable();
				// Add the main events
				this.listeners();					
			},
			
			/**
			* Make the rows sortable
			*/
			make_sortable: function()
			{
				new sort_rows({'sortables':this.boxes.getElements('.sortable')});
			},
			
			/**
			* Add a new row with a given element
			*/
			add_new_row: function(container, row)
			{
				// Enable the rows form elements
				this.enable_disable_row(row, false);
				// Remove the class identifying a new row if it exists
				row.removeClass('new-row');
				// Get the html
				var row_html = row.get('html');
				// Update the row id for this new one if it exists
				
				if(row_html.contains('kontrol_row_id')) {
					row.set('html', row_html.replace(/kontrol_row_id/g, container.getElement('.rows').getElements('> .row:not(.new-row)').length));
				}
				// Enable any image/file uploads on it
				if(row_html.contains('kontrol-file-upload')) {
					new kontrol_file_upload({
						'container': row,
						'file_size_max': kontrol_upload_size_limit,
						'app_path': kontrol_app_path
					});	
				}
				// Some rows have elements that require a unique event specific to them, look for it
				row.getElements('input, select, textarea').each(function(el) {
					// Check to see if it has a function init to try on the input element - eg. date, upload
					if(el.get('data-repeater-func')) {
						eval(el.get('data-repeater-func') + "(el)");
					}
				});
				// Add the new row to the bottom
				container.getElement('.rows').grab(row, 'bottom');	
				// Check the row count
				this.toggle_row_button(container);
				// Check to see if we need to hide/show it
				this.hide_when_empty(container);
				// Make sortable
				this.make_sortable();
				// Now find any smart boxes in this new row and add events to them
				row.getElements('.kontrol-smart-box').each(function(box) {
					this.box_events(box);
				}.bind(this));
				// Fire the event
				container.fireEvent('row-added', row);

			},
			
			/**
			* Empty a smart box of its rows
			*/
			empty_rows: function(container)
			{
				container.getElements('.row:not(.new-row)').destroy();	
				this.hide_when_empty(container);
			},
			
			/**
			* Empty a smart box of its rows
			*/
			delete_row: function(container, row)
			{
				var proceed = true;
				// Check to see if we need to confirm deleting first
				if(row.get('data-row-del-msg-check')) {
					if(!confirm(row.get('data-row-del-msg-check'))) {
						proceed = false;
					}
				}
				
				if(proceed) {
					row.destroy();	
					this.toggle_row_button(container);
					// If it's hide when empty, check how many rows are left
					this.hide_when_empty(container);
					// Fire the event to let other scripts know
					container.fireEvent('row-removed', row);
				}
			},
			
			/**
			* Enable or Disable a rows form elements
			*/
			enable_disable_row: function(row, flag)
			{
				row.getElements('input, select, textarea').set('disabled', flag);	
			},
			
			/**
			* Hide or show the row button depending on the max rows var
			*/
			toggle_row_button: function(container)
			{
				if(container.getElement('.add-row')) {
					var button = container.getElement('.add-row');
					var row_limit = parseInt(button.get('data-max-rows'));
					if(!isNaN(row_limit) && row_limit > 0 && (container.getElement('.rows').getElements('> .row:not(.new-row)').length) >= row_limit) {
						button.setStyle('display', 'none');
					}else{
						button.setStyle('display', 'block');
					}	
				}
			},
			
			/**
			* Hide the box if no rows exist and the setting is enabled
			*/
			hide_when_empty: function(container)
			{
				// If it's hide when empty, check how many rows are left
				if(container.get('data-hide-when-empty')) {
					if(container.get('data-hide-when-empty') == 'true' && container.getElement('.rows').getElements('> .row:not(.new-row)').length == 0) {
						container.hide();
					}else{
						container.show();	
					}
				}
			},
			
			/**
			* Main event listeners for a smart box
			*/
			box_events: function(box)
			{
				// Disable the 'copy' row in each to prevent it submitting
				if(box.getElement('.new-row')) {
					this.enable_disable_row(box.getElement('.new-row'), true);
				}
				
			   // If the box has been shown, make sure it's first row hidden elements are still disabled - some scripts reenable fields when displayed
			   box.addEvent('show', function(box_el) {
				  //alert('DAVE'); 
			   });
			
					
				// Mouseover rows
				box.addEvents({
					
						'mouseenter:relay(.row)' : function(e) {
							var container = this.getParent('.kontrol-smart-box');
							if(container.get('data-disable-row-delete') != 'true'  && container.getElement('.rows').getElements('> .row:not(.new-row)').length > 1) {
								this.getFirst('.delete-row').show();
							}
						},
						
						'mouseleave:relay(.row)' : function(e) {
							this.getFirst('.delete-row').hide();
						},
						
						// Using the add row button within a smartbox
						'click:relay(.add-row)' : function(e) {
							var container = e.target.getParent('.kontrol-smart-box');
							// When adding a new row directly to this box, it requires a new row to copy
							var new_row_default = container.getElement('.new-row');
							// Clone it and its events
							var new_row = new_row_default.clone().cloneEvents(new_row_default);
							// Make it now
							this.add_new_row(container, new_row);
						}.bind(this),
						
						// An external script adding a row to a smartbox
						'smart-box-row-add' : function(container, row) {
							// Rows can be added by other scripts
							this.add_new_row(container, row);
						}.bind(this),
						
						'click:relay(.delete-row)' : function(e) {
							e.stopPropagation();
							var button_container = e.target.getParent('.kontrol-smart-box');
							var row = e.target.getParent('.row');
							this.delete_row(button_container, row);
						}.bind(this),
						
						'smart-box-empty-rows' : function(container) {
							this.empty_rows(container);
						}.bind(this),
						
						'smart-box-delete-row' : function(container, row) {
							this.delete_row(container, row);
						}.bind(this)
					});
				
					// Mouseover delete
					box.addEvent('click:relay(.delete-row)', function(e) {
					
				}.bind(this));
			},
			
									
			/**
			* Main event listeners
			*/
			listeners: function()
			{
				
				this.boxes.each(function(box) {
					
					this.box_events(box);
						
				}.bind(this));
				
								
			}
			
			
	});
	
	


})(document.id);