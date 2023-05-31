@extends('layouts.app')

@section('content')
@if(session()->has('message'))
<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil melaporkan!</strong> {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif
    <div class="card">
        <div class="card-body" id="map"></div>
    </div>
@endsection

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
<style>
    body {
        margin: 0px;
        height: 100%;
    }
    #map { height: 500px; }
</style>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var x = document.getElementById("map");
    window.onload = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Lokasi tidak terdeteksi, pastikan GPS sudah nyala!");
        }
    }

    function reverseGeocode(lat, lng) {
        var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=jsonv2`;

        return fetch(url)
            .then(response => response.json())
            .then(data => data.display_name);

    }

    function showPosition(position) {
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude],90);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        // var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var pinRedIcon = L.icon({
            iconUrl: 'images/pin-red.png',
            iconSize: [40,40],
        });
        var pinOrangeIcon = L.icon({
            iconUrl: 'images/pin-orange.png',
            iconSize: [40,40],
        });
        var pinBlueIcon = L.icon({
            iconUrl: 'images/pin-blue.png',
            iconSize: [40,40],
        });
        var pinGreenIcon = L.icon({
            iconUrl: 'images/pin-green.png',
            iconSize: [40,40],
        });
        axios.get('{{ route('api.roads.index') }}')
        .then(function (response) {
            console.log(response.data);
            L.geoJSON(response.data, {
                pointToLayer: function(geoJsonPoint,latlng) {
                    console.log(latlng);
                    if(geoJsonPoint.properties.isFixed){
                        return L.marker(latlng,{icon: pinGreenIcon});
                    } else {
                        if(geoJsonPoint.properties.condition == 'Rusak parah'){
                            return L.marker(latlng,{icon: pinRedIcon});
                        } else if(geoJsonPoint.properties.condition == 'Sedang') {
                            return L.marker(latlng,{icon: pinOrangeIcon});
                        } else {
                            return L.marker(latlng,{icon: pinBlueIcon});
                        }
                    }
                }
            })
            .bindPopup(function (layer) {
                return layer.feature.properties.map_popup_content;
            }).addTo(map);
        })
        .catch(function (error) {
            console.log(error);
        });

            var theMarker;

            map.on('click', function(e) {
                let latitude = e.latlng.lat.toString().substring(0, 15);
                let longitude = e.latlng.lng.toString().substring(0, 15);

                if (theMarker != undefined) {
                    map.removeLayer(theMarker);
                };

                reverseGeocode(latitude, longitude).then(address => {
                    console.log(address);
                });

                var popupContent = "Your location : " + latitude + ", " + longitude + ".";
                popupContent += '<br><a href="{{ route('roads.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new road condition here</a>';

                theMarker = L.marker([latitude, longitude]).addTo(map);
                theMarker.bindPopup(popupContent)
                .openPopup();
            });
    }

</script>
@endpush
