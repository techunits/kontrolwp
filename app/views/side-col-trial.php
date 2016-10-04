<? if(KONTROL_T) { 

	$reasons = array();
	$reasons[] = __("This plugin was created with a huge amount of love and against all the rules of science, it actually loves you back!",'kontrolwp');
	$reasons[] = __("Picture the biggest set of 'puppy dog' eyes you've ever seen, that's how our plugin is looking at you now.",'kontrolwp');
	$reasons[] = __("Upgrading to the full version today will probably cost less than your lunch, it's a total bargain, just take a look!",'kontrolwp');
	$reasons[] = __("I just want to say, I love you with all my HTML heart.",'kontrolwp');
	$reasons[] = __("In a recent survey of Kontrol users who upgraded, it was found 100% were classy, intelligent and just generally awesome people. We see you'll fit right in!",'kontrolwp');
	$reasons[] = __("Some people don't actually like Icecream, how weird is that!",'kontrolwp');
	$reasons[] = __("Hey, you're pretty cool.",'kontrolwp');
	$reasons[] = __("Kontrol is developed by people just like you! We really hope you like and enjoy the plugin. Go team!",'kontrolwp');
	$reasons[] = __("Hope you're day is going well and if it isn't, I'm sure it'll get better. Chin up tiger!",'kontrolwp');
	$reasons[] = __("The full version of Kontrol has a huge amount of features and once you pay for it, you get all future upgrades and new modules in it for free, wow!",'kontrolwp');
	$reasons[] = __("I wonder if M&Ms are any relation to B&Bs?",'kontrolwp');
	$reasons[] = __("Upgrading to the full version of Kontrol is super quick, easy and cheap. Think how much time it's already saved you! Go on, you won't regret it :)",'kontrolwp');
	$reasons[] = __("Beep beep boop beep",'kontrolwp').' 01010111100010.';

	$rand_key = array_rand($reasons);
	
	$reasons[$rand_key];

?>
       <div class="menu-item love">
          <div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=__('Get the full version now','kontrolwp')?></a></div>
          <div class="desc"><?=$reasons[$rand_key];?> <?=__('Click above to upgrade today and get the most out of Kontrol','kontrolwp')?>.</div>
      </div>
<? } ?>