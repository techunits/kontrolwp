 <!-- Image Dimensions -->
 <div class="image-effects-resize-settings">
     <div class="item">
            <div class="label"><?=__('Image Dimensions','kontrolwp')?><span class="req-ast">*</span></div> 
            <div class="field">
                <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions]" data-hide-show-parent=".image-effects-resize-settings" class="hide-show sixty">
                    <option value="false" data-hide-classes="image-resize-type,image-sizes,image-dimensions-group" <?=isset($data['image_dimensions']) && $data['image_dimensions'] == false ? 'selected="selected"':''?>><?=__('Natural','kontrolwp')?></option>
                    <option value="resize" data-show-classes="image-resize-type,image-resize-sharpen-type,image-sizes,image-dimensions-group" data-hide-classes="image-crop-settings"  <?=isset($data['image_dimensions']) && $data['image_dimensions'] == 'resize' ? 'selected="selected"':''?>><?=__('Resize','kontrolwp')?></option>
                    <option value="crop" data-show-classes="image-crop-settings,image-resize-sharpen-type,image-sizes,image-dimensions-group" data-hide-classes="image-resize-type"  <?=isset($data['image_dimensions']) && $data['image_dimensions'] == 'crop' ? 'selected="selected"':''?>><?=__('Crop','kontrolwp')?></option>
                    <? if(empty($copy)) { ?> 
                    	<option value="enforce" data-show-classes="image-sizes,image-dimensions-group"  data-hide-classes="image-resize-type,image-resize-sharpen-type,image-crop-settings" <?=isset($data['image_dimensions']) && $data['image_dimensions'] == 'enforce' ? 'selected="selected"':''?>><?=__('Enforce','kontrolwp')?></option> 
					<? } ?>
                </select>
                <div class="inline kontrol-tip" title="Image Dimensions"  data-width="550" data-text="<?=htmlentities(__('<b>Natural</b> - leaves the image dimensions as they are.<p><b>Resize Image</b> - will resize the image when uploaded.</p><p><b>Crop</b> - will cut / resize / zoom the image to fit.</p><p><b>Enforce</b> - requires the user to upload an image already at a specific width and height.</p>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
            </div>
            <div class="desc"><?=__('Select how you want the image demensions changed when the image is uploaded by the user','kontrolwp')?>.</div>
        </div>
            <div class="image-dimensions-group subgroup">
                
                <div class="item image-sizes">
                    <div class="label"><?=__('Image Width','kontrolwp')?> <span class="req-ast">*</span></div> 
                    <div class="field">
                        <input type="text" name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_w]" value="<?=isset($data['image_dimensions_w']) ? $data['image_dimensions_w']:"100"?>" class="required validate-integer" style="width: 50px" /> px
                    </div>
                    <div class="desc"><?=__('Select the width of the image. When enforcing, set to 0 to ignore this dimension','kontrolwp')?>.</div>
                </div>
                <div class="item image-sizes">
                    <div class="label"><?=__('Image Height','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <input type="text" name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_h]" value="<?=isset($data['image_dimensions_h']) ? $data['image_dimensions_h']:"100"?>" class="required validate-integer" style="width: 50px" /> px
                    </div>
                    <div class="desc"><?=__('Select the height of the image. When enforcing, set to 0 to ignore this dimension','kontrolwp')?>.</div>
                </div>
                <div class="item image-resize-type">
                    <div class="label"><?=__('Resize Type','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_resize_type]" class="hundred custom-select">
                            <option value="width" <?=isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'width' ? 'selected="selected"':''?>><?=__('To Width','kontrolwp')?></option>
                            <option value="height" <?=isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'height' ? 'selected="selected"':''?>><?=__('To Height','kontrolwp')?></option>
                            <option value="both" <?=isset($data['image_dimensions_resize_type']) && $data['image_dimensions_resize_type'] == 'both' ? 'selected="selected"':''?>><?=__('Width &amp; Height','kontrolwp')?></option>
                            <option value="100" class="custom-val" customValFormat="%s" customLabelFormat="Scale (%s%)" confirmText="Enter the amount in percentage to scale the image: eg. 40" <?=isset($data['image_dimensions_resize_type']) && is_numeric($data['image_dimensions_resize_type']) ? 'selected="selected"':''?>><?=__('Scale (keep aspect ratio)','kontrolwp')?></option>
                        </select>
                    </div>
                    <div class="desc"><?=__("Resizing using 'To Height' 'To Width' or 'Scale' will maintain the image aspect ratio.",'kontrolwp')?></div>
                </div>
                
                <div class="image-crop-settings">
                
                     <div class="item image-crop-type">
                        <div class="label"><?=__('Crop Type','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_crop_settings][type]"  data-hide-show-parent=".image-effects-resize-settings" class="hundred hide-show">
                                <option value="1" data-hide-classes="image-crop-colours" <?=isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '1' ? 'selected="selected"':''?>><?=__('Resize + Zoom Crop (recommended)','kontrolwp')?></option>
                                <option value="2" data-show-classes="image-crop-colours" <?=isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '2' ? 'selected="selected"':''?>><?=__('Cropped + Borders','kontrolwp')?></option>
                                <option value="3" data-hide-classes="image-crop-colours" <?=isset($data['image_dimensions_crop_settings']['type']) && $data['image_dimensions_crop_settings']['type'] == '3' ? 'selected="selected"':''?>><?=__('Cropped - Borders','kontrolwp')?></option>
                            </select>
                        </div>
                        <div class="desc"><?=__('Crop the image to fit your specified dimensions','kontrolwp')?>. <a href="<?=APP_URL?>/images/crop-examples.jpg" target="_blank"><?=__('Examples shown here','kontrolwp')?></a>.</div>
                    </div>
                    
                    <div class="item image-crop-pos">
                        <div class="label"><?=__('Crop Position','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_crop_settings][pos]" class="hundred">
                                <option value="" <?=isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == '' ? 'selected="selected"':''?>><?=__('Centre','kontrolwp')?></option>
                                <option value="tl" <?=isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'tl' ? 'selected="selected"':''?>><?=__('Top Left','kontrolwp')?></option>
                                <option value="tr" <?=isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'tr' ? 'selected="selected"':''?>><?=__('Top Right','kontrolwp')?></option>
                                <option value="bl" <?=isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'bl' ? 'selected="selected"':''?>><?=__('Bottom Left','kontrolwp')?></option>
                                <option value="blr" <?=isset($data['image_dimensions_crop_settings']['pos']) && $data['image_dimensions_crop_settings']['pos'] == 'br' ? 'selected="selected"':''?>><?=__('Bottom Right','kontrolwp')?></option>
                            </select>
                        </div>
                        <div class="desc"><?=__('Select the area of the image which should be cropped. Select centre if unsure','kontrolwp')?>.</div>
                    </div>
                    
                    <div class="item image-crop-colours">
                        <div class="label"><?=__('Crop Border Colour','kontrolwp')?><span class="req-ast">*</span></div> 
                        <div class="field">
                            <input type="text" name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_crop_settings][colour]" value="<?=isset($data['image_dimensions_crop_settings']['colour']) ? $data['image_dimensions_crop_settings']['colour']:"#FFFFFF"?>" class="required" style="width: 80px" />
                        </div>
                        <div class="desc"><?=__('Enter the hexidecimal colour for the crop borders eg. #FFFFFF = White','kontrolwp')?>.</div>
                    </div>
                
                </div>
                
                 <div class="item image-resize-sharpen-type">
                    <div class="label"><?=__('Sharpen Resized / Cropped Image','kontrolwp')?><span class="req-ast">*</span></div> 
                    <div class="field">
                        <? $sharpen_resized_val = isset($data['image_dimensions_resize_type_sharpen']) && is_numeric($data['image_dimensions_resize_type_sharpen']) ? $data['image_dimensions_resize_type_sharpen'] : '20'?>
                        <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_dimensions_resize_type_sharpen]" class="hundred custom-select">
                            <option value="false" <?=isset($data['image_dimensions_resize_type_sharpen']) && $data['image_dimensions_resize_type_sharpen'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                            <option value="<?=$sharpen_resized_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Resized Image Sharpened','kontrolwp')?> (%s)" confirmDefaultVal="<?=$sharpen_resized_val?>" confirmText="<?=__('Enter the amount to sharpen the image (lower = sharper): eg. 20 = medium sharpening','kontrolwp')?>" <?=isset($data['image_dimensions_resize_type_sharpen']) && is_numeric($data['image_dimensions_resize_type_sharpen']) ? 'selected="selected"':''?>><?=__('Resized Image Sharpened','kontrolwp')?> (<?=$sharpen_resized_val?>)</option>
                        </select>
                    </div>
                    <div class="desc"><?=__('Default is 20 which is a medium sharp effect. The lower the number, the sharper the resized/cropped image','kontrolwp')?>.</div>
                </div>
               
            </div>
            
     <!-- Image Effects -->
     
     <div class="item">
        <div class="label"><?=__('Image Effects','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects]"  data-hide-show-parent=".image-effects-resize-settings" class="hide-show sixty">
                <option value="false" data-hide-classes="image-effects-group" <?=isset($data['image_effects']) && $data['image_effects'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                <option value="true" data-show-classes="image-effects-group" <?=isset($data['image_effects']) && $data['image_effects'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>
        </div>
        <div class="desc"><?=__('Apply certain effects to the image if needed','kontrolwp')?>.</div>
      </div>
        <div class="image-effects-group subgroup">
            <div class="item">
                <div class="label"><?=__('Sharpen','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $sharpen_val = isset($data['image_effects_sharpen']) && is_numeric($data['image_effects_sharpen']) ? $data['image_effects_sharpen'] : '20'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_sharpen]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_sharpen']) && $data['image_effects_sharpen'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$sharpen_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Sharpened','kontrolwp')?> (%s)" confirmDefaultVal="<?=$sharpen_val?>" confirmText="<?=__('Enter the amount to sharpen the image (lower = sharper): eg. 20 = medium sharpening','kontrolwp')?>" <?=isset($data['image_effects_sharpen']) && is_numeric($data['image_effects_sharpen']) ? 'selected="selected"':''?>><?=__('Sharpened','kontrolwp')?> (<?=$sharpen_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Default is 20 which is a medium sharp effect. The lower the number, the sharper the image','kontrolwp')?>.</div>
            </div>
           <div class="item">
                <div class="label"><?=__('Grayscale','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_grayscale]" class="hundred">
                        <option value="false" <?=isset($data['image_effects_grayscale']) && $data['image_effects_grayscale'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="true" <?=isset($data['image_effects_grayscale']) && $data['image_effects_grayscale'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                    </select>
                </div>
                <div class="desc"><?=__('Converts the image into grayscale','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?=__('Brightness','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $brightness_val = isset($data['image_effects_brightness']) && is_numeric($data['image_effects_brightness']) ? $data['image_effects_brightness'] : '20'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_brightness]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_brightness']) && $data['image_effects_brightness'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$brightness_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Brightness','kontrolwp')?> (%s)" confirmDefaultVal="<?=$brightness_val?>" confirmText="<?=__('Enter the amount to brighten the image (lower = brighter): eg. 20','kontrolwp')?>" <?=isset($data['image_effects_brightness']) && is_numeric($data['image_effects_brightness']) ? 'selected="selected"':''?>><?=__('Brightness','kontrolwp')?> (<?=$brightness_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Changes the brightness of the image','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?=__('Blur','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $blur_val = isset($data['image_effects_blur']) && is_numeric($data['image_effects_blur']) ? $data['image_effects_blur'] : '5'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_blur]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_blur']) && $data['image_effects_blur'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$blur_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Blur Level','kontrolwp')?> (%s)" confirmDefaultVal="<?=$blur_val?>" confirmText="<?=__('Enter the amount to blur the image (higher = more): eg. 5','kontrolwp')?>" <?=isset($data['image_effects_blur']) && is_numeric($data['image_effects_blur']) ? 'selected="selected"':''?>><?=__('Blur Level','kontrolwp')?> (<?=$blur_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Blurs the image','kontrolwp')?>.</div>
            </div>
             <div class="item">
                <div class="label"><?=__('Gaussian Blur','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $gblur_val = isset($data['image_effects_gblur']) && is_numeric($data['image_effects_gblur']) ? $data['image_effects_gblur'] : '5'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_gblur]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_gblur']) && $data['image_effects_gblur'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$gblur_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Blur Level','kontrolwp')?> (%s)" confirmDefaultVal="<?=$gblur_val?>" confirmText="<?=__('Enter the amount to blur the image (higher = more): eg. 5','kontrolwp')?>" <?=isset($data['image_effects_gblur']) && is_numeric($data['image_effects_gblur']) ? 'selected="selected"':''?>><?=__('Blur Level','kontrolwp')?> (<?=$gblur_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Blurs the image using the Gaussian Blur effect','kontrolwp')?>.</div>
            </div>
            <div class="item">
                <div class="label"><?=__('Smooth','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $smooth_val = isset($data['image_effects_smooth']) && is_numeric($data['image_effects_smooth']) ? $data['image_effects_smooth'] : '5'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_smooth]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_smooth']) && $data['image_effects_smooth'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$smooth_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Smooth Level','kontrolwp')?> (%s)" confirmDefaultVal="<?=$smooth_val?>" confirmText="<?=__('Enter the amount to smooth the image (higher = more): eg. 5','kontrolwp')?>" <?=isset($data['image_effects_smooth']) && is_numeric($data['image_effects_smooth']) ? 'selected="selected"':''?>><?=__('Smooth Level','kontrolwp')?> (<?=$smooth_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Makes the image smoother','kontrolwp')?>.</div>
            </div>
             <div class="item">
                <div class="label"><?=__('Pixelate','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <? $pixel_val = isset($data['image_effects_pixelate']) && is_numeric($data['image_effects_pixelate']) ? $data['image_effects_pixelate'] : '3'?>
                    <select name="field[<?=$fkey?>][settings]<?=$copy?>[image_effects_pixelate]" class="hundred custom-select">
                        <option value="false" <?=isset($data['image_effects_pixelate']) && $data['image_effects_pixelate'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                        <option value="<?=$pixel_val?>" class="custom-val" customValFormat="%s" customLabelFormat="<?=__('Pixelate Level','kontrolwp')?> (%s)" confirmDefaultVal="<?=$pixel_val?>" confirmText="<?=__('Enter the amount to smooth the image (higher = more): eg. 5','kontrolwp')?>" <?=isset($data['image_effects_pixelate']) && is_numeric($data['image_effects_pixelate']) ? 'selected="selected"':''?>><?=__('Pixelate Level','kontrolwp')?> (<?=$pixel_val?>)</option>
                    </select>
                </div>
                <div class="desc"><?=__('Applies pixelation effect to the image. <b>Requires PHP 5.3</b>','kontrolwp')?></div>
            </div>
        </div>
</div>