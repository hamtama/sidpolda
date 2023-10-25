<script>
    var geomap;
    var nilaiMax;
    var geojson;
    var imgShow = document.getElementById('img_show');
    var infoContainer = document.getElementById("info-container");
    var locationNameElement = document.getElementById("location-name");
    var addressElement = document.getElementById("address");
    var additionalInfoElement = document.getElementById("additional-info");

    var tahun = '2023';
    var bulan = '';
    console.log(tahun);
    $.ajax({
        url: "/user/searchmap",
        type: "POST",
        dataType: 'json',
        data: {
            tahun: tahun,
            bulan: bulan,
        },
        success: function(data) {
            geomap = data.geojson;
            console.log(geomap);
            nilaiMax = data.nilaiMax.max;
            // removeMarkers();
            showsearch();
        }
    });



    $('#tahun, #bulan').change(function() {
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        // console.log(bulan);
        $.ajax({
            url: "/user/searchmap",
            type: "POST",
            dataType: 'json',
            data: {
                tahun: tahun,
                bulan: bulan
            },
            success: function(data) {
                geomap = data.geojson;
                nilaiMax = data.nilaiMax.max;
                removeMarkers();
                showsearch();
            }
        });
    });

    const mbAttr =
        'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
    const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        // attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    });

    const map = L.map('maps', {
        center: [-7.797068, 110.370529],
        zoom: 11,
        layers: [osm],
    });

    const info = L.control();

    info.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

    info.update = function(props) {
        const contents = props ? `<b>${props.region}</b><br />${props.nilai} Kasus` : 'Hover over a state';
        this._div.innerHTML = `<h6>Data Kejahatan Kabupaten DIY</h6>${contents}`;
    };

    info.addTo(map);


    var markersData = [
        <?php foreach ($map as $map) : ?> {
                koordinat: [<?= $map['latitude'] ?>, <?= $map['longitude'] ?>],
                image: "assets/file_upload/<?= $map['gambar'] ?>",
                nama_polres: '<?= $map['nama_polres'] ?>',
                alamat: '<?= $map['alamat'] ?>',
                deskripsi: '<?= $map['deskripsi'] ?>'
            },
        <?php endforeach; ?>
    ];



    // Loop through the markers data and add them to the map
    for (var i = 0; i < markersData.length; i++) {
        var markerData = markersData[i];

        // Create a Leaflet marker
        var marker = L.marker(markerData.koordinat).addTo(map);

        var popupContent = `
                        <div class="card" style="width: 12rem;">

                            <img class="card-img-top-2" src="${markerData.image}" alt="Card image cap" ">
                            <div class="card-body p-0">
                                <strong class ="card-title p-2" style="font-size:10px;">${markerData.nama_polres}</strong>
                                <p class="card-text p-2 m-0" style="font-size:10px;">${markerData.alamat}</p>
                            </div>
                        </div>
            `;

        // Add a popup to the marker with the content string
        marker.bindPopup(popupContent, {
            minWidth: 150
        });

        marker.on("mouseover", function(e) {
            this.openPopup();

        });


        // Add mouseout event to hide marker info div on mouseout
        marker.on("mouseout", function(e) {
            this.closePopup();
        });

        (function(data) {
            // Add click event to show marker information in the side panel
            marker.on('click', function(e) {
                var infoContainer = document.getElementById('info-container');
                var locationNameElement = document.getElementById('location-name');
                var addressElement = document.getElementById('address');
                var additionalInfoElement = document.getElementById('additional-info');

                infoContainer.style.display = 'block';
                imgShow.src = data.image;
                locationNameElement.textContent = data.nama_polres;
                addressElement.textContent = data.alamat;
                additionalInfoElement.textContent = data.deskripsi;
            });
        })(markerData);
    }




    function getColor(d) {
        return d > (nilaiMax / 8) * 7 ? '#800026' :
            d > (nilaiMax / 8) * 6 ? '#BD0026' :
            d > (nilaiMax / 8) * 5 ? '#E31A1C' :
            d > (nilaiMax / 8) * 4 ? '#FC4E2A' :
            d > (nilaiMax / 8) * 3 ? '#FD8D3C' :
            d > (nilaiMax / 8) * 2 ? '#FEB24C' :
            d > (nilaiMax / 8) * 1 ? '#FED976' :
            d == 0 ? '#ffffff' :
            '#FFEDA0';
    }



    function style(feature) {
        return {
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7,
            fillColor: getColor(parseInt(feature.properties.nilai))
        };
    }



    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 3,
            color: '#666',
            fillOpacity: 1
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
        info.update(layer.feature.properties);
    }

    function resetHighlight(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 1,
            color: 'white',
            fillOpacity: 0.8
        });
    }



    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }


    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
        layer.bindPopup("Jumlah Kejahatan " + feature.properties.region + " : " + feature.properties
            .nilai +
            " Kasus").openPopup();
        layer.myTag = "myGeoJSON"
    }




    // map.on("click", function(e) {
    //     infoContainer.style.display = "block";
    //     locationNameElement.textContent = "Clicked Location";
    //     addressElement.textContent =
    //         "Address: " + e.latlng.lat + ", " + e.latlng.lng;
    //     additionalInfoElement.textContent =
    //         "Additional information about the location...";
    // });
    setTimeout(function() {
        map.invalidateSize()
    }, 800);


    const baseLayers = {
        'OpenStreetMap': osm,

    };

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



    map.on('click', function(e) {
        // console.log(e)
        $('.coordinate').html(`Lat: ${e.latlng.lat} Lng: ${e.latlng.lng}`);
    })

    var legend = L.control({
        position: 'bottomleft'
    });

    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'info legend');
        var grades = [0, Math.floor(nilaiMax / 8) * 1, Math.ceil(nilaiMax / 8) * 2, Math.ceil(nilaiMax / 8) * 3, Math.ceil(nilaiMax / 8) * 4, Math.ceil(nilaiMax / 8) * 5, Math.ceil(nilaiMax / 8) * 6, Math.ceil(nilaiMax / 8) * 7];
        var labels = [];

        for (var i = 0; i < grades.length - 1; i++) {
            labels.push(grades[i] + ' - ' + grades[i + 1]);
        }

        // Add label for the last color grade
        labels.push('> ' + grades[grades.length - 1]);

        for (var j = 0; j < labels.length; j++) {
            div.innerHTML += '<div class="legend-item "><div class="small-legend legend-color" style="background:' + getColor(grades[j]) + '"></div>' + labels[j] + '</div>';
        }

        return div;
    };

    function updateLegend() {
        legend.remove();
        legend.addTo(map);
    }


    function showsearch() {
        geojson = L.geoJson(geomap, {
            // remove: remove,
            style: style,
            onEachFeature: onEachFeature,
        }).addTo(map);

        updateLegend();
    }
    $(".close").on("click", function() {
        $("#info-container").hide(1000);
    });
    // Initial legend generation
    // updateLegend();


    // Search Location
    L.Control.geocoder().addTo(map);
</script>