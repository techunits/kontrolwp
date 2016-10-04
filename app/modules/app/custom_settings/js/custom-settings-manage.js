/**
* Class name: custom-settings-manage.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields admin managing section
*/

var kontrol_custom_settings_manage;

(function($){
	
	kontrol_custom_settings_manage = new Class({
		
			Implements: [Options, Events],
			
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				// Set the passed options
				this.setOptions(options);
				// The main container manage area
				this.kontrol = $('kontrol');
				// Rows to manage
				this.group_rows = this.kontrol.getElement('#group-rows');
				// Add the main event listeners
				this.listeners();
					
			},
			
			
			/**
			/* Hide a group in that post type
			**/
			hide_group_ajax: function(group_pt_id, flag) 
			{
				if(group_pt_id) {
					// Hide the field
					new Request({
						  url: this.options.ajax_url+'/hideGroupPostType/&noheader=true&cache=', 
						  data: 'id='+group_pt_id+'&flag='+flag,
						  noCache: true,
						  onError: function(text, error) {
							  alert(kontrol_i18n_js.error_server+': '+text+' - Error: '+error);	
						  }
				   }).send();
				}

			},
			
					
			/**
			/* Delete a whole setings group + fields
			**/
			delete_settings_group_ajax: function(group_pt) 
			{
				if(group_pt) {
					// Hide the field
					new Request({
						  url: this.options.ajax_url+'/DeleteSettingsGroup/&noheader=true&cache=', 
						  data: 'pt_type='+group_pt,
						  noCache: true,
						  onError: function(text, error) {
							  alert(kontrol_i18n_js.error_server+': '+text+' - Error: '+error);	
						  },
						  onComplete: function(resp) {
							 // alert(resp);
							// Save form and reload the page
							 $('cs-settings-add').submit();
						  }
						  
				   }).send();
				}

			},
			
			/**
			/* Event Listeners
			**/
			listeners: function() 
			{
				// Hide the row when the hide button is pressed
				this.group_rows.addEvent('click:relay(.hide-field)', function(e) {
						var row = e.target.getParent('.row');
						// Get the value of the hidden active field 
						var flag = null;
						var opacity = row.getStyle('opacity');
						if(opacity == 0.5) {
							row.setStyle('opacity', 1);	
							flag = 1;
						}else{
							row.setStyle('opacity', 0.5);	
							flag = 0;	
						}		
						// Update the DB now
						this.hide_group_ajax(row.get('data-id'), flag);
				}.bind(this));
				
				
				// Listen for a new category row being added
				$('settings-cats').addEvent('row-added', function(row) {
					
				});
				
				// Listen for a category row being removed
				$('settings-cats').addEvent('row-removed', function(row) {
					// Check to see if it has a saved pt key (already existing row)
					if(row.getElement('.row-pt-key')) {
						var pt_key = row.getElement('.row-pt-key').get('value');
						// Now delete it's groups via ajax
						if(pt_key) {
							this.delete_settings_group_ajax(pt_key);
						}
						
					}
				}.bind(this));
				
								
							
			}

	});
	
	


})(document.id);