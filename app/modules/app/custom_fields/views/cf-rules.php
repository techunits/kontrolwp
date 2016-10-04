<div class="fields <?=$class?>">
	<div>
	  <? if(!isset($rule_set)) {
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
             <select name="<?=$type?>[rules][cond]" class="rule-set-operator hundred">
                   <option value="AND" <?=(isset($data->cond) && $data->cond == 'AND') ? 'selected="selected"':'' ?>><?=__('Match ALL of the above rules','kontrolwp')?></option>
                   <option value="OR" <?=(isset($data->cond) && $data->cond == 'OR') ? 'selected="selected"':'' ?>><?=__('Match ANY of the above rules','kontrolwp')?></option>
             </select>
        </div>
  </div>
</div>