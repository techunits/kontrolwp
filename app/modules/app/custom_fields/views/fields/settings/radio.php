<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('Radio Buttons','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
        	<? if(isset($data['radio_options']) && count($data['radio_options']) > 0) { 
		           for($i=0; $i < count($data['radio_options']); $i++) {
			?>
            <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][radio_options][]" value="<?=$data['radio_options'][$i]?>" class="thirty required" />
                <div class="inline duplicate-parent  <?=($i > 0) ? 'delete' : ''?>"></div> 
            </div>
            <? }
             }else{ ?>
              <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][radio_options][]" value="" class="thirty required" />
                <div class="inline duplicate-parent"></div> 
              </div>
               <? } ?>
        </div>
        <div class="desc"><?=__('Radio buttons','kontrolwp')?> <?=__('are entered in the following format - <b>value : label</b>. You can leave out specifying a value by just entering text into the box. The text will become the value and label in this case','kontrolwp')?>.</div>
    </div>
    
     <div class="item">
        <div class="label"><?=__('Default Value','kontrolwp')?></div>
        <div class="field">
            <input type="text" id="name" name="field[<?=$fkey?>][settings][default_value]" value="<?=isset($data['default_value']) ? $data['default_value']:''?>" class="sixty" />
        </div>
        <div class="desc"><?=__('Enter the default value for this set of radio buttons. It will be selected by default','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Style','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][radio_style]" class="sixty">
              <option value="horizontal" <?=isset($data['radio_style']) && $data['radio_style'] == 'horizontal' ? 'selected="selected"':''?>><?=__('Horizontal','kontrolwp')?></option>
              <option value="vertical" <?=isset($data['radio_style']) && $data['radio_style'] == 'vertical' ? 'selected="selected"':''?>><?=__('Vertical','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('Select the style for this group of radio buttons','kontrolwp')?>.</div>
    </div>
    
</div>