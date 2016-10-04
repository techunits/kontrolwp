<div class="kontrol-<?=$field->field_type?> kontrol-field" <?=isset($field_rules) ? $field_rules:''?> data-cond="<?=isset($field_cond) ? $field_cond:''?>">
	<div class="inner">
    	<div class="details">
            <div class="title" data-copy="<?=$field->field_key?>"><?=$field->name?> <?=(isset($field->validation) && in_array('required', $field->validation)) ? '<span class="req-ast">*</span>' : ''?> 
							   <? if(isset($field->settings['tip']['enabled']) && $field->settings['tip']['enabled'] == TRUE) { ?>
                               		&nbsp;<div class="inline kontrol-tip tip-small" 
                                    	 title="<?=htmlentities($field->settings['tip']['title'], ENT_QUOTES, 'UTF-8')?>" 
                                         data-text="<?=htmlentities($field->settings['tip']['text'], ENT_QUOTES, 'UTF-8')?>"
                                         data-width="<?=htmlentities($field->settings['tip']['width'], ENT_QUOTES, 'UTF-8')?>"></div>
                               <? } ?>
            </div>
            <div class="instructions"><?=$field->instructions?></div>
        </div>
        <div class="input">
        	<?=$layoutContent?>
        </div>
    </div>
</div>