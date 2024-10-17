var isJeepTerminalVisible = false; // Variable to track the visibility state

document.getElementById('jeepTerminalBtn').addEventListener('click', function () {
    // Check the current state
    if (isJeepTerminalVisible) {
        // If visible, remove the marker and circle
        map.removeLayer(jterminalMarker);
        map.removeLayer(jterminalCircle);

        isJeepTerminalVisible = false; // Set the state to off
        document.getElementById('jeepTerminalBtn').style.backgroundColor = '';
    } else {
        // If not visible, make an AJAX request to fetch jeepney terminal location
        $.ajax({
            type: 'GET',
            url: 'get_jeep_terminal.php', // Adjust the URL based on your file structure
            dataType: 'json',
            success: function (data) {
                if (data) {
                    // Update the map view to the jeepney terminal location
                    console.log(data);

                    jterminal_lat = data.latitude;
                    jterminal_lng = data.longitude;

                    // Create and add new marker and circle
                    jterminalMarker = L.marker([jterminal_lat, jterminal_lng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                        })
                    }).addTo(map);
                    jterminalCircle = L.circle([jterminal_lat, jterminal_lng], {
                        color: 'green',
                        fillColor: 'green',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);

                    map.setView([data.latitude, data.longitude], 16);

                    isJeepTerminalVisible = true; // Set the state to on
                } else {
                    console.error('Unable to fetch jeepney terminal location.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching jeepney terminal location:', error);
            }
        });
        document.getElementById('jeepTerminalBtn').style.backgroundColor = '#20A2AA';
    }
});
    