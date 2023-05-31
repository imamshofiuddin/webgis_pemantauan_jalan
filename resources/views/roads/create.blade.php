@extends('layouts.app')

@section('title', 'Create Road')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Create Road</div>
            <form method="POST" action="{{ route('roads.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row my-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">Latitude</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">Longitude</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                            </div>
                        </div>
                    </div>
                    <div id="map"></div>
                    <div class="form-group my-2">
                        <label for="name" class="control-label">Road name</label>
                        <input id="name" type="text" class="form-control" name="place_name" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="address" class="control-label">Road Address</label>
                        <textarea id="address" class="form-control" name="address" rows="1"></textarea>
                    </div>
                    <div class="form-group my-2">
                        <label class="control-label">Road Condition</label><br>
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Rusak parah"> Rusak parah
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Sedang"> Sedang
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Ringan"> Ringan
                            </div>
                        </div>
                    </div>
                    <div class="form-group my-2">
                        <label for="description" class="control-label">Description</label>
                        <textarea id="description" class="form-control" name="description" rows="4"></textarea>
                    </div>
                    <div class="input-group my-2">
                        <label class="input-group-text" for="inputGroupFile01">Photo</label>
                        <input type="file" class="form-control" id="inputGroupFile01" name="photo" accept="image/*" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success" name="submit">Add Road</button>
                    {{-- <a href="{{ route('roads.index') }}" class="btn btn-link">Cancel</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>

<style>
    #map { height: 300px; }
</style>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script>

    window.onload = function() {
        var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
        var map = L.map('map').setView(mapCenter, 100);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);
    }
</script>
@endpush
