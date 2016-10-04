<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">

	var fields_validator;

	window.addEvent('domready', function() {		
			
			var kontrol_upload_size_limit = <?=Kontrol_Tools::return_post_max('bytes')?>;
			var kontrol_app_path = '<?=URL_PLUGIN?>';
			// Validation.
  			fields_validator = new Form.Validator.Inline('am-save');
			
			// Add icons for each native WP entry  and manage the admin menu actions
			new kontrol_admin_menu_manage();
			new kontrol_file_upload({
				'file_size_max': kontrol_upload_size_limit,
				'app_path': kontrol_app_path
			});	
			
	});
	
</script>

<!-- Templates -->
<div id="admin-menu-templates">
    <div id="new-am-row">
        <? $this->renderElement('am-row', array('type'=>'main', 'current_user'=>$current_user, 'menu_key'=>'', 'menu'=>NULL, 'submenu'=>NULL, 'cap_list'=>$cap_list, 'role_list'=>$role_list)); ?>
    </div>
    <div id="new-am-row-seperator">
        <? $this->renderElement('am-row-seperator', array('type'=>'main', 'current_user'=>$current_user, 'menu_key'=>'', 'menu'=>$menu, 'submenu'=>$am['submenu'][$menu[2]], 'cap_list'=>$cap_list, 'role_list'=>$role_list)); ?>
    </div>
</div>


<form id="am-save" action="<?=$controller_url?>/save/&noheader=true" method="POST">

    <!-- Main Col -->
    <div id="admin-menu" class="main-col inline">
        <div class="section">
                <div class="inside">
                    <div class="title"><?=__('Admin Menu', 'kontrolwp')?>
                    	<div class="title-options">
                           <div class="admin-menu-link admin-menu-add-seperator inline"><?=__('Insert New Seperator','kontrolwp')?></div> &nbsp;&nbsp; <div class="admin-menu-link admin-menu-add-row inline"><?=__('Insert New Row','kontrolwp')?></div>
                        </div>
                    </div>
                    <div class="rows sortable">
                        <? if(isset($am) && count($am['menu']) > 0) { 
                            foreach($am['menu'] as $menu_key => $menu) {
								
								 $submenu = isset($am['submenu'][$menu[2]]) ? $am['submenu'][$menu[2]] : ''; 
								 
                                 if(strpos($menu[4], 'wp-menu-separator') === false)  { 
                                    $this->renderElement('am-row', array('type'=>'main', 'current_user'=>$current_user, 'menu_key'=>$menu_key, 'menu'=>$menu, 'submenu'=>$submenu, 'cap_list'=>$cap_list, 'role_list'=>$role_list)); 
                                 }else{
                                    $this->renderElement('am-row-seperator', array('type'=>'main', 'current_user'=>$current_user, 'menu_key'=>$menu_key, 'menu'=>$menu, 'submenu'=>$submenu, 'cap_list'=>$cap_list, 'role_list'=>$role_list)); 
                                 }
                            }
                        } ?>
                   </div>
                   
                </div>
            </div>
    </div>
    
                  
    <!-- Side Col -->
    <div class="side-col inline">
         <div class="section notification">
            <div class="inside">
                <div class="title"></div>
                <div class="menu-item alert"><div class="text link"></div></div>
            </div>
        </div>
        <div class="section">
            <div class="inside">
                <div class="title"><?=__('Save')?> <?=__('Admin Menu','kontrolwp')?></div>
                <div class="menu-item alert-icon">
                    <input id="group-save-button" type="submit" value="Save Menu" class="button-primary" />
                </div>
            </div>
        </div>
        <div id="admin-menu-tools" class="section">
            <div class="inside">
                <div class="title"><?=__('Menu Tools','kontrolwp')?></div>
                <div class="menu-item alert">
                    <div id="reset-menu-link" class="link" style="cursor: pointer"><?=__('Reset menu to defaults','kontrolwp')?></div>
                    <div class="desc"><?=__('Will reset the menu to the default WP menu','kontrolwp')?>.</div>
                </div>
            </div>
        </div>
        
        <?php $this->renderElement('am-section-tutorials'); ?>
    
    </div>
    
    <input type="hidden" id="reset-menu" name="reset-menu" value="false" />

</form>
 