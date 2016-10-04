<? 
	 // Redirect pages/posts
	$pt_filter = get_post_types(array('public'=>TRUE)); 
	 
	 // Filter by post type if needed
	 foreach($pt_filter as $pt) {
		// See what type of post type this is - page or post
		if(is_post_type_hierarchical($pt)) {
			// Heirarchy
			$page_list[$pt] = Kontrol_Tools::page_list_array_indented($pt);	
		}else{ 
			// Posts
			$page_list[$pt] = get_posts(array('post_type' => $pt, 'numberposts'=> -1,  'post_status' => 'publish'));
		}
	 }
	

?>


<div class="kontrol-tab-box">
	<div class="kontrol-tabs">
    	<div class="kontrol-tab inline in" data-tab-load="tab-1"><a><?=__('General','kontrolwp')?></a></div>
        <? if(isset($settings['redirect_option']) && !$settings['redirect_option']) { ?><div class="kontrol-tab inline" data-tab-load="tab-2"><a><?=__('Redirect','kontrolwp')?></a></div><? } ?>
        <? if(isset($settings['canonical_option']) && !$settings['canonical_option']) { ?><div class="kontrol-tab inline" data-tab-load="tab-3"><a><?=__('Canonical URL','kontrolwp')?></a></div><? } ?>
        <? if(isset($settings['template_tag']) && !$settings['template_tag']) { ?><div class="kontrol-tab inline" data-tab-load="tab-5"><a><?=__('Template Tags','kontrolwp')?></a></div><? } ?>
        <? if(isset($settings['advanced_option']) && !$settings['advanced_option']) { ?><div class="kontrol-tab inline" data-tab-load="tab-4"><a><?=__('Advanced','kontrolwp')?></a></div><? } ?>
       
    </div>
	<div class="kontrol-tab-content">
      <div class="section">
          <div class="inside">
            <div id="tab-1" class="kontrol-tab-slide">
            	<? if(isset($settings['template_tag']) && !$settings['snippet_preview']) { ?>
                    <div class="field">
                        <div class="seo-preview">
                            <div class="seo-title"><?=!empty($seo_data['title']) ? $seo_data['title'] : $default_title;?></div>
                            <div class="seo-link"><span class="g-link"><?=isset($post->ID) ? get_permalink($post->ID) : get_bloginfo('url')?></span> - <span class="g-cached">Cached</span></div>
                            <div class="seo-desc"><span class="g-date"><?=date('j M Y')?></span> – <span class="seo-desc-text"><?=!empty($seo_data['desc']) ? $seo_data['desc'] : $default_desc;?></span></div>
                        </div>
                    </div>
                <? } ?>
                <div class="field seo-custom-field">
                    <div class="details">
                        <div class="title"><?=__('SEO Title','kontrolwp')?></div>
                    </div>
                    <div class="input">
                		 <input type="text" name="_kontrol_seo[title]" value="<?=!empty($seo_data['title']) ? htmlentities($seo_data['title'], ENT_QUOTES, 'UTF-8') : '';?>" data-default-title="<?=htmlentities($default_title, ENT_QUOTES, 'UTF-8')?>" class="seo-title" />
                         <div class="auto-button title"><input type="button" value="Auto Generate" data-default-title="<?=htmlentities($default_title, ENT_QUOTES, 'UTF-8')?>" data-wp-site-title="<?=htmlentities(get_bloginfo('title'), ENT_QUOTES, 'UTF-8')?>" /></div>
               		</div>
                    <div class="instructions"><span class="seo-count title-count">70</span> <?=sprintf(__('characters left - search engines will typically allow a maximum of %d characters to be displayed','kontrolwp'),70)?>. <? if(isset($settings['template_tag']) && !$settings['template_tag']) { ?><?=__('Insert template tags to dynamically add information such as your sites name, click the tab at the top for more details','kontrolwp')?>.<? }?></div>
                </div>
                <div class="field seo-custom-field">
                    <div class="details">
                        <div class="title"><?=__('Meta Description','kontrolwp')?></div>
                    </div>
                    <div class="input">
                		 <textarea name="_kontrol_seo[desc]" class="seo-desc" data-default-desc="<?=htmlentities($default_desc, ENT_QUOTES, 'UTF-8')?>"><?=!empty($seo_data['desc']) ? $seo_data['desc'] : '';?></textarea>
       
               		</div>
                    <div class="instructions"><span class="seo-count desc-count">156</span> <?=sprintf(__('characters left - search engines will typically allow a maximum of %d characters to be displayed','kontrolwp'),156)?>. <? if(isset($settings['template_tag']) && !$settings['template_tag']) { ?><?=__('Insert template tags to dynamically add information such as your sites name, click the tab at the top for more details','kontrolwp')?>.<? }?></div>
                </div>
                 <? if(isset($settings['keywords']) && $settings['keywords'] == TRUE) { ?>
                    <div class="field">
                        <div class="details">
                            <div class="title"><?=__('Meta Keywords','kontrolwp')?></div>
                        </div>
                        <div class="input">
                             <input type="text" name="_kontrol_seo[keywords]" value="<?=!empty($seo_data['keywords']) ? $seo_data['keywords'] : '';?>" />
                        </div>
                        <div class="instructions"><?=__('Enter your meta keywords above','kontrolwp')?>.</div>
                    </div>
                <? } ?>
                <? if(!empty($default_title) || !empty($default_desc)) { ?>
                    <div class="seo-default">
                       <select name="_kontrol_seo[type]" class="kontrol-seo-select">
                            <option value="default" <?=isset($seo_data['type']) && $seo_data['type'] == 'default' ? 'selected="selected"':''?>><?=__('Use SEO Defaults','kontrolwp')?></option>
                            <option value="custom" <?=isset($seo_data['type']) && $seo_data['type'] == 'custom' ? 'selected="selected"':''?>><?=__('Use custom SEO for this post','kontrolwp')?>&nbsp;</option>
                       </select>
                    </div>
                <? } ?>
            	
            </div>
            <div id="tab-2" class="kontrol-tab-slide">
            	 <div class="field">
                    <div class="details">
                        <div class="title">301 <?=__('Redirect - Internal','kontrolwp')?></div>
                    </div>
                    <div class="input">
                       	  <select name="_kontrol_seo[redirect_internal]" >
                               <option value=""><?=__('Select','kontrolwp')?></option>
                           
                                <?  foreach($page_list as $pt => $pt_list) { 
                                        if(count($pt_list) > 0) {
                                            // Get the post type
                                            $pt_ob = get_post_type_object($pt);
                                            $pt_label = $pt_ob->label;
                                    ?>
                                            <optgroup label="<?=$pt_label?>">
                                    <?
                                            foreach($pt_list as $page_id => $page_val) { 
                                                // If the page val is an object, its a post/non-heirachy
                                                if(!is_object($page_val)) {
                                                    $page_label = $page_val;
                                                    $page_val = get_page($page_id);
                                                }else{
                                                    $page_label	= $page_val->post_title;
												}
                                                ?>
                                                 <option value="<?=$page_val->ID?>" <?=isset($seo_data['redirect_internal']) && $seo_data['redirect_internal'] == $page_val->ID ? 'selected="selected"':''?>><?=$page_label?></option>
                                              <?
                                            }
                                        ?>
                                            </optgroup>
                                        <?
                                      }
                                    } 
                                ?>
                        </select>
                    </div>
                    <div class="instructions"><?=__('Redirect this page to an interal post or page','kontrolwp')?>.</div>
                </div>
                <div class="field">
                    <div class="details">
                        <div class="title">301 <?=__('Redirect - External','kontrolwp')?></div>
                    </div>
                    <div class="input">
                       	 <input type="text" name="_kontrol_seo[redirect_external]" value="<?=!empty($seo_data['redirect_external']) ? $seo_data['redirect_external'] : '';?>" class="validate-url" />
                    </div>
                    <div class="instructions"><?=__('Redirect this page to an an external URL. Any URL entered here will override any internal redirect set above','kontrolwp')?>.</div>
                </div>
            </div>
            <div id="tab-3" class="kontrol-tab-slide">
            	 <div class="field">
                    <div class="details">
                        <div class="title"><?=__('Canonical URL','kontrolwp')?></div>
                    </div>
                    <div class="input">
                       	 <input type="text" name="_kontrol_seo[canonical_url]" value="<?=!empty($seo_data['canonical_url']) ? $seo_data['canonical_url'] : '';?>" class="validate-url" />
                    </div>
                    <div class="instructions"><?=sprintf(__('Enter a specific canonical URL for this post to use. If empty, the permalink %s will be used. For more information on canonical URLs','kontrolwp'), get_permalink())?></b>, <a href="http://support.google.com/webmasters/bin/answer.py?hl=en&answer=139394" target="_blank"><?=__('read this article','kontrolwp')?></a>.</div>
                </div>
            </div>
            <div id="tab-4" class="kontrol-tab-slide">
                <div class="field">
                        <div class="details">
                            <div class="title"><?=__('Meta Robot Index','kontrolwp')?></div>
                        </div>
                        <div class="input">
                            <select name="_kontrol_seo[meta_index]" >
                                    <option value="INDEX" <?=isset($seo_data['meta_index']) && $seo_data['meta_index'] == 'INDEX' ? 'selected="selected"':''?>><?=__('Index','kontrolwp')?></option>
                                    <option value="NOINDEX" <?=isset($seo_data['meta_index']) && $seo_data['meta_index'] == 'NOINDEX' ? 'selected="selected"':''?>><?=__('No Index','kontrolwp')?></option>            
                            </select>
                        </div>
                        <div class="instructions"><?=__("Select 'Index' if you wish this page to appear in search engines. Select 'No Index' if you do not",'kontrolwp')?>.</div>
                    </div>
                
                <div class="field">
                        <div class="details">
                            <div class="title"><?=__('Meta Robot Follow','kontrolwp')?></div>
                        </div>
                        <div class="input">
                            <select name="_kontrol_seo[meta_follow]" >
                                    <option value="FOLLOW" <?=isset($seo_data['meta_follow']) && $seo_data['meta_follow'] == 'FOLLOW' ? 'selected="selected"':''?>><?=__('Follow','kontrolwp')?></option>
                                    <option value="NOFOLLOW" <?=isset($seo_data['meta_follow']) && $seo_data['meta_follow'] == 'NOFOLLOW' ? 'selected="selected"':''?>><?=__('No Follow','kontrolwp')?></option>            
                            </select>
                        </div>
                        <div class="instructions"><?=__("Selecting 'No Follow' will prevent search engines from scanning links on this page to index",'kontrolwp')?>.</div>
                    </div>
                    <div class="field">
                        <div class="details">
                            <div class="title"><?=__('Meta Robot Options','kontrolwp')?></div>
                        </div>
                        <div class="input">
                            <select name="_kontrol_seo[meta_robot][]" size="4" multiple="multiple">
                                <option value="NOODP" <?=isset($seo_data['meta_robot']) && in_array('NOODP', $seo_data['meta_robot'])  ? 'selected="selected"':''?>><?=__('No')?> ODP</option>
                                <option value="NOYDIR" <?=isset($seo_data['meta_robot']) && in_array('NOYDIR', $seo_data['meta_robot']) ? 'selected="selected"':''?>><?=__('No')?> YDIR</option>
                                <option value="NOARCHIVE" <?=isset($seo_data['meta_robot']) && in_array('NOARCHIVE', $seo_data['meta_robot']) ? 'selected="selected"':''?>><?=__('No')?> <?=__('Archive','kontrolwp')?></option>
                                <option value="NOSNIPPET" <?=isset($seo_data['meta_robot']) && in_array('NOSNIPPET', $seo_data['meta_robot']) ? 'selected="selected"':''?>><?=__('No')?> <?=__('Snippet','kontrolwp')?></option>
                            </select>
                        </div>
                        <div class="instructions"><?=__('Advanced meta robot options','kontrolwp')?>.</div>
                    </div>
                </div>
                <div id="tab-5" class="kontrol-tab-slide template-tags">
            	 <div class="field">
                
                    <div class="instructions"><?=sprintf(__('Template tags are used as a way of entering dynamic information in the Title and Description fields. These tags will be replaced when viewed in the frontend with their equivalent information. Eg: Entering <b>[[sitename]]</b> in either the Title or Description field here will produce "<b>%s</b>" when viewed in the frontend','kontrolwp'),get_bloginfo('title'))?>.</div>
                    <div class="input">
                       	<?=$this->renderElement('template-parse-list', array('type'=>'frontend'));?>
                    </div>
                    
                </div>
            
            </div>
          </div>
       </div>
    </div>
</div>