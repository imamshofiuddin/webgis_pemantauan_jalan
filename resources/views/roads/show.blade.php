@extends('layouts.app')

@section('title', __('road.detail'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Road Detail</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>Road Name</td><td>{{ $road->place_name }}</td></tr>
                        <tr><td>Road Address</td><td>{{ $road->address }}</td></tr>
                        <tr><td>Condition</td><td>{{ $road->condition }}</td></tr>
                        <tr><td>Description</td><td>{{ $road->description }}</td></tr>
                        <tr><td>Latitude</td><td>{{ $road->latitude }}</td></tr>
                        <tr><td>Longitude</td><td>{{ $road->longitude }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $road)
                    <a href="{{ route('roads.edit', $road) }}" id="edit-road-{{ $road->id }}" class="btn btn-warning">Edit Road</a>
                @endcan
                @if(auth()->check())
                    <a href="{{ route('roads.index') }}" class="btn btn-link">Road Index</a>
                @else
                    <a href="{{ route('road_map.index') }}" class="btn btn-link">Road Map</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('road.location') }}</div>
            @if ($road->coordinate)
            <div class="card-body" id="map"></div>
            @else
            <div class="card-body">{{ __('road.no_coordinate') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>

<style>
    #map { height: 400px; }
</style>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    window.onload = function() {
        var map = L.map('map').setView([{{ $road->latitude }}, {{ $road->longitude }}], 100);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([{{ $road->latitude }}, {{ $road->longitude }}]).addTo(map)
            .bindPopup('{!! $road->map_popup_content !!}');
    }
</script>
@endpush
