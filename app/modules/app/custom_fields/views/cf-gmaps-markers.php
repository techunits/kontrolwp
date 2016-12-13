<?php $copy_key = isset($index) && !empty($index) && $index > 1 ? $index : '_ADD_RAND_KEY_'; ?>


<!-- Image Copies -->
<div class="image-copy">
    <div class="duplicate-parent duplicate-copy <?php echo isset($index) && ($index > 1) ? 'delete' : ''?>" data-add-unqiue-key="true" data-add-unqiue-key-format="_ADD_RAND_KEY_"></div> 
    <div class="item">
        <div class="label copy-key"><?php echo __('Marker Title','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][set_locations][<?php echo $copy_key?>][title]" value="<?php echo isset($data['title']) ? $data['title']:""?>"  class="required sixty" /> 
        </div>
        <div class="desc"><?php echo __('Enter the title of this marker location','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label copy-key"><?php echo __('Marker Description','kontrolwp')?><span class="req-ast"></span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][set_locations][<?php echo $copy_key?>][desc]" value="<?php echo isset($data['desc']) ? $data['desc']:""?>"  class="sixty" /> 
        </div>
        <div class="desc"><?php echo __('Enter a brief description of this marker location','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label copy-key"><?php echo __('Marker Coordinates','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][gmaps][set_locations][<?php echo $copy_key?>][marker]" value="<?php echo isset($data['marker']) ? $data['marker']:""?>"  class="required sixty" /> 
        </div>
        <div class="desc"><?php echo __('Enter the latitude and longitude of this marker location seperated by a comma','kontrolwp')?> eg. "-27.470933,153.023502".</div>
    </div>
    
</div>