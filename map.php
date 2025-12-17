<?php
$origin = '';
$dest = '';
if (isset($_GET['origin'])) {
    $origin = $_GET['origin'];
}
if (isset($_GET['dest'])) {
    $dest = $_GET['dest'];
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Getting started with the Mapbox Directions API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    />

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
        let start = [0, 0];
        let end = [0, 0];
        document.body.onload = async function () {
            let origin = await fetchData("<?= $origin ?>");
            setTimeout(async () => {
                let destination = await fetchData("<?= $dest ?>");
                loadMap(origin, destination);
            }, 1200);
        }
        async function fetchData(place) {
            try {
                const response = await fetch(`https://geocode.maps.co/search?q=${place}&api_key=688256a9a87c5319687312aco898ceb`);
                const data = await response.json();
                if (data && data.length > 0) {
                    const result = data[0];
                    const coords = [
                        parseFloat(parseFloat(result.lon).toFixed(2)),
                        parseFloat(parseFloat(result.lat).toFixed(2))
                    ];

                    return coords; // ✅ returns coordinates from the whole function
                } else {
                    throw new Error("No data found");
                }
            } catch (err) {
                console.error("ERROR:", err);
                return false; // Or null, depending on how you want to handle errors
            }
        }
        mapboxgl.accessToken = 'pk.eyJ1Ijoia2lzaG1hdCIsImEiOiJjbWRmdGRrZG0waTR6MmpzN3p3Y3dka3F6In0.NPt2BEOcw9nygsafo5VXrA';
        const map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v12', // map style
            center: [85.3240, 27.7172], // starting position
            zoom: 10 // starting zoom
        });
        const bounds = [
            [80.0581, 26.347],  // Southwest
            [88.2015, 30.4469]  // Northeast
        ];
        map.setMaxBounds(bounds);

        function loadMap(origin, destination) {
            start = origin; // Kathmandu
            end = destination; // Everest Base Camp
            console.log(origin, destination);
            getRoute(end);
        }
        // map.on('click', (event) => {
        //     const coords = Object.keys(event.lngLat).map(
        //         (key) => event.lngLat[key]
        //     );
        //     const end = {
        //         'type': 'FeatureCollection',
        //         'features': [
        //             {
        //                 'type': 'Feature',
        //                 'properties': {},
        //                 'geometry': {
        //                     'type': 'Point',
        //                     'coordinates': coords
        //                 }
        //             }
        //         ]
        //     };
        //     getRoute(coords);
        // });


        async function getRoute(end) {
            // make a directions request using cycling profile
            const query = await fetch(
                `https://api.mapbox.com/directions/v5/mapbox/driving-traffic/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`
            );
            const json = await query.json();
            const data = json.routes[0];
            const route = data.geometry;
            const geojson = {
                'type': 'Feature',
                'properties': {},
                'geometry': data.geometry
            };

            if (map.getSource('route')) {
                // if the route already exists on the map, reset it using setData
                map.getSource('route').setData(geojson);
            }

            // otherwise, add a new layer using this data
            else {
                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: geojson
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });
            }
        }
    </script>
</body>

</html>