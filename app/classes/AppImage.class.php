<?

/**********************
* Manipulates images and applies certains effects - Based on Simple Image by Simon Jarvis
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @plugin Kontrol
  @plugin_url http://www.kontrolwp.com
* @since 1.0.0
***********************/
 
 
class Kontrol_Image {
 
   var $image;
   var $image_type;
   var $changed = FALSE;
 
   function load($filename) 
   {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=85, $permissions=null) 
   {
	   
	   $image_type =  $this->image_type;
	   
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   
   function output($image_type=IMAGETYPE_JPEG) 
   {
	  
	  $image_type =  $this->image_type;
	   
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   
   // Kontrol Resizing
   function getWidth() 
   {
      return imagesx($this->image);
   }
   
   function getHeight() 
   {
       return imagesy($this->image);
   }
   
   function resizeToHeight($height) 
   {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) 
   {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) 
   {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) 
   {
      $new_image = imagecreatetruecolor($width, $height);
	  imagealphablending($new_image, true);
	  imagesavealpha($new_image, true);
	  $trans_colour = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagefill($new_image, 0, 0, $trans_colour);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }    
   
   // This cropping code is based on the good stuff by TimThumb
   function crop($new_height, $new_width, $canvas_colour = 'FFFFFF', $canvas_trans = 0, $zoom_crop = 1, $align = NULL) 
   {
  	
		$canvas_colour = str_replace('#','',$canvas_colour);
			
		if(! defined('PNG_IS_TRANSPARENT') ) 	define ('PNG_IS_TRANSPARENT', FALSE);	// Define if a png image should have a transparent background color. Use False value if you want to display a custom coloured canvas_colour 
		
		// set default width and height if neither are set already
		if (empty($new_width) && empty($new_height)) {
			$new_width = 100;
			$new_height = 100;
		}
	
		// Get original width and height
		$width = $this->getWidth();
		$height = $this->getHeight();
		$origin_x = 0;
		$origin_y = 0;
	
		// generate new w/h if not provided
		if ($new_width && !$new_height) {
			$new_height = floor ($height * ($new_width / $width));
		} else if ($new_height && !$new_width) {
			$new_width = floor ($width * ($new_height / $height));
		}
		
		// scale down and add borders
		if ($zoom_crop == 3) {
			
			$final_height = $height * ($new_width / $width);
	
			if ($final_height > $new_height) {
				$new_width = $width * ($new_height / $height);
			} else {
				$new_height = $final_height;
			}
		}
		
		// create a new true color image
		$canvas = imagecreatetruecolor ($new_width, $new_height);
		imagealphablending ($canvas, false);
	
		if (strlen($canvas_colour) == 3) { //if is 3-char notation, edit string into 6-char notation
			$canvas_colour =  str_repeat(substr($canvas_colour, 0, 1), 2) . str_repeat(substr($canvas_colour, 1, 1), 2) . str_repeat(substr($canvas_colour, 2, 1), 2); 
		} else if (strlen($canvas_colour) != 6) {
			
		}
		
		$canvas_colour_R = hexdec (substr ($canvas_colour, 0, 2));
		$canvas_colour_G = hexdec (substr ($canvas_colour, 2, 2));
		$canvas_colour_B = hexdec (substr ($canvas_colour, 4, 2));
	
		// Create a new transparent color for image
		// If is a png and PNG_IS_TRANSPARENT is false then remove the alpha transparency 
		// (and if is set a canvas color show it in the background)
		if($this->image_type == IMAGETYPE_PNG && !PNG_IS_TRANSPARENT && $canvas_trans){ 
			$color = imagecolorallocatealpha ($canvas, $canvas_colour_R, $canvas_colour_G, $canvas_colour_B, 127);		
		}else{
			$color = imagecolorallocatealpha ($canvas, $canvas_colour_R, $canvas_colour_G, $canvas_colour_B, 0);
		}
	
	
		// Completely fill the background of the new image with allocated color.
		imagefill ($canvas, 0, 0, $color);
	
		// scale down and add borders
		if ($zoom_crop == 2) {
	
			$final_height = $height * ($new_width / $width);
	
			if ($final_height > $new_height) {
	
				$origin_x = $new_width / 2;
				$new_width = $width * ($new_height / $height);
				$origin_x = round ($origin_x - ($new_width / 2));
	
			} else {
	
				$origin_y = $new_height / 2;
				$new_height = $final_height;
				$origin_y = round ($origin_y - ($new_height / 2));
	
			}
	
		}
	
		// Restore transparency blending
		imagesavealpha ($canvas, true);
	
		if ($zoom_crop > 0) {
	
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;
	
			$cmp_x = $width / $new_width;
			$cmp_y = $height / $new_height;
	
			// calculate x or y coordinate and width or height of source
			if ($cmp_x > $cmp_y) {
	
				$src_w = round ($width / $cmp_x * $cmp_y);
				$src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);
	
			} else if ($cmp_y > $cmp_x) {
	
				$src_h = round ($height / $cmp_y * $cmp_x);
				$src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);
	
			}
	
			// positional cropping!
			if ($align) {
				if (strpos ($align, 't') !== false) {
					$src_y = 0;
				}
				if (strpos ($align, 'b') !== false) {
					$src_y = $height - $src_h;
				}
				if (strpos ($align, 'l') !== false) {
					$src_x = 0;
				}
				if (strpos ($align, 'r') !== false) {
					$src_x = $width - $src_w;
				}
			}
	
			imagecopyresampled ($canvas, $this->image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
	
		} else {
	
			// copy and resize part of an image with resampling
			imagecopyresampled ($canvas, $this->image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
		}
		
		$this->image = $canvas;
	
   }      
   
   // Kontrol Effects
  function image_fx_sharpen($amount = 20) 
  {
	  $matrix = array(
		  array(-1, -1, -1),
		  array(-1, $amount, -1),
		  array(-1, -1, -1),
	  );
  
	  $divisor = array_sum(array_map('array_sum', $matrix));
	  $offset = 0; 
	  imageconvolution($this->image, $matrix, $divisor, $offset);
  }
  
  function image_fx_grayscale() 
  {
	 imagefilter($this->image, IMG_FILTER_GRAYSCALE);
  }
  
  function image_fx_brightness($level) 
  {
	 imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $level);
  }
  
  function image_fx_blur() 
  {
	 imagefilter($this->image, IMG_FILTER_SELECTIVE_BLUR);
  }
  
  function image_fx_gblur() 
  {
	 imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
  }
  
  function image_fx_smooth($level) 
  {
	 imagefilter($this->image, IMG_FILTER_SMOOTH, $level);
  }
  
   function image_fx_pixelate($level) 
  {
	 imagefilter($this->image, IMG_FILTER_PIXELATE, $level, FALSE);
  }
  
  
 
 
}
?>