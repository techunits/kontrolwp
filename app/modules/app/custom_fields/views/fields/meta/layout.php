<div class="kontrol-<?php echo $field->field_type?> kontrol-field" <?php echo isset($field_rules) ? $field_rules:''?> data-cond="<?php echo isset($field_cond) ? $field_cond:''?>">
	<div class="inner">
    	<div class="details">
            <div class="title" data-copy="<?php echo $field->field_key?>"><?php echo $field->name?> <?php echo (isset($field->validation) && in_array('required', $field->validation)) ? '<span class="req-ast">*</span>' : ''?> 
							   <?php if(isset($field->settings['tip']['enabled']) && $field->settings['tip']['enabled'] == TRUE) { ?>
                               		&nbsp;<div class="inline kontrol-tip tip-small" 
                                    	 title="<?php echo htmlentities($field->settings['tip']['title'], ENT_QUOTES, 'UTF-8')?>" 
                                         data-text="<?php echo htmlentities($field->settings['tip']['text'], ENT_QUOTES, 'UTF-8')?>"
                                         data-width="<?php echo htmlentities($field->settings['tip']['width'], ENT_QUOTES, 'UTF-8')?>"></div>
                               <?php } ?>
            </div>
            <div class="instructions"><?php echo $field->instructions?></div>
        </div>
        <div class="input">
        	<?php echo $layoutContent?>
        </div>
    </div>
</div>