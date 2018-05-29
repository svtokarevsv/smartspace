document.addEventListener('DOMContentLoaded', function (e) {
    var map;
    var geoCoder = new google.maps.Geocoder();

    function initMap() {
        map = new google.maps.Map(document.getElementById('g_map'), {
            center: {lat: 43.7289835, lng: -79.6064849},
            zoom: 8
        });

        google.maps.event.addListener(map, 'click', function (me) {
            geoCodeLatLng(me.latLng.lat(),me.latLng.lng(),function (address) {
                $("#new_event_location").val(address);
                $('#maps_modal').modal('hide');
            })
        });
    }

    initMap()
    $('#open_map_modal').click(function (e) {
        $('#maps_modal').modal('show')
    })
    function geoCodeLatLng(lat, lng, callback) {
        var latlng = new google.maps.LatLng(lat, lng);
        geoCoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var str = results[0].formatted_address;
                callback(str);
            } else {
                notifyDanger("Couldn\'t get the address")
            }
        });
    }

});

