/**
* Class name: seo-meta.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the SEO meta boxes / validation
*/

var kontrol_seo_meta;

window.addEvent('domready', function() {
	
	// Only start on the post body screens
	(function($){
		if($('post') && $('kontrol-SEO')) {
			new kontrol_seo_meta();
		}
	})(document.id);
});

(function($){
	
	kontrol_seo_meta = new Class({
		
			/**
			* Constructor
			*/
			initialize: function()
			{
				// Init
				this.title_length = 70;
				this.desc_length = 156;
				// Main Container
				this.seo = $('kontrol-SEO');
				this.serp = null;
				if(this.seo.getElement('.seo-preview')) {
					this.serp = this.seo.getElement('.seo-preview');
				}
				this.title_seo = this.seo.getElement('input.seo-title');
				this.desc_seo = this.seo.getElement('textarea.seo-desc');
				this.title_auto_gen = this.seo.getElement('.auto-button.title');
				// Wordpress Elements
				this.wp_title = null;
				if($('post-body').getElement('input#title')) {
					this.wp_title = $('post-body').getElement('input#title');
				}
				// Hide or show the auto generate
				this.toggle_title_auto_generate();
				// Main Listerners
				this.listeners();
				// Remove the box class from any groups that have that style
				if(this.seo.getElement('div.kontrol-SEO-nobox')) {
					this.seo.removeClass('postbox');
				};
				// SEO Type
				if(this.seo.getElement('.kontrol-seo-select')) {
					this.seo_type_change();
				}
			},
			
			/**
			* When the dropdown toggles between default and setting custom SEO
			*/
			seo_type_change: function()
			{
				var select = this.seo.getElement('.kontrol-seo-select');
				var custom_fields = this.seo.getElements('.seo-custom-field');
				// Default
				if(select.get('value') == 'default') {
					custom_fields.hide();
					custom_fields.getElements('input, select, textarea').each(function(el) {
							el.set('disabled', true);
					});
					// Update the serp with the defaults
					if(this.serp) {
						this.update_preview_title(this.title_seo.get('data-default-title'));
						this.update_preview_desc(this.desc_seo.get('data-default-desc'));
				    }
					
				}else{
					custom_fields.show();
					custom_fields.getElements('input, select, textarea').each(function(el) {
						el.set('disabled', false);
					});
					if(this.serp) {
						this.update_preview_title();
						this.update_preview_desc();
				    }
				}
				
			},
			
			/**
			* Updates the title SEO
			*/
			update_preview_title: function(title)
			{
					
				  // Get the title input 
				  if(!title) {
				 	 title = this.title_seo.get('value');
				  }
				  var serp_title = title;
				  // Check length
				  if(title.length > this.title_length) {
					  serp_title = title.substr(0, this.title_length)+'...';	
				  }
				  if(this.serp) {
					  // Update the SERP
					  this.serp.getElement('.seo-title').set('text', serp_title);
				  }
				  // Update the counter
				  var letters_left = this.title_length - title.length;
				  if(letters_left < 1) {
					  this.seo.getElement('.title-count').addClass('red');
				  }else{
					  this.seo.getElement('.title-count').removeClass('red');
				  }
				  this.seo.getElement('.title-count').set('text', letters_left);
				
			},
			
			/**
			* Updates the desc SEO
			*/
			update_preview_desc: function(desc)
			{
				  // Get the title input 
				  if(!desc) {
				  	desc = this.seo.getElement('textarea.seo-desc').get('value');
				  }
				  var serp_desc = desc;
				  // Check length
				  if(desc.length > this.desc_length) {
					  serp_desc = desc.substr(0, this.desc_length)+'...';	
				  }
				  if(this.serp) {
					  // Update the SERP
					  this.serp.getElement('.seo-desc-text').set('text', serp_desc);
				  }
				  // Update the counter
				  var letters_left = this.desc_length - desc.length;
				  if(letters_left < 1) {
					  this.seo.getElement('.desc-count').addClass('red');
				  }else{
					  this.seo.getElement('.desc-count').removeClass('red');
				  }
				  this.seo.getElement('.desc-count').set('text', letters_left);
				
			},
			
			/**
			* Toggle the title auto generate
			*/
			toggle_title_auto_generate: function()
			{
				if(this.wp_title) {
					if(this.wp_title.get('value') != '') {
						this.title_auto_gen.show();	
					}else{
						this.title_auto_gen.hide();
					}
				}else{
					this.title_auto_gen.hide();
				}
			},
			
			/**
			* Auto Generate the SEO Title
			*/
			auto_generate_title: function(button)
			{
				var new_title = null;
				var post_title = null;
				var site_title = button.get('data-wp-site-title');
				var default_title = button.get('data-default-title');
				var current_seo_title = this.title_seo.get('value');
	
				if(this.wp_title) {
					// Get the current post title
					if(default_title == '' && this.wp_title.get('value') != '') {
						new_title = this.wp_title.get('value') + ' : '+site_title;	
					}else{
						new_title = default_title;
					} 
				}else{
					new_title = default_title;
				}
				
				// Replace the current one?
				if(current_seo_title.length > 0) {
					var check = confirm(kontrol_i18n_js.seo_replace_title+"\n\n"+new_title);
					if(check) {
						if(this.serp) {
							  // Update the SERP
							  this.serp.getElement('.seo-title').set('text', new_title);
						}
						this.title_seo.set('value', new_title);	
					}
				}else{
					this.title_seo.set('value', new_title);
				}
			},
			
			
			/**
			* Main Event Listeners
			*/
			listeners: function()
			{
				// Hide the generate buttons if the fields are empty or don't exist that are required
				if(this.wp_title) {
					this.wp_title.addEvent('blur', function(e) {
						this.toggle_title_auto_generate();
					}.bind(this));
				}
				
				this.title_auto_gen.addEvent('click', function(e) {
					this.auto_generate_title(e.target);
				}.bind(this));
				
				// Title
				this.title_seo.addEvent('keyup', function() {
					this.update_preview_title();
				}.bind(this));
				this.title_seo.addEvent('blur', function() {
					this.update_preview_title();
				}.bind(this));
				// Desc
				this.seo.getElement('textarea.seo-desc').addEvent('keyup', function() {
					this.update_preview_desc();
				}.bind(this));
				
				this.seo.getElement('textarea.seo-desc').addEvent('blur', function() {
					this.update_preview_desc();
				}.bind(this));
				
				if(this.seo.getElement('.kontrol-seo-select')) {
					// SEO Type
					this.seo.getElement('.kontrol-seo-select').addEvent('change', function() {
						this.seo_type_change();
					}.bind(this));
				}
			
				
			}
			
			
	});
	
	


})(document.id);