/**
* Class name: utilities.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* A set of small utlities for general css needs in Kontrol
*/

window.addEvent('domready', function() {
		
		var $ = document.id;
		//set_side_bar_height();
		set_bg_height();
		// Set some field effects
		if($('kontrol')) {
			$('kontrol').addEvent('focus:relay(input[type=text], select, textarea)', function(e) {
				// Hide the search label
				TweenLite.to(this, 2, {backgroundColor: '#fffcf1'});
			});
			
			$('kontrol').addEvent('blur:relay(input[type=text], select, textarea)', function(e) {
				// Hide the search label
				TweenLite.to(this, 2, {backgroundColor: '#fff'});
			});	
		}
});

// Sets any div to the height of the side column if it's smaller - used occassionaly, mostly for aesthetics
function set_side_bar_height() {
	var $ = document.id;
	$$('#kontrol .content').setStyle('min-height', $('wpbody').getStyle('height'));
}

// Sets the main grey bg to fill the available area
function set_bg_height() {
	var $ = document.id;
	
	if($('wpfooter')) {
		var pos = $('wpfooter').getPosition().y - 190;
		$$('#kontrol .content').setStyle('min-height', pos);	
	}
}

// Restricts input in a field to certain safe characters
function restrict_safe_characters() {
	var $ = document.id;
	// Add event listeners to replace spaces with - and make everything lowercase for field 'keys'
	$('kontrol').addEvent('keyup:relay(.safe-chars)', function(e) {
		var value = restrict_safe_characters_now(this.get('value'));
		this.set('value', value);
	});	
}

// Restricts input in a field to certain safe characters
function restrict_safe_characters_now(value) {
	value = value.replace(/ /g,'-');
	value = value.replace(/\'/g,'');
	value = value.replace(/"/g,'');
	value = value.replace(/\\/g,'');
	value = value.replace(/\//g,'');
	value = value.replace(/\./g,'-');
	value = value.replace(/\,/g,'-');
	value = value.replace(/:/g,'');
	value = value.replace(/;/g,'');
	value = value.toLowerCase();
	return value;
}

// Duplicates the parent of the current div and add's below - usefull for duplicating form fields with a + button
function duplicate_parent() {
	var $ = document.id;
	// Add event listeners to replace spaces with - and make everything lowercase for field 'keys'
	$('kontrol').addEvent('click:relay(.duplicate-parent)', function(e) {
		var parent = this.getParent();
		
		if(this.hasClass('delete')) {
			parent.destroy();
			// Fire an event to indicate it
			window.fireEvent('duplication-removed', this);
		}else{
			var parentclone = parent.clone();
			// Change the duplicate button from a + to a - and add a remove event for it
			var dup_button = parentclone.getElement('.duplicate-parent');
			dup_button.addClass('delete');
			// Now add it below this one
			parent.getParent('div').grab(parentclone, 'bottom');
			// If this clone has a <select> element, reset it to it's 0 index
			if(this.get('data-dont-reset-select') != 'true') {
				if(parentclone.getElement('select')) {
					parentclone.getElement('select').selectedIndex = 0;	
				}
			}
			// Check to see if we need to add a unique key to the duplicated element
			if(this.get('data-add-unqiue-key')) {
				var reg = new RegExp(this.get('data-add-unqiue-key-format').escapeRegExp(),"g");
				var parenthtml = parentclone.get('html').replace(reg, String.uniqueID());
				parentclone.set('html', parenthtml);
			}
			// Fire an event to indicate it
			window.fireEvent('duplication', this);
		}
		
		window.fireEvent('duplication-event-completed', [this, parent]);
	});	
}


	
	

