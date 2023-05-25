@extends('layouts.app')

@section('title', 'Report Road')

@section('content')
<div class="container">
    <div class="mb-3">
        <h1 class="page-title"><small>Total : {{ $roads->total() }} Roads</small></h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Road Name</th>
                            <th>Address</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Condition</th>
                            <th>Road Status</th>
                            <th>Photo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roads as $key => $road)
                        <tr>
                            <td class="text-center">{{ $roads->firstItem() + $key }}</td>
                            <td>{!! $road->place_name !!}</td>
                            <td>{{ $road->address }}</td>
                            <td>{{ $road->latitude }}</td>
                            <td>{{ $road->longitude }}</td>
                            <td>{{ $road->condition }}</td>
                            <td>
                                @if ($road->isFixed)
                                    <span class="badge text-bg-success">Fixed</span>
                                @else
                                    <span class="badge text-bg-warning">Unfixed</span>
                                @endif
                            </td>
                            <td><a href="{{ asset("upload/foto_jalan/$road->image") }}">See Photo</a></td>
                            <td class="text-center">
                                <form action="{{ route('roads.confirm', $road) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">{{ $roads->appends(Request::except('page'))->render() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
