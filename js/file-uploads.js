/**
* Class name: file-uploads.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* A shell for handling uploads using the Fancyupload script
*/

var kontrol_file_upload;

(function($){
	
	kontrol_file_upload = new Class({
		
			Implements: [Events, Options],
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.setOptions(options);
				
				// Get all the file upload areas in the container, or the page if it's not set
				if(this.options.container) {
					this.file_uploads = this.options.container.getElements('.kontrol-file-upload');
				}else{
					this.file_uploads = $$('.kontrol-file-upload');
				}
				
					
				// Determine what type each one is
				this.file_uploads.each(function(file) {
					
					// Don't attach an instance if it already has one
					if(!file.retrieve('upload-attached')) {
						
						// Add remove events for any files currently loaded 
						file.getElements('.file .remove-file').addEvent('click', function() {
							var parent_li = this.getParent('li');
							if(confirm(kontrol_i18n_js.remove_upload)) {
								//this.getParent('.file').destroy();
								// Set the value to nothing
								parent_li.getElement('input[type=hidden]').set('value','');
								// Hide the file elements
								parent_li.addClass('removed');
																
								// Check to see if that was the last one
								if(this.getSiblings('.file:not(.removed)').length == 0) {
									// It was? show the upload button now
									file.getElements('.upload-el').setStyle('display','block');
								}
							}
						});
						
						// Max upload size for this upload
						var max_upload_bytes = this.options.file_size_max;
						var multiple_bool = false;
						var file_list_max = 1;
						var file_types_select = null;
						var file_upload_type = null;
						var file_params = null;
						var file_params_url = '';
						var file_get_data = null;
						var file_return = 'attachment_id';
						var file_return_input_name = 'uploaded_files['+file_upload_type+'][]';
						var file_return_input_name_update = null;
						var file_image_upload_effects = false;
						
						// Get the image upload element - the thing we click to initiate the upload
						var upload_el = file.getElement('.upload-el');
						// Get the list for the notifications - file completes etc.
						var upload_list = file.getElement('.upload-list');
						
						// Get the max size of this upload element if it's been provided and doesn't exceed the max
						if(file.get('data-maxSize')) {
							if(file.get('data-maxSize') < this.options.file_size_max) {
								max_upload_bytes = file.get('data-maxSize').toFloat() * 1024;	
							}
						}
						
						// Allow the user to select multiple files in the file picker screen?
						if(file.get('data-multiple')) {
							var multi_check = file.get('data-multiple');
							if(multi_check == 'true') {
								multiple_bool = true;	
							}
						}
						
						// How many files to upload
						if(file.get('data-fileListMax')) {
							file_list_max = file.get('data-fileListMax');
						}
						
						// What type of files to allow
						if(file.get('data-fileTypes')) {
							// The provided files types should be a key/pair object/string
							file_types_select = eval("(" + file.get('data-fileTypes') + ")");
						}
						
						// What type of file
						if(file.get('data-fileUploadType')) {
							file_upload_type = file.get('data-fileUploadType');
						}
						
						// File parameters
						if(file.get('data-fileParams')) {
							file_params = file.get('data-fileParams');
							// The file params will be added to the url, so make them a directory structure
							file_params = JSON.decode(file_params);
							Object.each(file_params, function(value) {
								if(!value) {
										value = 0; 
									}
								// Remove hashes from values to prevent the string cutting off						
								file_params_url += (value+'/');
							});
						}
						
						// File data parameters
						if(file.get('data-fileGetData')) {
							file_get_data = file.get('data-fileGetData');
						}
						
						// If we have a return type, we can return the file as a WP attachment id or an image url
						if(file.get('data-fileReturn')) {
							file_return = file.get('data-fileReturn');
						}
						
						// We create a hidden input element when the file uploads successfully, this is the desired name of it
						if(file.get('data-fileReturnInputName')) {
							file_return_input_name = file.get('data-fileReturnInputName');
						}
						
						// We can update a hidden input element when the file uploads successfully, this is the desired name of it
						if(file.get('data-fileReturnInputNameUpdate')) {
							file_return_input_name_update = file.get('data-fileReturnInputNameUpdate');
						}
						
						// Store a var to say this one has been attached
						file.store('upload-attached', true);
						
						// Add effects to the image when uploaded eg. bounce effect
						if(file.get('data-upload-effects')) {
							file_image_upload_effects = file.get('data-upload-effects');
						}
						
						
						//alert(this.options.app_path+'?upload=true&ac='+file_upload_type+'&'+file_get_data);
				
						
						// Attach the fancy upload instance now with our configuration
						var up = new FancyUpload3.Attach(upload_list, upload_el, 
						{
								path: this.options.app_path+'js/fancyupload/source/Swiff.Uploader.swf',
								url: this.options.app_path+'?upload=true&ac='+file_upload_type,
								method: 'post',
								data: file_get_data,
								fileSizeMax: max_upload_bytes,
								verbose: false,
								multiple: multiple_bool,
								fileListMax: file_list_max,
								typeFilter: file_types_select,
								uploadType: file_upload_type,
								fileReturn: file_return,
								fileReturnInputName: file_return_input_name,
								fileReturnInputNameUpdate: file_return_input_name_update,
							
										
								onStart: function() {
									this.selects.setStyle('display', 'none');
								},
								
														
								onSelectFail: function(files) {
									files.each(function(file) {
										new Element('li', {
											'class': 'file-invalid',
											events: {
												click: function() {
													this.destroy();
												}
											}
										}).adopt(
											new Element('span', {html: file.validationErrorMessage || file.validationError})
										).inject(this.list, 'bottom');
									}, this);	
									
									this.selects.setStyle('display', 'block');
								},
								
								onFileSuccess: function(file) {
											
									//console.log(file.response.text);
									
									var resp = file.response;
									var resp_error = null;
								
									// Check for PHP errors first
									if((resp.text.test('error', 'i') || resp.text.test('warning', 'i')) &&  !resp.text.test('"error"', 'i')) {
		
										resp_error = 'PHP - '+resp.text;
									}
														
									if(file.response.text && !resp_error) {
																		
										resp = JSON.decode(file.response.text);
										resp_error = resp.error;
									}
									
									// Check for server side errors with the file even though it may have uploaded ok
									if(resp.status == 0 || resp_error) {
										new Element('span', {html:'Error: '+resp_error, 'class':'file-error'}).inject(file.ui.element, 'top');
										file.ui.element.addClass('remove');
										file.ui.element.addEvent('click', function(e) {
												this.fileRemove(file);
										}.bind(this));
									}else{
										// File is ok, add it				
										var hidden_value;
										
										// What value do we save to the hidden input?
										if(file.base.options.fileReturn == 'attachment_id') {
											hidden_value = resp.id;
										}
										
										// An image url?
										if(file.base.options.fileReturn == 'image_url') {
											hidden_value = resp.image[0];
										}
										
										// Are we creating a new hidden element or updating one?
										// Updating one
										if(file.base.options.fileReturnInputNameUpdate) {
											file.ui.element.getParent('div').getElement(file.base.options.fileReturnInputNameUpdate).set('value',hidden_value); 								
										}else{				
											new Element('input', {type: 'hidden', name:file.base.options.fileReturnInputName, 'value': hidden_value}).inject(file.ui.element, 'top');
										}
										
										
										file.ui.element.highlight('#e6efc2');
										file.ui.element.addClass('remove');
										var self = this;
																	
										// If there's any validation advice in there, remove it now
										file.ui.element.getParent('div').getElements('.validation-advice').destroy();
										
										// If it is an image upload, grab the return image url
										if(file.base.options.uploadType == 'image') {
											var div = new Element('div', {'class':'file-image'});
											var thumb = new Element('img', {'src':resp.image[0]});
											// Add effects?
											if(file_image_upload_effects == 'true') {
											//	thumb.setStyles({'width':0,'height':0});
											}
											div.grab(thumb).inject(file.ui.element, 'top');
											// Add effects?
											if(file_image_upload_effects == 'true') {
												//TweenLite.to(thumb, 2, {width:"100%", height:"100%", ease:Power2.easeInOut});
												var randomVal = Math.random() * 50 - 25;
												TweenLite.fromTo(thumb, 2, 
													// We need to flip the number sign for rotationX, so we do -randomVal instead of randomVal
													{css: {rotationY: -180, z: -500, rotationX: 180, alpha: 0}}, 
													{css: {rotationY: 0, z: 0, rotationX: 0, alpha: 1}, ease:Expo.easeOut}
												);
											}
											// If the file return type
										}
										
										// If it is a file upload, grab the return link
										if(file.base.options.uploadType == 'file') {
												var file_title = file.ui.element.getElement('.file-title');
												var file_name = file_title.get('text');
												file_title.set('html', resp.link);
										}
										
									}
								},
								
								onFileRemove: function(file) {
									file.ui.element.destroy();
									this.selects.setStyle('display', 'block');
								},
								
								onFileError: function(file) {
										file.ui.cancel.set('html', 'Retry').removeEvents().addEvent('click', function() {
										file.requeue();
										return false;
									});
									
									new Element('span', {
										html: file.errorMessage,
										'class': 'file-error'
									}).inject(file.ui.cancel, 'after');
									
									this.selects.setStyle('display', 'block');
								},
								
								onFileRequeue: function(file) {
									file.ui.element.getElement('.file-error').destroy();
									
									file.ui.cancel.set('html', 'Cancel').removeEvents().addEvent('click', function() {
										file.remove();
										return false;
									});
									
									this.start();
								}
					
						}) // End fancy ul
						
					}
					
					
				}.bind(this));
				
				
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