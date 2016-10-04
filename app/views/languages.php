<? 
	// See if their language is currently supported (doesn't include English), show the translation option if it isn't
	if(strpos(WPLANG, 'en_') !== true && strlen(WPLANG) > 0) {
		// Current langs supported
		$langs = explode(',', LANG_SUPPORTED);
		// If it isn't supported, show a box on how they can help translate it
		if(!in_array(WPLANG, $langs)) { ?>
        	<div class="section">
				<div class="inside">
                	<div class="title">Language Support</div>
                    <div class="menu-item lang">
                      <div class="link"><a href="<?=APP_PLUGIN_LANG_URL?>" target="_blank">Get Kontrol in your language</a></div>
                      <div class="desc">Kontrol doesn't currently support your language in full. If you would be interested in translating Kontrol to your language from English, we'll throw a bunch of free copies of Kontrol your way in return and give you credit! <a href="<?=APP_PLUGIN_LANG_URL?>" target="_blank">View our site for more information</a>.</div>
                  </div>
               </div>
           </div>
		<? }
	}

?>