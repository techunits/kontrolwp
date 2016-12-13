 <!-- Image Dimensions -->
 <div class="image-effects-resize-settings">
     <div class="item">
            <div class="label"><?php echo __('Image Dimensions','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions]" data-hide-show-parent=".image-effects-resize-settings" class="hide-show sixty">
                    <option value="false" data-hide-classes="image-resize-type,image-sizes,image-dimensions-group" <?php echo isset($data['image_dimensions']) && $data['image_dimensions'] == false ? 'selected="selected"':''?>><?php echo __('Natural','kontrolwp')?></option>
                    <option value="resize" data-show-classes="image-resize-type,image-resize-sharpen-type,image-sizes,image-dimensions-group" data-hide-classes="image-crop-settings"  <?php echo isset($data['image_dimensions']) && $data['image_dimensions'] == 'resize' ? 'selected="selected"':''?>><?php echo __('Resize','kontrolwp')?></option>
                    <option value="crop" data-show-classes="image-crop-settings,image-resize-sharpen-type,image-sizes,image-dimensions-group" data-hide-classes="image-resize-type"  <?php echo isset($data['image_dimensions']) && $data['image_dimensions'] == 'crop' ? 'selected="selected"':''?>><?php echo __('Crop','kontrolwp')?></option>
                    <?php if(empty($copy)) { ?> 
                    	<option value="enforce" data-show-classes="image-sizes,image-dimensions-group"  data-hide-classes="image-resize-type,image-resize-sharpen-type,image-crop-settings" <?php echo isset($data['image_dimensions']) && $data['image_dimensions'] == 'enforce' ? 'selected="selected"':''?>><?php echo __('Enforce','kontrolwp')?></option> 
					<?php } ?>
                </select>
                <div class="inline kontrol-tip" title="Image Dimensions"  data-width="550" data-text="<?php echo htmlentities(__('<b>Natural</b> - leaves the image dimensions as they are.<p><b>Resize Image</b> - will resize the image when uploaded.</p><p><b>Crop</b> - will cut / resize / zoom the image to fit.</p><p><b>Enforce</b> - requires the user to upload an image already at a specific width and height.</p>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
            </div>
            <div class="desc"><?php echo __('Select how you want the image demensions changed when the image is uploaded by the user','kontrolwp')?>.</div>
        </div>
            <div class="image-dimensions-group subgroup">
                
                <div class="item image-sizes">
                    <div class="label"><?php echo __('Image Width','kontrolwp')?> <span class="req-ast">*</span></div> 
                    <div class="field">
                        <input type="text" name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_w]" value="<?php echo isset($data['image_dimensions_w']) ? $data['image_dimensions_w']:"100"?>" class="required validate-integer" style="width: 50px" /> px
                    </div>
                    <div class="desc"><?php echo __('Select the width of the image. When enforcing, set to 0 to ignore this dimension','kontrolwp')?>.</div>
                </div>
                <div class="item image-sizes">
                    <div class="label"><?php echo __('Image Height','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <input type="text" name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_h]" value="<?php echo isset($data['image_dimensions_h']) ? $data['image_dimensions_h']:"100"?>" class="required validate-integer" style="width: 50px" /> px
                    </div>
                    <div class="desc"><?php echo __('Select the height of the image. When enforcing, set to 0 to ignore this dimension','kontrolwp')?>.</div>
                </div>
                <div class="item image-resize-type">
                    <div class="label"><?php echo __('Resize Type','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_resize_type]" class="hundred custom-select">
                            <option value="width" <?php echo isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'width' ? 'selected="selected"':''?>><?php echo __('To Width','kontrolwp')?></option>
                            <option value="height" <?php echo isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'height' ? 'selected="selected"':''?>><?php echo __('To Height','kontrolwp')?></option>
                            <option value="both" <?php echo isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'both' ? 'selected="selected"':''?>><?php echo __('Width &amp; Height','kontrolwp')?></option>
                            <option value="100" class="custom-val" customValFormat="%s" customLabelFormat="Scale (%s%)" confirmText="Enter the amount in percentage to scale the image: eg. 40" <?php echo isset($data['image_dimensions_resize_type']) && is_numeric($data['image_dimensions_resize_type']) ? 'selected="selected"':''?>><?php echo __('Scale (keep aspect ratio)','kontrolwp')?></option>
                        </select>
                    </div>
                    <div class="desc"><?php echo __("Resizing using 'To Height' 'To Width' or 'Scale' will maintain the image aspect ratio.",'kontrolwp')?></div>
                </div>
                
                <div class="image-crop-settings">
                
                     <div class="item image-crop-type">
                        <div class="label"><?php echo __('Crop Type','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_crop_settings][type]"  data-hide-show-parent=".image-effects-resize-settings" class="hundred hide-show">
                                <option value="1" data-hide-classes="image-crop-colours" <?php echo isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '1' ? 'selected="selected"':''?>><?php echo __('Resize + Zoom Crop (recommended)','kontrolwp')?></option>
                                <option value="2" data-show-classes="image-crop-colours" <?php echo isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '2' ? 'selected="selected"':''?>><?php echo __('Cropped + Borders','kontrolwp')?></option>
                                <option value="3" data-hide-classes="image-crop-colours" <?php echo isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '3' ? 'selected="selected"':''?>><?php echo __('Cropped - Borders','kontrolwp')?></option>
                            </select>
                        </div>
                        <div class="desc"><?php echo __('Crop the image to fit your specified dimensions','kontrolwp')?>. <a href="<?php echo APP_URL?>/images/crop-examples.jpg" target="_blank"><?php echo __('Examples shown here','kontrolwp')?></a>.</div>
                    </div>
                    
                    <div class="item image-crop-pos">
                        <div class="label"><?php echo __('Crop Position','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_crop_settings][pos]" class="hundred">
                                <option value="" <?php echo isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == '' ? 'selected="selected"':''?>><?php echo __('Centre','kontrolwp')?></option>
                                <option value="tl" <?php echo isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'tl' ? 'selected="selected"':''?>><?php echo __('Top Left','kontrolwp')?></option>
                                <option value="tr" <?php echo isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'tr' ? 'selected="selected"':''?>><?php echo __('Top Right','kontrolwp')?></option>
                                <option value="bl" <?php echo isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'bl' ? 'selected="selected"':''?>><?php echo __('Bottom Left','kontrolwp')?></option>
                                <option value="blr" <?php echo isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'br' ? 'selected="selected"':''?>><?php echo __('Bottom Right','kontrolwp')?></option>
                            </select>
                        </div>
                        <div class="desc"><?php echo __('Select the area of the image which should be cropped. Select centre if unsure','kontrolwp')?>.</div>
                    </div>
                    
                    <div class="item image-crop-colours">
                        <div class="label"><?php echo __('Crop Border Colour','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <input type="text" name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_crop_settings][colour]" value="<?php echo isset($data['image_dimensions_crop_settings']['colour']) ? $data['image_dimensions_crop_settings']['colour']:"#FFFFFF"?>" class="required" style="width: 80px" />
                        </div>
                        <div class="desc"><?php echo __('Enter the hexidecimal colour for the crop borders eg. #FFFFFF = White','kontrolwp')?>.</div>
                    </div>
                
                </div>
                
                 <div class="item image-resize-sharpen-type">
                    <div class="label"><?php echo __('Sharpen Resized / Cropped Image','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <?php $sharpen_resized_val = isset($data['image_dimensions_resize_type_sharpen']) && is_numeric($data['image_dimensions_resize_type_sharpen']) ? $data['image_dimensions_resize_type_sharpen'] : '20'?>
                        <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_dimensions_resize_type_sharpen]" class="hundred custom-select">
                            <option value="false" <?php echo isset($data['image_dimensions_resize_type_sharpen']) && $data['image_dimensions_resize_type_sharpen'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                            <option value="<?php echo $sharpen_resized_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Resized Image Sharpened','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $sharpen_resized_val?>" confirmText="<?php echo __('Enter the amount to sharpen the image (lower = sharper): eg. 20 = medium sharpening','kontrolwp')?>" <?php echo isset($data['image_dimensions_resize_type_sharpen']) && is_numeric($data['image_dimensions_resize_type_sharpen']) ? 'selected="selected"':''?>><?php echo __('Resized Image Sharpened','kontrolwp')?> (<?php echo $sharpen_resized_val?>)</option>
                        </select>
                    </div>
                    <div class="desc"><?php echo __('Default is 20 which is a medium sharp effect. The lower the number, the sharper the resized/cropped image','kontrolwp')?>.</div>
                </div>
               
            </div>
            
     <!-- Image Effects -->
     
     <div class="item">
        <div class="label"><?php echo __('Image Effects','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects]"  data-hide-show-parent=".image-effects-resize-settings" class="hide-show sixty">
                <option value="false" data-hide-classes="image-effects-group" <?php echo isset($data['image_effects']) && $data['image_effects'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                <option value="true" data-show-classes="image-effects-group" <?php echo isset($data['image_effects']) && $data['image_effects'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>
        </div>
        <div class="desc"><?php echo __('Apply certain effects to the image if needed','kontrolwp')?>.</div>
      </div>
        <div class="image-effects-group subgroup">
            <div class="item">
                <div class="label"><?php echo __('Sharpen','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $sharpen_val = isset($data['image_effects_sharpen']) && is_numeric($data['image_effects_sharpen']) ? $data['image_effects_sharpen'] : '20'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_sharpen]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_sharpen']) && $data['image_effects_sharpen'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $sharpen_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Sharpened','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $sharpen_val?>" confirmText="<?php echo __('Enter the amount to sharpen the image (lower = sharper): eg. 20 = medium sharpening','kontrolwp')?>" <?php echo isset($data['image_effects_sharpen']) && is_numeric($data['image_effects_sharpen']) ? 'selected="selected"':''?>><?php echo __('Sharpened','kontrolwp')?> (<?php echo $sharpen_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Default is 20 which is a medium sharp effect. The lower the number, the sharper the image','kontrolwp')?>.</div>
            </div>
           <div class="item">
                <div class="label"><?php echo __('Grayscale','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_grayscale]" class="hundred">
                        <option value="false" <?php echo isset($data['image_effects_grayscale']) && $data['image_effects_grayscale'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="true" <?php echo isset($data['image_effects_grayscale']) && $data['image_effects_grayscale'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Converts the image into grayscale','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?php echo __('Brightness','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $brightness_val = isset($data['image_effects_brightness']) && is_numeric($data['image_effects_brightness']) ? $data['image_effects_brightness'] : '20'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_brightness]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_brightness']) && $data['image_effects_brightness'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $brightness_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Brightness','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $brightness_val?>" confirmText="<?php echo __('Enter the amount to brighten the image (lower = brighter): eg. 20','kontrolwp')?>" <?php echo isset($data['image_effects_brightness']) && is_numeric($data['image_effects_brightness']) ? 'selected="selected"':''?>><?php echo __('Brightness','kontrolwp')?> (<?php echo $brightness_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Changes the brightness of the image','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?php echo __('Blur','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $blur_val = isset($data['image_effects_blur']) && is_numeric($data['image_effects_blur']) ? $data['image_effects_blur'] : '5'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_blur]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_blur']) && $data['image_effects_blur'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $blur_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Blur Level','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $blur_val?>" confirmText="<?php echo __('Enter the amount to blur the image (higher = more): eg. 5','kontrolwp')?>" <?php echo isset($data['image_effects_blur']) && is_numeric($data['image_effects_blur']) ? 'selected="selected"':''?>><?php echo __('Blur Level','kontrolwp')?> (<?php echo $blur_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Blurs the image','kontrolwp')?>.</div>
            </div>
             <div class="item">
                <div class="label"><?php echo __('Gaussian Blur','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $gblur_val = isset($data['image_effects_gblur']) && is_numeric($data['image_effects_gblur']) ? $data['image_effects_gblur'] : '5'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_gblur]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_gblur']) && $data['image_effects_gblur'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $gblur_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Blur Level','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $gblur_val?>" confirmText="<?php echo __('Enter the amount to blur the image (higher = more): eg. 5','kontrolwp')?>" <?php echo isset($data['image_effects_gblur']) && is_numeric($data['image_effects_gblur']) ? 'selected="selected"':''?>><?php echo __('Blur Level','kontrolwp')?> (<?php echo $gblur_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Blurs the image using the Gaussian Blur effect','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?php echo __('Smooth','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $smooth_val = isset($data['image_effects_smooth']) && is_numeric($data['image_effects_smooth']) ? $data['image_effects_smooth'] : '5'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_smooth]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_smooth']) && $data['image_effects_smooth'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $smooth_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Smooth Level','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $smooth_val?>" confirmText="<?php echo __('Enter the amount to smooth the image (higher = more): eg. 5','kontrolwp')?>" <?php echo isset($data['image_effects_smooth']) && is_numeric($data['image_effects_smooth']) ? 'selected="selected"':''?>><?php echo __('Smooth Level','kontrolwp')?> (<?php echo $smooth_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Makes the image smoother','kontrolwp')?>.</div>
            </div>
             <div class="item">
                <div class="label"><?php echo __('Pixelate','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <?php $pixel_val = isset($data['image_effects_pixelate']) && is_numeric($data['image_effects_pixelate']) ? $data['image_effects_pixelate'] : '3'?>
                    <select name="field[<?php echo $fkey?>][settings]<?php echo $copy?>[image_effects_pixelate]" class="hundred custom-select">
                        <option value="false" <?php echo isset($data['image_effects_pixelate']) && $data['image_effects_pixelate'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                        <option value="<?php echo $pixel_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?php echo __('Pixelate Level','kontrolwp')?> (%s)" confirmDefaultVal="<?php echo $pixel_val?>" confirmText="<?php echo __('Enter the amount to smooth the image (higher = more): eg. 5','kontrolwp')?>" <?php echo isset($data['image_effects_pixelate']) && is_numeric($data['image_effects_pixelate']) ? 'selected="selected"':''?>><?php echo __('Pixelate Level','kontrolwp')?> (<?php echo $pixel_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?php echo __('Applies pixelation effect to the image. <b>Requires PHP 5.3</b>','kontrolwp')?></div>
            </div>
        </div>
</div>