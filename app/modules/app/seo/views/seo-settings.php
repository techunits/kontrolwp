<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">
	window.addEvent('domready', function() {
			// Various custom utilities for working with forms
			new kontrol_select_add();
			new kontrol_form_hide_show();
			new kontrol_select_custom();
			new kontrol_collapse_show();
			
			// Makes safe characters possible on fields with 'safe-chars' class
			restrict_safe_characters();
			
			 // Validation.
  			new Form.Validator.Inline('seo-settings');
			
	});
</script>


<form id="seo-settings" action="<?=$controller_url?>/settingsSave/&noheader=true" method="POST">

<!-- Main Col -->
<div class="main-col inline">

	<? if(count($seo_warnings) > 0) { ?>
		<div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Warnings','kontrolwp')?> <span class="tip"><?=__("few things we've noticed that when corrected will help your SEO benefit",'kontrolwp')?></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                    	<? if(in_array('permalink_structure', $seo_warnings)) { ?>
                         <div class="item">
                            <div class="label"><?=__('Permalink Structure','kontrolwp')?> <span class="req-ast">( <a href="options-permalink.php"><?=__('click to change','kontrolwp')?></a> )</a></span></div>
                            <div class="field warning"><?=__('It is highly recommended that your page and post URLs contain the postname and/or the category name. We recommend changing your permalink settings to custom and adding this','kontrolwp')?>: <b>/%category%/%postname%</b></div>
                         </div>
                        <? } ?>
                    </div>
                </div>
            </div>
     </div>
     
     <? } ?>
     
     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('SEO Enabled','kontrolwp')?> <span class="tip"></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="field"> 
                                <select name="settings[seo_enabled]" class="thirty">
                                  <option value="false" <?=isset($settings['seo_enabled']) && $settings['seo_enabled'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                  <option value="true" <?=isset($settings['seo_enabled']) && $settings['seo_enabled'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                </select> 
                            </div> 
                            <div class="desc"><?=__('Enable the Simple SEO module for easy to use, quick and smart SEO. Prefer not to fill out over 9000 options when configuring something? No problem, this is as easy to use as they come','kontrolwp')?>.</div>
                         </div>
                    </div>
                    
                </div>
            </div>
     </div>

        <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Settings','kontrolwp')?> <span class="tip"><?=__('general SEO settings / information','kontrolwp')?></span>
                    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Enable Keywords','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[keywords]" class="thirty">
                                          <option value="false" <?=isset($settings['keywords']) && $settings['keywords'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['keywords']) && $settings['keywords'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__("In ancient times, meta keywords were great for SEO. Now days, not so much, only Bing generally uses them and that's to help detect spam. We recommend against enabling Keywords for SEO",'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Disable snippet preview on posts?','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[snippet_preview]" class="thirty">
                                          <option value="false" <?=isset($settings['snippet_preview']) && $settings['snippet_preview'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['snippet_preview']) && $settings['snippet_preview'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('Disable this to prevent the snippet preview appearing when adding/editing a post','kontrolwp')?>.</div>
                        </div>
                        
                        <div class="item">
                            <div class="label"><?=__('Disable redirect option on SEO box?','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[redirect_option]" class="thirty">
                                          <option value="false" <?=isset($settings['redirect_option']) && $settings['redirect_option'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['redirect_option']) && $settings['redirect_option'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('Disable the ability for the user to add permanent 303 redirects on posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Disable Canonical URL option on SEO box?','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[canonical_option]" class="thirty">
                                          <option value="false" <?=isset($settings['canonical_option']) && $settings['canonical_option'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['canonical_option']) && $settings['canonical_option'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('Disable the ability for the user to add a canonical URL on a post. For more information on these','kontrolwp')?>, <a href="http://support.google.com/webmasters/bin/answer.py?hl=en&answer=139394" target="_blank"><?=__('read this article','kontrolwp')?></a>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?=__('Disable advanced option on SEO box?','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[advanced_option]" class="thirty">
                                          <option value="false" <?=isset($settings['advanced_option']) && $settings['advanced_option'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['advanced_option']) && $settings['advanced_option'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('The advanced option might need to be disabled for less advanced users','kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?=__('Disable template tag option on SEO box?','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[template_tag]" class="thirty">
                                          <option value="false" <?=isset($settings['template_tag']) && $settings['template_tag'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                          <option value="true" <?=isset($settings['template_tag']) && $settings['template_tag'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('Shows a list of the template tags that can be used in the SEO Title and Meta description','kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('SEO Box Position','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[position]" class="thirty">
                                          <option value="default" <?=isset($settings['position']) && $settings['position'] == 'default' ? 'selected="selected"':''?>><?=__('Default','kontrolwp')?></option>
                                          <option value="high" <?=isset($settings['position']) && $settings['position'] == 'high' ? 'selected="selected"':''?>><?=__('High','kontrolwp')?></option>
                                          <option value="low" <?=isset($settings['position']) && $settings['position'] == 'low' ? 'selected="selected"':''?>><?=__('Low','kontrolwp')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('This setting will determine where the SEO box will appear on the post add/edit screen','kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('SEO Box Style','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            			<select name="settings[style]" class="thirty">
                                          	<option value="meta" <?=isset($settings['style']) && $settings['style'] == 'meta' ? 'selected="selected"':''?>><?=__('In a Metabox','kontrolwp')?></option>
                                        	<option value="none" <?=isset($settings['style']) && $settings['style'] == 'none' ? 'selected="selected"':''?>><?=__('No Metabox','kontrolwp')?></option>
                                        </select>  
                             </div>
                            <div class="desc"><?=__('The style of the SEO Box','kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
     

     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Post Types','kontrolwp')?> <span class="tip"></span>
                    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Disable SEO for these Post Types','kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"> 
                            		<div class="kontrol-select-add">
                                    <div class="label"></div>
                                    <div class="field">
                                     <select nameToAdd="settings[post_types][]" class="thirty">
                                            <option value=""><b><?=__('Native','kontrolwp')?></b></option>
                                            <option value="">-------------------</option>
                                            <? foreach($pt_native as $pt_key => $pt) { ?>
                                                  <option value="<?=$pt_key?>"><?=$pt->label?></option>                             
                                            <? } ?>
                                            <option value="">-------------------</option>
                                            <option value=""><b><?=__('Custom','kontrolwp')?></b></option>
                                            <option value="">-------------------</option>
                                            <? if(!empty($pt_custom)) { ?>
                                                 <? foreach($pt_custom as $pt_key => $pt) { ?>
                                                 <option value="<?=$pt_key?>"><?=$pt->label?></option>    
                                                <? } ?>           
                                            <? }else{ ?>
                                            <option value=""><?=__('No custom post types found','kontrolwp')?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                     <div class="kontrol-select-results">
                                          <? if(isset($settings['post_types'])) {
                                                        foreach($settings['post_types'] as $pt_key) { 
															$pt = get_post_type_object($pt_key);
														?>
                                                            <div class="feature"><?=$pt->label?> <input type="hidden" name="settings[post_types][]" value="<?=$pt_key?>" /></div>
                                                <? }
                                                
                                          } ?>
                    
                                     </div>
                                </div>
                             </div>
                            <div class="desc"><?=__('Select which post types you do not want SEO enabled on','kontrolwp')?>.</div>
                        </div>
                     
                    </div>
                </div>
            </div>
     </div>
</div>


 <!-- Side Col -->
<div class="side-col inline">
    <?php $this->renderElement('seo-side-col', array('controller_url' => $controller_url)); ?>
</div>

</form>