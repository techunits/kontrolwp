/**
* Class name: side-notification.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Displays a notification in the sidebar briefly
*/

var kontrol_notification;

(function($){
	
	kontrol_notification = new Class({
		
		Implements: [Options],
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.setOptions(options);
				
							
					var duration = this.options.duration;
					// Get all the notifications
					this.notes = $$('#kontrol .notification');
					// Now set their effects and hide them
					this.notes.each(function(note) {
						// Set the effects and hide them
						new Fx.Reveal(note, {duration: 0}).dissolve();
						// Add the title and body
						note.getElement('.title').set('text', this.options.msg_title);
						note.getElement('.text').set('html', this.options.msg_text);
						// Set the effects now
						note.set('reveal', {duration: 1200, transition: Fx.Transitions.Quad.easeOut, transitionOpacity: true,
											  onComplete: function(note) {
												 (function() {
													 this.dissolve();												 
												 }.bind(this)).delay(duration);
											  }.bind(note)
						});
						
						(function() {
							note.reveal();
						}).delay(350);
					}.bind(this));
							
				
			}
	});

})(document.id);