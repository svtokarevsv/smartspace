document.addEventListener('DOMContentLoaded', function (e) {
	let map
	let geoCoder
	let currentPositionMarker
	let friendPositionMarker

	initMap()
	fillCurrentUserLocation()
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('location__update-btn'):
				getCurrentUserLocation()
				break
		}
	})
	const search_users_with_delay = debounce(function (responseCallback) {
		$.getJSON({
			url: ROOT_URI + "location/ajax_search_friend_location_by_name",
			data: {
				search_term: $('#search_friend').val()
			},
			success: function (data) {
				responseCallback(data.friends);
			}
		})
	}, 400)
	$("#search_friend").autocomplete({
		source: function (request, response) {
			search_users_with_delay(response)
		},
		focus: function (event, ui) {
			return false;
		},
		select: function (event, ui) {

			if(friendPositionMarker){
				friendPositionMarker.setMap(null)
			}
			$('#friend_location').html('')
			setFriendsLocation(ui.item)
			$('#search_friend').val("")
			return false
		}
	})
		.data("ui-autocomplete")._renderItem = function (ul, item) {
		let inner_html = `
						<div class="list_item_container">
							<div class="image">
								<img src="${ROOT_URI + item.image_path}" >
							</div>
							<div class="label">
								<h4>
									<b> ${item.label} </b>
								</h4>
							</div>
						</div>`;
		return $("<li></li>")
			.data("item.autocomplete", item)
			.append(inner_html)
			.appendTo(ul);
	};
	function setFriendsLocation(friend) {
		if(!friend.lat||!friend.ln){
			return notifyInfo('No location found for '+friend.label)
		}
		const latlng = new google.maps.LatLng(friend.lat, friend.ln);

		geoCodeLatLng(latlng,function (address) {
			const html=`<strong>${friend.label}'s last location was near:</strong> <br/>${address}<br/>
					 (updated: ${humanizeDate(friend.location_last_updated)})`
			$('#friend_location').html(html)
		})

		const image = {
			url: ROOT_URI+friend.image_path,
			// This marker is 20 pixels wide by 32 pixels high.
			size: new google.maps.Size(20, 20),
			// The origin for this image is (0, 0).
			origin: new google.maps.Point(0, 0),
			// The anchor for this image is the base of the flagpole at (0, 32).
			anchor: new google.maps.Point(0, 20),
			scaledSize: new google.maps.Size(20, 20)
		};
		friendPositionMarker = new google.maps.Marker({
			position: latlng,
			map: map,
			icon: image,
			title: friend.label
		});
		map.setCenter(latlng)
	}
	function getCurrentUserLocation() {
		navigator.geolocation.getCurrentPosition(updateUserLocation, (error) => {
			"use strict"
			if (error.code === error.PERMISSION_DENIED)
				notifyDanger('Permission to location denied by your browser')
		})
	}

	function updateUserLocation(position) {
		$.post(ROOT_URI + "location/ajax_update_user_location", {
			lat: position.coords.latitude,
			ln: position.coords.longitude
		})
			.done(function (data) {
				if (data['result'] === 'ok') {
					fillCurrentUserLocation()
					notifyInfo('Location updated successfully')
				}
				else {
					notifyDanger(getErrors(data['errors']))
				}
			})
			.fail(function () {
				notifyDanger('Sorry, we have problems. Try again later')
			});
	}

	function fillCurrentUserLocation() {
		$.getJSON(ROOT_URI + "location/ajax_get_current_user_location", function (data) {
			if (data) {
				const latlng = new google.maps.LatLng(data.lat, data.ln);

				geoCodeLatLng(latlng,function (address) {
					$('#current_user_location').html(address+`<br/> (updated: ${humanizeDate(data.last_updated)})`)
				})
				if(currentPositionMarker){
					currentPositionMarker.setMap(null)
				}
				currentPositionMarker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: 'Your last position'
				});
				map.setCenter(latlng)
			} else {
				$('#current_user_location').text('not found')
				notifyInfo('No location found for current user')
			}
		})
	}

	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 43.7289835, lng: -79.6064849},
			zoom: 14
		});
		geoCoder= new google.maps.Geocoder()
	}

	function geoCodeLatLng(latLng, callback) {
		geoCoder.geocode({latLng}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var str = results[0].formatted_address;
				callback(str);
			} else {
				notifyDanger("Couldn\'t get the address")
			}
		});
	}
})
