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


<form id="seo-defaults" action="<?=$controller_url?>/defaultsSave/&noheader=true" method="POST">

<!-- Main Col -->
<div class="main-col inline">

	 <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Header')?> &lt;title&gt; <?=__('Tag')?> <span class="tip"></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                         <div class="item">
                             <div class="field tip"><?=sprintf(__('We strongly recommend having %s as your title tag in your header file for SEO to work effectively. The header file is typically header.php in your themes directory','kontrolwp'),"<span class='black'><b>&lt;title&gt;&lt;?php wp_title(''); ?&gt;&lt;/title&gt;</b></span>")?>.</div>
                         </div>
                    </div>
                </div>
            </div>
     </div>
     
     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                     <?=__('Dynamic Variables','kontrolwp')?> <span class="tip"><?=__('use these variables in the defaults below to add that information dynamically','kontrolwp')?></span>
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                         <div class="item">
                             <div class="field">
                             	<?=$this->renderElement('template-parse-list', array('type'=>'frontend'));?>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
     </div>
     
     <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Title &amp; Meta Data Defaults','kontrolwp')?> <span class="tip"> <?=__('set defaults for each title/meta type here - you can add dynamic variables into the data easily','kontrolwp')?></span>
                    <div class="div"></div>
                 </div>
                 <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?=__('Examples','kontrolwp')?></div>
                             <div class="field"> 
                                <?=__('Homepage Title','kontrolwp')?> &nbsp;-  <?=__('Adding','kontrolwp')?> &nbsp;<span class="red"><b>[[sitename]] - [[sitedesc]]</b></span> &nbsp; <?=__('would produce','kontrolwp')?> &nbsp; <span class="red"><b><?=get_bloginfo('title')?> - <?=get_bloginfo( 'description', 'display' )?></b></span><br />
                                <?=__('Post Type Title','kontrolwp')?> &nbsp;&nbsp;&nbsp;&nbsp;- <?=__('Adding','kontrolwp')?> &nbsp;<span class="red"><b>[[title]] : [[sitename]]</b></span> &nbsp; <?=__('would produce','kontrolwp')?> &nbsp; <span class="red"><b><?=__('My Page Title','kontrolwp')?> : <?=get_bloginfo('title')?></b></span>
                            </div> 
                        	
                         </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?=__('Homepage','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][home][title]" title="Title" class="sixty" value="<?=isset($defaults['custom']['home']['title']) ? htmlentities($defaults['custom']['home']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][home][desc]" title="Meta Description" class="sixty"><?=isset($defaults['custom']['home']['desc']) ? $defaults['custom']['home']['desc'] :''?></textarea>
                            </div> 
                            <div class="desc"><?=__('Note: Adding homepage SEO information here will override any SEO information set on an individual post/page that has been set as the homepage','kontrolwp')?>.</div>
                         </div>
                    </div>
                </div>
                 <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label">404 <?=__('Page')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][404][title]" title="Title" class="sixty" value="<?=isset($defaults['custom'][404]['title']) ? htmlentities($defaults['custom'][404]['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][404][desc]" title="Meta Description" class="sixty"><?=isset($defaults['custom'][404]['desc']) ? $defaults['custom'][404]['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?=__('Search Page','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][search][title]" title="Title" class="sixty" value="<?=isset($defaults['custom']['search']['title']) ? htmlentities($defaults['custom']['search']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][search][desc]" title="Meta Description" class="sixty"><?=isset($defaults['custom']['search']['desc']) ? $defaults['custom']['search']['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?=__('Archive Page','kontrolwp')?></div>
                             <div class="field"> 
                                <input type="text" name="defaults[custom][archive][title]" title="Title" class="sixty" value="<?=isset($defaults['custom']['archive']['title']) ? htmlentities($defaults['custom']['archive']['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[custom][archive][desc]" title="Meta Description" class="sixty"><?=isset($defaults['custom']['archive']['desc']) ? $defaults['custom']['archive']['desc'] :''?></textarea>
                            </div> 
                          </div>
                    </div>
                </div>
                <? foreach($pts as $pt_key => $pt) { ?>
                <div class="section-content">
                    <div class="form-style">
                    	<div class="item">
                        	 <div class="label"><?=__('Post Type','kontrolwp')?> - <span class="red"><?=$pt->label?></span></div>
                             <div class="field"> 
                                <input type="text" name="defaults[pt][<?=$pt_key?>][title]" title="Title" class="sixty" value="<?=isset($defaults['pt'][$pt_key]['title']) ? htmlentities($defaults['pt'][$pt_key]['title'], ENT_QUOTES) :''?>" />
                            </div> 
                        	 <div class="field"> 
                                <textarea name="defaults[pt][<?=$pt_key?>][desc]" title="Meta Description" class="sixty"><?=isset($defaults['pt'][$pt_key]['desc']) ? $defaults['pt'][$pt_key]['desc'] :''?></textarea>
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