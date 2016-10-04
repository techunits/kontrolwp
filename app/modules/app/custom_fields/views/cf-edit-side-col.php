
<div class="section">
	<div class="inside">
        <div class="title"><?=__('Save','kontrolwp')?></div>
        <div class="menu-item alert-icon">
            <input id="group-save-button" type="submit" value="<?=__('Edit CF Group','kontrolwp')?>" class="button-primary" />
        </div>
    </div>
</div>

<div class="section">
	<div class="inside">
        <div class="title"><?=__('Delete','kontrolwp')?></div>
        <div class="menu-item delete-icon">
            <input id="group-delete-button" type="button" value="<?=__('Delete CF Group','kontrolwp')?>" class="button-primary" />
            <input id="group-delete-flag" name="group-delete-flag" type="hidden" value="0" />
        </div>
    </div>
</div>


<div class="section">
	<div class="inside">
        <div class="title"><?=__('Field Group','kontrolwp')?></div>
        <div class="menu-item add">
                <div class="link"><a href="<?=$controller_url?>/add"><?=__('Add new field group','kontrolwp')?></a></div>
                <div class="desc"><?=__('Create a new field group','kontrolwp')?>.</div>
            </div>
    </div>
</div>