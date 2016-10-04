/**
* Class name: custom-fields-gmaps.js
* Author: David Rugendyke - david@ironcode.com.au
* Platform: Mootools - no conflict mode just incase
* Various functions/classes for the custom fields google maps integration
*/

var kontrol_custom_fields_gmaps;

window.addEvent('domready', function() {
	
	// Only start on the post body screens
	(function($){
		if($('post')) {
			// The main class
			new kontrol_custom_fields_gmaps({src_loaded:false});
			
		}
	})(document.id);
});

// Static callback method needed by google maps
function kontrol_src_loaded_gmaps() {
	new kontrol_custom_fields_gmaps({src_loaded:true});	
}			

(function($){
	
	kontrol_custom_fields_gmaps = new Class({
		
			Implements: [Options],
		
			/**
			* Constructor
			*/
			initialize: function(options)
			{
				this.setOptions(options);
				// Grab the form
				this.form = $('post');
				// Check to see if there is a google map on this page, if so add the google scripts
				this.gmaps = $$('div.kontrol-gmap');
				
				if(this.gmaps.length > 0) {
					// Check to see if the maps have already loaded
					if(!this.options.src_loaded) {
						// Load the google maps src files using the users first api key - support for multiple api keys not present 
						this.load_google_maps_src(this.gmaps[0].get('data-api-key'));
					}else{
						// Now get all maps and init them
						this.gmaps.each(function(map) {
							this.init_google_map(map);
						}.bind(this));
					}
				}
				
			},	
			
			/**
			* Initialise a google map
			*/
			init_google_map: function(gmap)
			{
				
				var centre = this.convert_string_coords(gmap.get('data-centre'));
				
				var mapOptions = {
					zoom: parseInt(gmap.get('data-zoom')),
					center: new google.maps.LatLng(centre.lat, centre.lng),
					mapTypeId: google.maps.MapTypeId.ROADMAP
				  }
				  
				var map = new google.maps.Map(gmap, mapOptions);
				
				// Store the main maps, the element and google map instance
				this.gmap = gmap;
				this.map = map;
				
				// Now see which type of map we are dealing with
				if(this.gmap.get('data-type') == 'select') {
					// The user is selecting markers already placed on the map
					this.set_users_markers();	
				}

			},
			
			/**
			* Places a marker on the map
			*/
			place_marker: function(coords, params)
			{
						
				 // Add the marker
				 var marker = new google.maps.Marker({
					animation: google.maps.Animation.DROP,
					position: new google.maps.LatLng(coords.lat, coords.lng),
					map: this.map,
					icon: this.gmap.get('data-icon') != '' ? this.gmap.get('data-icon') : null,
					title: params.title ? params.title : null
				 });
				 
				 return marker;

			},
			
			/**
			* Creates an overlay infowindow element and returns it
			*/
			attach_info_windows: function(marker, title, content)
			{
				
				if(!content) { content = ''; }
										
				var info_html = '<div class="kontrol-gmap-info"><div class="kontrol-gmap-title">'+title+'</div><div class="kontrol-gmap-content">'+content+'</div></div>';
				
				var infowindow = new google.maps.InfoWindow({
					content: info_html
				});

				 google.maps.event.addListener(marker, 'click', function() {
					 
					    // Open the info window
						infowindow.open(this.map, marker);
						
						//console.log(this.gmap);
						//console.log(marker.getPosition().toString());
						
						var lat = marker.getPosition().lat();
						var lng = marker.getPosition().lng();
						
						var data = {'title':title, 'desc':content, 'lat':lat, 'lng':lng};
						
						// Add to the smartbox or remove				
						var smart_box_target = this.gmap.getNext('.kontrol-smart-box');
						var smart_box_vals = smart_box_target.getElements('.row:not(.new-row) input[type=hidden]').get('value');
						console.log(smart_box_vals);
						
						var add_location = true;
						
						// Are we allowing duplicate selections?
						if(this.gmap.get('data-allow-duplicates') == '') {
							// Check to see if it exists already
							smart_box_vals.each(function(location) {
								
								location = JSON.decode(location);
								
								if(location.lat == lat && location.lng == lng) {
									alert(kontrol_i18n_js.gmap_location_duplicate);	
									add_location = false;
								}
							});
						}
							
						if(add_location) {				
							// It's not in there, add it - create a new row based on a copy 
							var new_row = smart_box_target.getElement('.new-row').clone();
							console.log(smart_box_target.getElement('.new-row input[type=hidden]'));
							// Create the label and replace &nbsp; with -
							var label = title.replace(/\u00a0/g, "- ");
							// Add it our data to the new row
							new_row.set('html', new_row.get('html').replace('[[LABEL]]', label));
							new_row.set('html', new_row.get('html').replace('[[VALUE]]', JSON.encode(data)));
							// Fire the smart box event now						
							smart_box_target.fireEvent('smart-box-row-add', [smart_box_target, new_row]);
						}
						
				 }.bind(this));
			},
			
			/**
			* Load a users markers onto the map and adds the needed events
			*/
			set_users_markers: function()
			{
				// Get all the stored markers
				var markers = JSON.decode(this.gmap.get('data-locations'));
				var delay = 1000;
				// Get the bounds of the map
				var fullBounds = new google.maps.LatLngBounds();
				// Place the markers on the map now
				Object.each(markers, function(marker) {
						delay = delay + 400;
						var coords = this.convert_string_coords(marker.marker);
    					setTimeout(function() {
							var marker_gmap = this.place_marker(coords, marker);
							 // Add marker info bubble
							this.attach_info_windows(marker_gmap, marker.title, marker.desc);
						}.bind(this), delay);
						// Zoom to fit bounds
						var point = new google.maps.LatLng(coords.lat,coords.lng);
						fullBounds.extend(point);
				
				}.bind(this));
				
				// Fit the map to show all the markers 
				this.map.fitBounds(fullBounds);

			},
			
			
			/**
			* Converts string coordinates into two floats eg "-27.470933,153.023502" into [-27.470933,153.023502]
			*/
			convert_string_coords: function(coord_string)
			{
				var coords = Object();
				var parts = coord_string.split(',');
				coords.lat = parseFloat(parts[0].trim());
				coords.lng = parseFloat(parts[1].trim());

				return coords;				
			},
			
			/**
			* Loads the google maps javascript files
			*/
			load_google_maps_src: function(api_key)
			{
				  var script = document.createElement("script");
				  script.type = "text/javascript";
				  script.src = "http://maps.googleapis.com/maps/api/js?key="+api_key+"&sensor=false&callback=kontrol_src_loaded_gmaps";
				  document.body.appendChild(script);
			}
			
					
	});


})(document.id);