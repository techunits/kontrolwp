<script type="text/javascript">

	<? if(KONTROL_T) { ?>
	
	window.addEvent('domready', function() {
		
		(function($){
			// Various custom utilities for working with forms
			$('kontrol').getElement('#register-button').addEvent('click', function(e) {
				var key = $('kontrol').getElement('#key').get('value');
				var loader = $('kontrol').getElement('#reg-load');
				var response = $('kontrol').getElement('#reg-response');
				var error = response.getElement('#reg-error');
				var success = $('kontrol').getElement('#reg-success');
				if(key) {
					loader.show();
					error.hide();
					new Request.JSON({
						  url: '<?=$controller_url?>/upgrade/&noheader=true&cache=', 
						  data: 'key='+key,
						  noCache: true,
						  onError: function(text, error) {
							  alert('<?=__('Error occured contacting the server', 'kontrolwp')?>: '+text+' - Error: '+error);	
							  loader.hide();
						  },
						  onComplete: function(resp) {					  
							  // Success?
							  if(resp.result == 'true') {
								  response.hide();
								  success.set('html', resp.msg);
								  success.show();
							  }else{
								  error.set('html', 'Error: '+resp.error);
								  error.show();
							  }
							  
							  loader.hide();
						  }
				   }).send();
				}
			  });
		   })(document.id);
		});
	<? } ?>
</script>

<div class="main-col inline" style="width: 100%">
        <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Register', 'kontrolwp')?> Kontrol <span class="tip"><?=__('upgrade Kontrol to the full version', 'kontrolwp')?></span>
                    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('License Key', 'kontrolwp')?><span class="req-ast">*</span></div>
                             <? if(KONTROL_T) { ?>
                                <div class="field"><input type="text" id="key" name="key" value="" maxlength="200" class="required ninety safe-chars" /></div>
                                <div class="desc"><?=sprintf(__('Enter your license key here to upgrade. An Internet connection is required. If you don\'t have a license key, <a href="%s" target="_blank">grab one from here</a>, it\'s super cheap and quick!', 'kontrolwp'), APP_UPGRADE_URL)?></div>
                                <br />
                                <div id="reg-response">
                                	<div class="inline"><input type="submit" value="<?=__("Register Now", 'kontrolwp')?>" id="register-button" /></div>&nbsp;&nbsp;&nbsp;
                                    <div class="inline" style="padding-top: 10px"><img src="<?=URL_IMAGE?>ajax-loader-2.gif" id="reg-load" style="display: none" /></div>&nbsp;
                                    <div id="reg-error" class="inline" style="padding-top: 10px; color: #F00;"><?=(!in_array('curl', get_loaded_extensions())) ? __("Error: You don't appear to have the CURL module in your PHP installation - You'll need that to register Kontrol. Contact your server administrator to get the module installed.", 'kontrolwp'):""?></div>
                                </div>
                                <div id="reg-success"></div>
                             <? }else{ ?>
                             	<div class="field"><?=__("You've already registered", 'kontrolwp')?> Kontrol!</div>
                             <? } ?>
                        </div>
                    </div>
                </div>
        </div>
   </div>
</div>


        
        