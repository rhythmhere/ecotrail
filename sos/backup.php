<?php
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : 27.7172;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : 85.3240;
$search = isset($_GET['s']) ? strtolower($_GET['s']) : 'hospital';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SOS Nearby Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <!-- Mapbox Directions Plugin -->
    <script
        src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.2.0/mapbox-gl-directions.js"></script>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.2.0/mapbox-gl-directions.css" />

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script>
        const ACCESS_TOKEN = 'pk.eyJ1Ijoia2lzaG1hdCIsImEiOiJjbWRmdGRrZG0waTR6MmpzN3p3Y3dka3F6In0.NPt2BEOcw9nygsafo5VXrA';

        const initialLat = <?= json_encode($lat) ?>;
        const initialLon = <?= json_encode($lon) ?>;
        const searchKeyword = <?= json_encode($search) ?>;

        mapboxgl.accessToken = ACCESS_TOKEN;

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/standard',
            center: [initialLon, initialLat],
            zoom: 14
        });

        // User's current location
        const userLocation = [initialLon, initialLat];

        new mapboxgl.Marker({ color: "blue" })
            .setLngLat(userLocation)
            .setPopup(new mapboxgl.Popup().setText("Your Location"))
            .addTo(map);

        // Add directions control
        const directions = new MapboxDirections({
            accessToken: ACCESS_TOKEN,
            unit: 'metric',
            profile: 'mapbox/driving', // or walking
            interactive: false,
            controls: { inputs: false, instructions: true },
        });
        map.addControl(directions, 'top-left');

        if (searchKeyword) {
            const overpassQuery = `
        [out:json];
        (
            node["amenity"="${searchKeyword}"](around:10000, ${initialLat}, ${initialLon});
            way["amenity"="${searchKeyword}"](around:10000, ${initialLat}, ${initialLon});
            relation["amenity"="${searchKeyword}"](around:10000, ${initialLat}, ${initialLon});
        );
        out center;
    `;

            fetch("https://overpass-api.de/api/interpreter?data=" + encodeURIComponent(overpassQuery))
                .then(res => res.json())
                .then(data => {
                    if (data.elements.length === 0) {
                        alert(`No nearby ${searchKeyword} found.`);
                        return;
                    }

                    const sorted = data.elements
                        .map(el => {
                            const lat = el.lat || el.center?.lat;
                            const lon = el.lon || el.center?.lon;
                            const name = el.tags?.name || searchKeyword;
                            const dist = Math.hypot(initialLat - lat, initialLon - lon);
                            return { lat, lon, name, dist };
                        })
                        .filter(el => el.lat && el.lon)
                        .sort((a, b) => a.dist - b.dist);

                    const closest = sorted[0];
                    const destination = [closest.lon, closest.lat];

                    new mapboxgl.Marker({ color: "red" })
                        .setLngLat(destination)
                        .setPopup(new mapboxgl.Popup().setText(`Nearest ${searchKeyword}: ${closest.name}`))
                        .addTo(map);

                    // Add route to Directions control
                    directions.setOrigin(userLocation);
                    directions.setDestination(destination);
                })
                .catch(err => {
                    alert("Error getting SOS locations.");
                    console.error(err);
                });
        }

    </script>
</body>

</html>