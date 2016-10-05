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
  			new Form.Validator.Inline('seo-defaults');
			
			// Labels over the inputs.
			 $('seo-defaults').getElements('input[type=text], textarea').each(function(el){
				  // Put some text over the form fields using their titles
				 new OverText(el, {
					'positionOptions': {x:5, y:10}
				 });
			 });
			
	});
</script>


<form id="seo-defaults" action="<?php echo $controller_url?>/defaultsSave/&noheader=true" method="POST">

<!-- Main Col -->
<div class="main-col inline">

	 <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Header')?> &lt;title&gt; <?php echo __('Tag')?> <span class="tip"></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                         <div class="item">
                             <div class="field tip"><?php echo sprintf(__('We strongly recommend having %s as your title tag in your header file for SEO to work effectively. The header file is typically header.php in your themes directory','kontrolwp'),"<span class='black'><b>&lt;title&gt;&lt;?php wp_title(''); ?&gt;&lt;/title&gt;</b></span>")?>.</div>
                         </div>
                    </div>
                </div>
            </div>
     </div>
     
     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                     <?php echo __('Dynamic Variables','kontrolwp')?> <span class="tip"><?php echo __('use these variables in the defaults below to add that information dynamically','kontrolwp')?></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                         <div class="item">
                             <div class="field">
                             	<?php echo $this->renderElement('template-parse-list', array('type'=>'frontend'));?>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
     </div>
     
     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Title &amp; Meta Data Defaults','kontrolwp')?> <span class="tip"> <?php echo __('set defaults for each title/meta type here - you can add dynamic variables into the data easily','kontrolwp')?></span>
                    <div class="div"></div>
                 </div>
                 <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?php echo __('Examples','kontrolwp')?></div>
                             <div class="field"> 
                                <?php echo __('Homepage Title','kontrolwp')?> &nbsp;-  <?php echo __('Adding','kontrolwp')?> &nbsp;<span class="red"><b>[[sitename]] - [[sitedesc]]</b></span> &nbsp; <?php echo __('would produce','kontrolwp')?> &nbsp; <span class="red"><b><?php echo get_bloginfo('title')?> - <?php echo get_bloginfo( 'description', 'display' )?></b></span><br />
                                <?php echo __('Post Type Title','kontrolwp')?> &nbsp;&nbsp;&nbsp;&nbsp;- <?php echo __('Adding','kontrolwp')?> &nbsp;<span class="red"><b>[[title]] : [[sitename]]</b></span> &nbsp; <?php echo __('would produce','kontrolwp')?> &nbsp; <span class="red"><b><?php echo __('My Page Title','kontrolwp')?> : <?php echo get_bloginfo('title')?></b></span>
                            </div> 
                        	
                         </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?php echo __('Homepage','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][home][title]" title="Title" class="sixty" value="<?php echo isset($defaults['custom']['home']['title']) ? htmlentities($defaults['custom']['home']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][home][desc]" title="Meta Description" class="sixty"><?php echo isset($defaults['custom']['home']['desc']) ? $defaults['custom']['home']['desc'] :''?></textarea>
                            </div> 
                            <div class="desc"><?php echo __('Note: Adding homepage SEO information here will override any SEO information set on an individual post/page that has been set as the homepage','kontrolwp')?>.</div>
                         </div>
                    </div>
                </div>
                 <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label">404 <?php echo __('Page')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][404][title]" title="Title" class="sixty" value="<?php echo isset($defaults['custom'][404]['title']) ? htmlentities($defaults['custom'][404]['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][404][desc]" title="Meta Description" class="sixty"><?php echo isset($defaults['custom'][404]['desc']) ? $defaults['custom'][404]['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?php echo __('Search Page','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][search][title]" title="Title" class="sixty" value="<?php echo isset($defaults['custom']['search']['title']) ? htmlentities($defaults['custom']['search']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][search][desc]" title="Meta Description" class="sixty"><?php echo isset($defaults['custom']['search']['desc']) ? $defaults['custom']['search']['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?php echo __('Archive Page','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][archive][title]" title="Title" class="sixty" value="<?php echo isset($defaults['custom']['archive']['title']) ? htmlentities($defaults['custom']['archive']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][archive][desc]" title="Meta Description" class="sixty"><?php echo isset($defaults['custom']['archive']['desc']) ? $defaults['custom']['archive']['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <? foreach($pts as $pt_key => $pt) { ?>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?php echo __('Post Type','kontrolwp')?> - <span class="red"><?php echo $pt->label?></span></div>
                             <div class="field"> 
                                <input type="text" name="defaults[pt][<?php echo $pt_key?>][title]" title="Title" class="sixty" value="<?php echo isset($defaults['pt'][$pt_key]['title']) ? htmlentities($defaults['pt'][$pt_key]['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[pt][<?php echo $pt_key?>][desc]" title="Meta Description" class="sixty"><?php echo isset($defaults['pt'][$pt_key]['desc']) ? $defaults['pt'][$pt_key]['desc'] :''?></textarea>
                            </div> 
                         </div>
                    </div>
                </div>
                <? } ?>
            </div>
     </div>


</div>


 <!-- Side Col -->
<div class="side-col inline">
	
    
    <?php $this->renderElement('seo-side-col', array('controller_url' => $controller_url)); ?>
 
</div>

</form>