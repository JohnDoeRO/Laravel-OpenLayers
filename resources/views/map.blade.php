<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.12.0/css/ol.css" type="text/css">
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.12.0/build/ol.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

    <title>Thovex test</title>
</head>

<body>
    <div id="map" class="map"></div>

    <div class="container">
        <div class="row mt-2">
            <figure class="text-center">
                <blockquote class="blockquote">
                    <p>Click on the map to see latitude and longitude coordinates.</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    The map starts with the latitude of London 51.509865, and the longitude -0.118092.
                </figcaption>
            </figure>
        </div>
        <div class="row">
            <div id="edit">
                <div id="coords" class="text-center"></div>
                <button onclick="saveData()" class="btn btn-success mt-2">Save coordinates</button>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        var lat = ''
        var lon = ''

        var editDiv = document.getElementById("edit");
        editDiv.style.display = "none";
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-0.118092, 51.509865]),
                zoom: 8
            })
        });

        let coords = [
            @foreach ($data as $cor)

                [ {{ $cor->lot }}, {{ $cor->lat }} ],
            @endforeach
        ]
        var features = []
        coords.forEach((cor) => {
            a =
                new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([cor[0], cor[1]])),
                })
            features.push(a)
        })


        var layer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: features
            })
        });
        map.addLayer(layer);

        layer.setStyle(new ol.style.Style({
            image: new ol.style.Icon( /** @type {olx.style.IconOptions} */ ({
                color: '#4271AE',
                crossOrigin: 'anonymous',
                src: 'http://maps.google.com/mapfiles/ms/micons/blue.png'
            }))
        }));


        map.on('click', function(evt) {
            editDiv.style.display = "block";
            editDiv.classList.add("text-center");
            var coords = ol.proj.toLonLat(evt.coordinate);
            lat = coords[1];
            lon = coords[0];
            var locTxt = "Latitude: " + lat + " Longitude: " + lon;
            document.getElementById('coords').innerHTML = locTxt;
        });

        function saveData() {
            let data = {
                latitude: lat,
                longitude: lon
            };
            axios.post("save", data).then(function(response) {
                window.location.reload()
            })

            editDiv.style.display = "none";
        }
    </script>
</body>

</html>
