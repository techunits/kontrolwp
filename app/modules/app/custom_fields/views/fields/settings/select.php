<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('Select Options','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
        	<? if(isset($data['select_options']) && count($data['select_options']) > 0) { 
		           for($i=0; $i < count($data['select_options']); $i++) {
			?>
            <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][select_options][]" value="<?=$data['select_options'][$i]?>" class="thirty required" />
                <div class="inline duplicate-parent  <?=($i > 0) ? 'delete' : ''?>"></div> 
            </div>
            <? }
             }else{ ?>
              <div class="field">
                <input type="text" name="field[<?=$fkey?>][settings][select_options][]" value="" class="thirty required" />
                <div class="inline duplicate-parent"></div> 
              </div>
               <? } ?>
        </div>
        <div class="desc"><?=__('Selectable options','kontrolwp')?> <?=__('are entered in the following format - <b>value : label</b>. You can leave out specifying a value by just entering text into the box. The text will become the value and label in this case','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Allow Null Value?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][select_null]" class="thirty">
              <option value="false" <?=isset($data['select_null']) && $data['select_null'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
              <option value="true" <?=isset($data['select_null']) && $data['select_null'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('You can allow the user to select a null value as the first option if you enable this','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Maximum Selected Values Allowed')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][select_max_values]" value="<?=isset($data['select_max_values']) ? $data['select_max_values']:'1'?>" class="thirty validate-integer required" />
        </div>
        <div class="desc"><?=__('If set to 1, a standard select list will appear. If set > 1 a multiple select box will appear and the user will be limited to the number of values they can select according to the number entered here','kontrolwp')?>.</div>
    </div>
    
</div>