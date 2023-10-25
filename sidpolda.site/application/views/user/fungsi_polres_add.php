    <script>
        $('.custom-file-input').on('change', function() {
            // console.log(this())
            let filename = $(this).val().split('\\').pop();
            console.log(filename);
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        $(document).ready(function() {
            $('.leaflet-container').css({
                "max-width": "100%",
                "max-height": "100%",
                "height": "400px",
                "width": "600px",

            });


            $("#polres_form").submit(function(event) {
                var fileInput = $("#file_image");
                var fileName = fileInput.val();
                var ext = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
                var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

                if ($.inArray(ext, allowedExtensions) === -1) {
                    event.preventDefault(); // Prevent form submission if invalid file format
                    alert("Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.");
                }
            });
        });



        const cities = L.layerGroup();
        <?php foreach ($map as $map) : ?>
            const <?= $map['name'] ?> = L.marker([<?= $map['latitude'] ?>, <?= $map['longitude'] ?>]).bindPopup(
                '<?= $map['nama_polres'] ?>').addTo(cities);
        <?php endforeach; ?>


        const mbAttr =
            'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
        const mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        const streets = L.tileLayer(mbUrl, {
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });

        const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        const map = L.map('maps', {
            center: [-7.797068, 110.370529],
            zoom: 11,
            layers: [osm, cities]
        });
        setTimeout(function() {
            map.invalidateSize()
        }, 800);
        const baseLayers = {
            'OpenStreetMap': osm,
            'Streets': streets
        };

        const overlays = {
            'Cities': cities
        };


        const layerControl = L.control.layers(baseLayers, overlays).addTo(map);
        const crownHill = L.marker([-7.797068, 110.370529]).bindPopup('This is Crown Hill Park.');
        const rubyHill = L.marker([-7.797068, 110.370529]).bindPopup('This is Ruby Hill Park.');
        const parks = L.layerGroup([crownHill, rubyHill]);


        const satellite = L.tileLayer(mbUrl, {
            id: 'mapbox/satellite-v9',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });


        layerControl.addBaseLayer(satellite, 'Satellite');
        layerControl.addOverlay(parks, 'Parks');
        L.control.scale().addTo(map);



        var mapId = document.getElementById('maps');

        function fullScreenView() {
            mapId.requestFullscreen();
        }

        var removeMarkers = function() {
            map.eachLayer(function(layer) {

                if (layer.myTag && layer.myTag === "myGeoJSON") {
                    map.removeLayer(layer)
                }

            });

        }

        $('#kontak').attr("maxlength", "16"); // Increase the maxlength to accommodate the additional characters

        $('#kontak').on('keyup', function() {
            var value = $(this).val();
            $('#kontak').attr("maxlength", "16");
            // Remove any non-numeric characters
            var cleanedValue = value.replace(/[^0-9]/g, '');

            // Check if the cleaned vsalue starts with "08" or "62"
            if (cleanedValue.startsWith("0")) {
                cleanedValue = "0" + cleanedValue.substring(1); // Keep "08" prefix
            } else if (cleanedValue.startsWith("62")) {

                cleanedValue = "62" + cleanedValue.substring(2); // Keep "62" prefix
            } else {
                cleanedValue = ""; // Reset the value if it doesn't start with the desired prefixes
            }

            $(this).val(cleanedValue);
        });



        map.on('click', function(e) {
            var lng = e.latlng.lng;
            var lat = e.latlng.lat;
            console.log(e)
            console.log('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng);
            $('.coordinate').html(`Lat: ${e.latlng.lat} Lng: ${e.latlng.lng}`);
            $('#latitude').val(e.latlng.lat);
            $('#longitude').val(e.latlng.lng);
            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng)

                .then(response => response.json())
                .then(data => {
                    var address = data.display_name;
                    var words = address.split(" ");
                    words.pop();
                    var updatedAddress = words.join(" ");
                    address = updatedAddress.replace(/,\s*$/, ".");

                    $('#alamat').val(address);
                });


        })

        // Search Location
        L.Control.geocoder().addTo(map);
    </script>