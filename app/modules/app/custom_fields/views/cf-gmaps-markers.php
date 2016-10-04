<? $copy_key = isset($index) && !empty($index) && $index > 1 ? $index : '_ADD_RAND_KEY_'; ?>


<!-- Image Copies -->
<div class="image-copy">
    <div class="duplicate-parent duplicate-copy <?=isset($index) && ($index > 1) ? 'delete' : ''?>" data-add-unqiue-key="true" data-add-unqiue-key-format="_ADD_RAND_KEY_"></div> 
    <div class="item">
        <div class="label copy-key"><?=__('Marker Title','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][gmaps][set_locations][<?=$copy_key?>][title]" value="<?=isset($data['title']) ? $data['title']:""?>"  class="required sixty" /> 
        </div>
        <div class="desc"><?=__('Enter the title of this marker location','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label copy-key"><?=__('Marker Description','kontrolwp')?><span class="req-ast"></span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][gmaps][set_locations][<?=$copy_key?>][desc]" value="<?=isset($data['desc']) ? $data['desc']:""?>"  class="sixty" /> 
        </div>
        <div class="desc"><?=__('Enter a brief description of this marker location','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label copy-key"><?=__('Marker Coordinates','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][gmaps][set_locations][<?=$copy_key?>][marker]" value="<?=isset($data['marker']) ? $data['marker']:""?>"  class="required sixty" /> 
        </div>
        <div class="desc"><?=__('Enter the latitude and longitude of this marker location seperated by a comma','kontrolwp')?> eg. "-27.470933,153.023502".</div>
    </div>
    
</div>