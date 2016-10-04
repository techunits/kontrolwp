<div class="row am-seperator <?=isset($menu['deleted']) && $menu['deleted'] == 'true' ? 'deleted-row':''?>">
    <div class="inline tab drag-row"></div>
    &nbsp;<img class="delete-field" alt="<?=__('Delete')?>" title="<?=__('Delete')?>" src="<?=URL_IMAGE?>icon-delete.png" style="cursor: pointer"> &nbsp;&nbsp;
    
    <input type="hidden" name="am[0][]" value="" />
    <input type="hidden" name="am[1][]" value="read" />
    <input type="hidden" name="am[2][]" value="separator" />
    <input type="hidden" name="am[3][]" value="" />
    <input type="hidden" name="am[4][]" value="wp-menu-separator" />
    <input type="hidden" name="am[5][]" value="" />
    <input type="hidden" name="am[6][]" value="div" />
    
    <input type="hidden" class="row-visible" name="am[visible][]" value="true" />
    <input type="hidden" class="row-deleted" name="am[deleted][]" value="false" />
    <input type="hidden" class="row-type" name="am[type][]" value="<?=$type?>" />
    <input type="hidden" class="row-index" name="am[index][]" value="<?=(!empty($menu['key'])) ? $menu['key'] : $menu_key?>" />
    
</div>