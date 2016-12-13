<?php $copy_key = isset($index) && !empty($index) && $index > 1 ? $index : '_ADD_RAND_KEY_'; ?>

<!-- Image Copies -->
<div class="image-copy">
    <div class="duplicate-parent duplicate-copy <?php echo isset($index) && ($index > 1) ? 'delete' : ''?>" data-add-unqiue-key="true" data-add-unqiue-key-format="_ADD_RAND_KEY_"></div> 
    <div class="item">
        <div class="label copy-key"><?php echo __('Image Copy Key','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][image_copy][<?php echo $copy_key?>][image_key]" value="<?php echo isset($data['image_key']) ? $data['image_key']:""?>" placeholder="enter-image-copy-key" class="required safe-chars thirty" /> 
            <div class="inline kontrol-tip" title="Image Copy Key" data-text="<?php echo htmlentities(__('Enter in a unique key here for your image copy. Eg. <strong>thumbnail</strong>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        
        <div class="desc"><?php echo __('Enter a key for this image copy','kontrolwp')?>.</div>
    </div>
   
    <div class="image-copy-settings">
        <?php  $this->renderElement('cf-image-effects', array('fkey'=>$fkey, 'data'=>$data, 'type'=>$type, 'copy'=>'[image_copy]['.$copy_key.']'));?>
    </div>
    
</div>