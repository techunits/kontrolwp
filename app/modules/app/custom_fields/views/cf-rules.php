<div class="fields <?php echo $class?>">
	<div>
	  <?php if(!isset($rule_set)) {
            $this->renderElement('cf-rules-option', array('data'=>NULL, 'rules'=>$rules, 'type'=>$type, 'index'=>0));   
      }else{ 
	  		$count = 0;
            foreach($rule_set as $data) {
                $this->renderElement('cf-rules-option', array('data'=>$data, 'rules'=>$rules, 'type'=>$type, 'index'=>$count));   
				$count++;
            }
      } ?>
  </div>
  <div class="field">
  		<div class="rule-match">
             <select name="<?php echo $type?>[rules][cond]" class="rule-set-operator hundred">
                   <option value="AND" <?php echo (isset($data->cond) && $data->cond == 'AND') ? 'selected="selected"':'' ?>><?php echo __('Match ALL of the above rules','kontrolwp')?></option>
                   <option value="OR" <?php echo (isset($data->cond) && $data->cond == 'OR') ? 'selected="selected"':'' ?>><?php echo __('Match ANY of the above rules','kontrolwp')?></option>
             </select>
        </div>
  </div>
</div>