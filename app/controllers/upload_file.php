<?php
/**********************
* Handles a ajax file upload and creates a wp attachment out of it
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class UploadFileController extends Lvc_PageController
{
	
	private $filedata = NULL;
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();

		$this->loadDefaultView = false;
				
		// Do some general error checking first
		if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
			$this->returnError('Missing $_FILES[\'Filedata\'] or $_FILES[\'Filedata\'][\'tmp_name\']');
		}else{
			$this->filedata = $_FILES['Filedata'];
		}
		
		
			
	}
	
	/**********************
	* Output an error in JSON
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function returnError($error)
	{
		if ($error) {
			$return = array(
				'status' => '0',
				'error' => $error
			);
			$this->finish($return);
		}
	}
	
	
	/**********************
	* Finish the request and output a JSON return string
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function finish($data = NULL)
	{
		
		if(empty($data)) {
			$data = array(
				'status' => '1',
				'error' => ''
			);	
		}
		
		header('Content-type: application/json');
		echo json_encode($data);
		exit();
		
	}
	
	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
	}
	
	/**********************
	* Save as an attachment in WP
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function saveAttachment($authorID, $postID = '', $filedata = NULL, $type = 'media', $desc = NULL)
	{
		// Grab the WP admin file
		require_once(ABSPATH . 'wp-admin/includes/admin.php');
		
		// Extra post data for the attachment
		$extra = array('post_author'=>$authorID);
		
		// The type of upload? Media upload
		if($type == 'media') {
			// The core WP file attachment handle  
			$id = media_handle_upload('Filedata', $postID, $extra);
		}
		
		// Side load takes a file that wasn't uploaded just now
		if($type == 'copy') {
			// The side WP file attachment handle  
			$id = media_handle_sideload($filedata, $postID, $desc);
		}

		if ( is_wp_error($id) ) {  
			$this->returnError(__('Error uploading as Wordpress attachment.','kontrolwp'));
		}  
		
		return $id;
		  
	}
	
	/**********************
	* Handles receiving an uploaded file via ajax
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionFile()
	{
		$post_id =  isset($_POST['post_id']) ? $_POST['post_id'] : 0;
		
		$id = $this->saveAttachment($_POST['user_id'], $post_id);
		$data = array('id'=>$id, 'link'=>wp_get_attachment_link($id));
		$this->finish($data);
	}
	
	/**********************
	* Handles receiving an uploaded image file via ajax
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionImage()
	{
		
		if(!isset($_POST['data'])) { 
			die('Image cannot be altered directly.'); 
		};
		
		$post_id =  isset($_POST['post_id']) ? $_POST['post_id'] : 0;
		
		$image_ids = array();
		
		// All of image info is contained here
		$settings = $_POST['data'];
		
		// Grab our image manipulation/effects class
		require_once(APP_PATH . 'classes/AppImage.class.php');
		
		if (!($size = @getimagesize($this->filedata['tmp_name']) )) {
			$this->returnError(__('Please upload only images, no other files are supported.','kontrolwp'));
		}
		
		// If they are required to upload an image at an already specified h/w, then check now
		if(isset($settings['image_dimensions']) && $settings['image_dimensions'] == 'enforce') {
			// If the width and height are supplied, but resize is set to 0, it means the uploaded image needs to match those dimensions
			if(!empty($settings['image_dimensions_w']) && !empty($settings['image_dimensions_h'])) {
				  if($settings['image_dimensions_w'] != $size[0] || $settings['image_dimensions_h'] != $size[1]) {
						$this->returnError(sprintf(__('Image must be %d px wide and %d px high.','kontrolwp'), $settings['image_dimensions_w'], $settings['image_dimensions_h']));  
				  }
			}
			
			// If the width is supplied, but height, resize is set to 0, it means the uploaded image needs to match those dimensions
			if(!empty($settings['image_dimensions_w']) && empty($settings['image_dimensions_h'])) {
				  if($settings['image_dimensions_w'] != $size[0]) {
						$this->returnError(sprintf(__('Image must be %d px wide.','kontrolwp'), $settings['image_dimensions_w']));  
				  }
			}
			
			// If the height is supplied, but width, resize is set to 0, it means the uploaded image needs to match those dimensions
			if(empty($settings['image_dimensions_w']) && !empty($settings['image_dimensions_h'])) {
				  if($settings['image_dimensions_h'] != $size[1]) {
						$this->returnError(sprintf(__('Image must be %d px high.','kontrolwp'), $settings['image_dimensions_h']));  
				  }
			}
		}
		
		// Create a new image editing / effects object
		$image = new Kontrol_Image();
		// Load the tmp image file that was uploaded
		$image->load($this->filedata['tmp_name']);
		// Process the image for effects / reszing etc
		$image = $this->imageProcess($image, $_POST['data']);
		// Have we changed it? save the changed ver over the current tmp file if we have
		if($image->changed) {
			// Save it over the temp file
			$image->save($this->filedata['tmp_name']);	
		}
		
		// Are we making copies of this image? If so do it now while we still have access to the temp file
		if(isset($settings['image_copy']) && is_array($settings['image_copy']) && count($settings['image_copy']) > 0) {
			$index = 0;
			foreach($settings['image_copy'] as $copy_settings) {
				// New temp file for this copy
				$copy_temp_name = $this->filedata['tmp_name'].$index;
				// Copy the temp file to use as our copy
				copy($this->filedata['tmp_name'], $copy_temp_name);
				// Apply effects
				$image = new Kontrol_Image();
				// Load the tmp image file that was uploaded
				$image->load($copy_temp_name);
				// Process the image for effects / reszing etc
				$image = $this->imageProcess($image, $copy_settings);
				// Have we changed it? save the changed ver over the current tmp file if we have
				$image->save($copy_temp_name);	
				// Build a new $_FILE object for WP to use when saving now
				$filedata = $_FILES['Filedata'];
				$filedata['tmp_name'] = $filedata['tmp_name'].$index;
				$filedata['name'] = 'copy-'.$index.'-'.$filedata['name'];
				// Save the attachment and get the ID
				$image_ids[] = $this->saveAttachment($_POST['user_id'], $_POST['post_id'], $filedata, 'copy', 'Copy of image '.$_FILES['Filedata']['name']);
				$index++;
			}
		}
		
		// Save the attachment and get the ID
		$main_image_id = $this->saveAttachment($_POST['user_id'], $post_id);
		
		// Now add all the image ids to an array, make sure the main original is first
		array_unshift($image_ids, $main_image_id);
		
		$data = array('id'=>implode(',',$image_ids));
			
		if($settings['image_preview_size']) {
			// If it's an image, return the url of the image size desired
			$data['image'] = wp_get_attachment_image_src($main_image_id, $settings['image_preview_size'], false);
		}

		// Finish up now
		$this->finish($data);

	}
	
	/**********************
	* Processes an image by resizing /applying effects etc.
	* @author David Rugendyke
	* @since 1.0.3
	***********************/
	private function imageProcess($image, $settings = NULL)
	{
		
		// Are we adding effects or manpulating the image?
		if((isset($settings['image_dimensions']) && ($settings['image_dimensions'] == 'crop' || $settings['image_dimensions'] == 'resize')) || (isset($settings['image_effects']) && $settings['image_effects'] == '1')) {
			
			// If the image needs to be resized, do this before any effects
			if((!empty($settings['image_dimensions_resize_type']) && $settings['image_dimensions'] == 'resize') || ($settings['image_dimensions'] == 'crop')) {
					
					// Resizing?
					if($settings['image_dimensions'] == 'resize') {
						switch ($settings['image_dimensions_resize_type']) {
							case 'width':
									$image->resizeToWidth($settings['image_dimensions_w']);
								break;
							case 'height':
									$image->resizeToHeight($settings['image_dimensions_h']);
								break;
							case 'both':
									$image->resize($settings['image_dimensions_w'], $settings['image_dimensions_h']);
								break;
						}
						
						// If it's an integer, we need to scale it by that amount
						if(is_numeric($settings['image_dimensions_resize_type'])) {
							$image->scale($settings['image_dimensions_resize_type']);	
						}
					}
					
					
					
					// Cropping?
					if($settings['image_dimensions'] == 'crop' && isset($settings['image_dimensions_crop_settings']) && !empty($settings['image_dimensions_crop_settings'])) {
						$crop_settings = $settings['image_dimensions_crop_settings'];
						if(is_array($crop_settings)) {
							$border_col = isset($crop_settings['colour']) ? str_replace('#','', $crop_settings['colour']) : NULL;
							$crop_pos = isset($crop_settings['pos']) ? $crop_settings['pos'] : '';
							$image->crop($settings['image_dimensions_h'], $settings['image_dimensions_w'], $border_col, 0, $crop_settings['type'], $crop_pos);
						}
					}
					
					// Check to see if we sharpen the resized image now
					if(!empty($settings['image_dimensions_resize_type_sharpen']) && is_numeric($settings['image_dimensions_resize_type_sharpen'])) {
						$image->image_fx_sharpen($settings['image_dimensions_resize_type_sharpen']);		
					}
		
			}
			
			// What effects are we adding?

			if(!empty($settings['image_effects_sharpen']) && is_numeric($settings['image_effects_sharpen'])) {
				$image->image_fx_sharpen($settings['image_effects_sharpen']);	
			}

			if(!empty($settings['image_effects_grayscale']) && $settings['image_effects_grayscale'] == '1') {
				$image->image_fx_grayscale();	
			}

			if(!empty($settings['image_effects_brightness']) && is_numeric($settings['image_effects_brightness'])) {
				$image->image_fx_brightness($settings['image_effects_brightness']);	
			}

			if(!empty($settings['image_effects_blur']) && is_numeric($settings['image_effects_blur'])) {
				for($i=0; $i < $settings['image_effects_blur']; $i++) {
					$image->image_fx_blur();	
				}
			}

			if(!empty($settings['image_effects_gblur']) && is_numeric($settings['image_effects_gblur'])) {
				for($i=0; $i < $settings['image_effects_gblur']; $i++) {
					$image->image_fx_gblur();	
				}
			}

			if(!empty($settings['image_effects_smooth']) && is_numeric($settings['image_effects_smooth'])) {
				$image->image_fx_smooth($settings['image_effects_smooth']);	
			}

			if(!empty($settings['image_effects_pixelate']) && is_numeric($settings['image_effects_pixelate'])) {
				echo $settings['image_effects_pixelate'];
				$image->image_fx_pixelate($settings['image_effects_pixelate']);	
			}
			
			
			// We have altered the image
			$image->changed = TRUE;
			
		}
		
		return $image;
		
	}
	
	
}

?>