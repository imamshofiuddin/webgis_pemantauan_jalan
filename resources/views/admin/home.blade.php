@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
<style>
    #map { height: 500px; }
</style>
<script>
    var x = document.getElementById("demo");
    window.onload = getLocation();

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
        // var xhr = new XMLHttpRequest();
        // xhr.open('POST', 'home.blade.php', true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        // xhr.send('latitude=' + position.coords.latitude);
        document.querySelector('.locationForm input[name = "latitude"]').value = position.coords.latitude;
        document.querySelector('.locationForm input[name = "longitude"]').value = position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 100);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        // console.log(position.coords.latitude);
        // console.log(position.coords.longitude);
    //   x.innerHTML = "Latitude: " + position.coords.latitude +
    //   "<br>Longitude: " + position.coords.longitude;
    }

</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __("You are logged in as $role !") }}
                </div>
            </div>
        </div>
    </div>
</div>

<center>
    <br>
    <p>Your coords</p>
    <form class="locationForm" action="">
        <input type="text" name="latitude" value="" disabled>
        <input type="text" name="longitude" value="" disabled>
    </form>
    <br>
    <div id="map"></div>
</center>
<p></p>
@endsection
