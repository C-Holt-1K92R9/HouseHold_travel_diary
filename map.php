<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header("Location: login.html");
    session_abort();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/bundle.min.js"></script>
    
    <style>
        #map {
            height: 100%;
            width: 100%;
        }
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevents scrolling on mobile */
        }
        
        /* Style for zoom button */
        .custom-zoom {
            display: flex;
            align-items: center;
            z-index: 1000;
            background-color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            color: black;
            font-size: 18px;
            border-radius: 6px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
            touch-action: manipulation;
        }
        
        /* Map controls container */
        .mapitem {
            width: auto;
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }
        
        /* Responsive styles for mobile phones */
        @media (max-width: 1081px) {
            .custom-zoom {
                padding: 8px 10px;
                font-size: 16px;
            }
            
            .mapitem {
                top: 45px;
                right: 5px;
            }
            
            #map {
                height: 100vh;
            }
        }
        
        /* Add more padding to buttons to make them easier to tap on touch screens */
        button {
            padding: 10px;
        }
    </style>
    
</head>
<body>
    <div id="map"></div>
    <div class="mapitem">
        <button id="zoomButton" class="custom-zoom btn" disabled>Zoom to Location</button>
        <br>
        <button id="currentLocationButton" class="custom-zoom">Current Location</button> <!-- New button for current location -->
        <br>
        <button class="custom-zoom" onclick="closem()">Enter</button>
    </div>
    
    <script>
        let map;
        let marker;
        let lastSearchedLocation = null;  
        let type = new URLSearchParams(window.location.search).get('type');
        
        function initMap() {
            // Initialize map and set default view to Chittagong, Bangladesh
            map = L.map('map').setView([22.3475, 91.8123], 13);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Place marker on click
            map.on('click', function(event) {
                const { lat, lng } = event.latlng;
                placeMarker(lat, lng);
            });

            // Add GeoSearch control
            const provider = new window.GeoSearch.OpenStreetMapProvider();
            const searchControl = new window.GeoSearch.GeoSearchControl({
                provider: provider,
                style: 'bar',
                showMarker: false,
                autoClose: true,
                retainZoomLevel: false,
                searchLabel: 'Enter location...',
            });

            map.addControl(searchControl);

            // Store last search result and enable zoom button
            map.on('geosearch/showlocation', function(result) {
                const { x: lng, y: lat } = result.location;
                placeMarker(lat, lng);
                lastSearchedLocation = result.location;
                document.getElementById('zoomButton').disabled = false;
            });
        }

        // Function to place marker and send data back to main form
        function placeMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            window.opener.receiveLocationData(lat, lng, type);
        }
        
        // Close map window
        function closem() {
            window.close();
        }
        
        // Zoom to last searched location
        function zoomToLocation() {
            if (lastSearchedLocation) {
                map.setView([lastSearchedLocation.y, lastSearchedLocation.x], 18);
            }
        }

        // Add event listener to the zoom button
        document.getElementById('zoomButton').addEventListener('click', zoomToLocation);

        // Get and zoom to the current location using Geolocation API
        document.getElementById('currentLocationButton').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 18);  // Zoom to current location
                    placeMarker(lat, lng);  // Place marker at current location
                }, function() {
                    alert("Unable to retrieve your location");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        window.onload = initMap;
    </script>
</body>
</html>