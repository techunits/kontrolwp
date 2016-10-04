 <div class="section group-fields">
    <div class="inside">
        <div class="title icon-menu-title">
            <?=$title?> <span class="tip"></span>                 
            <div class="div"></div>
         </div>

         <!-- Fields -->
         <div class="field-rows rows sortable">
            <?
				
                if(isset($field_list) && count($field_list) > 0) {
                    foreach($field_list as $field) { ?>
                        <div class="row <?=empty($field->active) ? 'field-hidden':''?>"><?=$this->renderElement('cf-field', array('field_types'=>$field_types, 'rules'=>$rules, 'data'=>$field, 'field_type'=>$field_type));?></div> 
                    <? }
                }
            ?>
         </div>

        <div class="section-content" style="padding: 16px; border-top: 1px solid #eaeaea;">
        	<div class="item" style="text-align: right"><input type="button" class="new-cf" value="<?=__('Add New Field','kontrolwp')?>" style="" />&nbsp;&nbsp;&nbsp;</div>
        </div>
    </div>
</div>