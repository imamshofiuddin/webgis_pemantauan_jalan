@extends('layouts.app')

@section('title', 'Edit Road')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $road)
        @can('delete', $road)
            <div class="card">
                <div class="card-header">Delete</div>
                <div class="card-body">
                    <label class="control-label text-primary">Road Name</label>
                    <p>{{ $road->place_name }}</p>
                    <label class="control-label text-primary">Road Address</label>
                    <p>{{ $road->address }}</p>
                    <label class="control-label text-primary">Latitude</label>
                    <p>{{ $road->latitude }}</p>
                    <label class="control-label text-primary">Longitude</label>
                    <p>{{ $road->longitude }}</p>
                    {!! $errors->first('road_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">Konfirmasi</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('roads.destroy', $road) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="road_id" type="hidden" value="{{ $road->id }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('roads.edit', $road) }}" class="btn btn-link">Cancel</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">Edit Road</div>
            <form method="POST" action="{{ route('roads.update', $road) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">Latitude</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $road->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">Longitude</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $road->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="map"></div>
                    <div class="form-group">
                        <label for="name" class="control-label">Road Name</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('place_name') ? ' is-invalid' : '' }}" name="place_name" value="{{ old('name', $road->place_name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Road Address</label>
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="2">{{ old('address', $road->address) }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group my-2">
                        <label class="control-label">Road Condition</label><br>
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Rusak parah"
                                @if ($road->condition == "Rusak parah")
                                    checked
                                @endif > Rusak parah
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Sedang"
                                @if ($road->condition == "Sedang")
                                    checked
                                @endif> Sedang
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" name="condition" id="condition" value="Ringan"
                                @if ($road->condition == "Ringan")
                                    checked
                                @endif> Ringan
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Deskripsi</label>
                        <textarea id="address" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address', $road->description) }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="input-group my-2">
                        <label class="input-group-text" for="inputGroupFile01">Photo</label>
                        <input type="file" class="form-control" id="inputGroupFile01" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Update" class="btn btn-success">
                    <a href="{{ route('roads.show', $road) }}" class="btn btn-link">Cancel</a>
                    @can('delete', $road)
                        <a href="{{ route('roads.edit', [$road, 'action' => 'delete']) }}" id="del-road-{{ $road->id }}" class="btn btn-danger float-right">Delete</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #map { height: 300px; }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    window.onload = function () {
        var mapCenter = [{{ $road->latitude }}, {{ $road->longitude }}];
        var map = L.map('map').setView(mapCenter, 100);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);
        function updateMarker(lat, lng) {
            marker
            .setLatLng([lat, lng])
            .bindPopup("Your location :  " + marker.getLatLng().toString())
            .openPopup();
            return false;
        };

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude);
        });

        var updateMarkerByInputs = function() {
            return updateMarker( $('#latitude').val() , $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);
    }
</script>
@endpush
