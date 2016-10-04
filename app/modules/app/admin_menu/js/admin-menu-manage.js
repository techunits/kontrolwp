/**
* Class name: admin-menu-manage.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields admin managing section
*/

var kontrol_admin_menu_manage;

(function($){
	
	kontrol_admin_menu_manage = new Class({
		
			/**
			* Constructor
			*/
			initialize: function()
			{
				// The main container manage area
				this.kontrol = $('kontrol');
				this.admin_menu = this.kontrol.getElement('#admin-menu');
				// Makes the rows sortable
				new sort_rows();
				// Sets the background images for menu icons
				this.set_menu_icons();
				// Add the main event listeners for the tools
				this.menu_tools();
				// Add states to the hidden collapsable submenus
				var submenus = this.admin_menu.getElements('.am-submenu');
				submenus.each(function(submenu) {
					//this.options_effects_add(submenu, 'closed');
					submenu.hide();
					this.options_effects_add(submenu, 'closed');
				}.bind(this));
				// Add click and general listeners now
				this.listeners();
					
			},
			
			/**
			/* Controls how the admin menu tools operate
			**/
			menu_tools: function() 
			{
			
				// New seperator
				this.admin_menu.addEvent('click:relay(.admin-menu-add-seperator)', function(e) {
					var new_row = this.kontrol.getElement('#new-am-row-seperator .row').clone();
					var section = e.target.getParent('.section');
					section.getElement('.rows').grab(new_row, 'top');	
					
					if(section.hasClass('submenu-block')) {
						// Update the type
						new_row.getElement('input.row-type').set('value','sub');
					}
					
					// Makes the rows sortable
					new sort_rows();
				}.bind(this));
				
				// New row
				this.admin_menu.addEvent('click:relay(.admin-menu-add-row)', function(e) {
					var new_row = this.kontrol.getElement('#new-am-row .row').clone();
					var section = e.target.getParent('.section');
					section.getElement('.rows').grab(new_row, 'top');	
					// Makes the rows sortable
					new sort_rows();
					// Close it and set effects
					new_row.getElements('.am-submenu').each(function(submenu) {
						this.options_effects_add(submenu,'open');
					}.bind(this));
					// Add the upload button JS
					new kontrol_file_upload({
						'container': new_row,
						'file_size_max': kontrol_upload_size_limit,
						'app_path': kontrol_app_path
					});	
					// Remove the submenu rows in submenus and update the hidden value
					if(section.hasClass('submenu-block')) {
						new_row.getElement('.am-submenuoptions').destroy();	
						new_row.getElement('.submenu-field').destroy();
						// Update the type
						new_row.getElement('input.row-type').set('value','sub');
					}
				}.bind(this));

			},
			
			/**
			/* Sets the background images for menu icons if available
			**/
			set_menu_icons: function() 
			{
				this.admin_menu.getElements('.row').each(function(row) {
					if(row.get('data-id')) {
						var menu_id = row.get('data-id');
						if($(menu_id)) {
							var bg_image = $(menu_id).getElement('.wp-menu-image').getStyle('background-image');
							var bg_pos = $(menu_id).getElement('.wp-menu-image').getStyle('background-position');
							if(bg_image && bg_pos) {
								if(row.getElement('.am-icon')) {
									row.getElement('.am-icon').setStyle('background-image', bg_image);	
									row.getElement('.am-icon').setStyle('background-position', bg_pos);
								}
							}
						}
					}
				});

			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Edit the menu title
				this.admin_menu.addEvent('keyup:relay(.submenu-title)', function(e) {
					e.target.getParent('.row').getElement('.menu-name').set('text', e.target.get('value'));
				}.bind(this));
				
				// The collapse/show buttons
				this.admin_menu.addEvent('click:relay(.button-collapse)', function(e) {
					// Validate the form
					if(fields_validator.validate()) {
						var collapse = e.target.getParent('.row').getElement('.'+e.target.get('data-show-target'));
						this.toggle_options_slider(collapse);				
					}
				}.bind(this));
				
				// Delete the menu item
				this.admin_menu.addEvent('click:relay(.delete-field)', function(e) {
					// Confirm
					if(confirm(kontrol_i18n_js.delete)) {
						var hide_field = e.target.getParent('.row').getElement('.row-deleted');
						hide_field.set('value', 'true');
						e.target.getParent('.row').hide();
					}
				}.bind(this));
				
				// Hide the menu item
				this.admin_menu.addEvent('click:relay(.hide-field)', function(e) {
					// Validate the form
					if(fields_validator.validate()) {
						var row =  e.target.getParent('.row');
						var hide_field = row.getElement('.row-visible');
						var hide_val = hide_field.get('value');
						
						if(row.hasClass('hidden-row')) {
							row.removeClass('hidden-row');	
							hide_field.set('value', 'true');
						}else{
							row.addClass('hidden-row');	
							hide_field.set('value', 'false');
						}		
					}
				}.bind(this));
				
				// Reset the menu
				this.kontrol.getElement('#reset-menu-link').addEvent('click', function(e) {
					if(confirm(kontrol_i18n_js.confirm)) {
						this.kontrol.getElement('input#reset-menu').set('value', 'true');	
						// Submit it now
						this.kontrol.getElement('#am-save').submit();
					}
				}.bind(this));
			},
			
			/**
			* Toggles open/close the collapsible
			**/
			toggle_options_slider: function(collapse)
			{
				// Is it already open?
				if(collapse.retrieve('status') == 'open') {
					collapse.dissolve();
				}else{
					collapse.reveal();
				}
			},
			
			/**
			* Sets the open/close effects
			**/
			options_effects_add: function(submenu, status)
			{
				if(!status) { status = 'closed'; }
				// Set the effects and hide them
				if(status == 'closed') {
					new Fx.Reveal(submenu, {duration: 0}).dissolve();
				}
				
				submenu.store('status', status);
				// Set the effects now
				submenu.set('reveal', {duration: 550, transition: Fx.Transitions.Quad.easeOut, transitionOpacity: false,
									  onComplete: function() {
										  if(this.retrieve('status') == 'closed') {
											  this.store('status', 'open');
										  }else{
											  this.store('status', 'closed');
										  }
									  }.bind(submenu)
				});
			}
			
	});
			
	
})(document.id);