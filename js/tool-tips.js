/**
* Class name: tool-tips.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Creates tool tips
*/

var kontrol_tool_tips;

(function($){
	
	kontrol_tool_tips = new Class({
		
			Implements: [Options],
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.setOptions(options);
				
				if($(this.options.container)) {			
					this.tips = new Tips(null, {
						onShow: function(tip, el){
							var max_width = el.get('data-width');
							
							
							if(max_width) {
								tip.setStyle('max-width', max_width+'px');
							}
							// Set the text and fade it in now
							tip.getElement('.tip-text').set('html', el.get('data-text'));
							// Some IE8 fixes
							if (Browser.ie && Browser.version < 9){
								tip.addClass('ie8-tip');
								tip.show();
							}else{
								tip.addClass('kontrol-tool-tip');
								tip.fade('in');
							}
							
						},
						onHide: function(tip, el){
							if (Browser.ie && Browser.version < 9){
								tip.hide();
							}else{
								tip.fade('out');
							}
						}
					});
					
					this.listeners();
				}
									
			},
			
			/**
			* Main event listeners 
			*/
			listeners: function()
			{
				// This method ensures that tooltips that are added even dynamically will work fine
				$(this.options.container).addEvent('mouseover:relay(.kontrol-tip)', function(e) {
					// Check to see if this one has an tip instance
					var instance = e.target.retrieve('tip-added');
					// Not one added? add it now
					if(!instance) {
						this.tips.attach(e.target);
						// Store a flag so we don't add this instance twice
						e.target.store('tip-added', true);
						// Now fire the mouseover instance again to trigger the tooltip
						this.tips.elementEnter(e, e.target);
					}
				}.bind(this));
			}
	
	});
	
	


})(document.id);