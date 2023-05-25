@extends('layouts.app')

@section('title', 'Index Road')

@section('content')
<div class="container">
    <div class="mb-3">
        <h1 class="page-title"><small>Total : {{ $roads->total() }} Roads</small></h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-10">
                                    <input placeholder="Search road" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" value="Search" class="btn btn-secondary">
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('roads.index') }}" class="btn btn-link">Reset</a>
                    </form>
                </div>
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
                            <td class="text-center">
                                <a href="{{ route('roads.show', $road) }}" id="show-road-{{ $road->id }}">Detail</a>
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
