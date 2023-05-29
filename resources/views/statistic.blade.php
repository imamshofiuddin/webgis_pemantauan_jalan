@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
    <h1>Total Laporan : {{ $totalReport }}</h1>
    <table cellpadding="10">
        <tr>
            <td><p>Laporan disetujui : {{ $totalReportApprove }}</p></td>
            <td><p>Laporan belum disetujui : {{ $totalWaitingReport }}</p></td>
        </tr>
    </table>
    <div class="row g-4 mb-3">
        <div class="col-lg-6">
            <div id="piechartDataRoadCondition" style="width: 100%; height: 350px;"></div>
        </div>
        <div class="col-lg-6">
            <div id="piechartDataRoadFixed" style="width: 100%; height: 350px;"></div>
        </div>
    </div>
    <br>
    <h2 class="mb-4">Laporan Disetujui</h2>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roadsConfirmed as $key => $road)
                        <tr>
                            <td class="text-center">{{ $roadsConfirmed->firstItem() + $key }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">{{ $roadsConfirmed->appends(Request::except('page'))->render() }}</div>
            </div>
        </div>
    </div>
    <br>
    <h2 class="mb-4">Laporan Belum Disetujui</h2>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roadsNoConfirmed as $key => $road)
                        <tr>
                            <td class="text-center">{{ $roadsNoConfirmed->firstItem() + $key }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">{{ $roadsNoConfirmed->appends(Request::except('page'))->render() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var dataRoadCondition = google.visualization.arrayToDataTable([
      ['Condition', 'jumlah'],
      <?php echo($chartDataRoadCondition); ?>
    ]);

    var optionsRoadCondition = {
      title: 'Statistik kondisi jalanan rusak',
      pieHole: 0.4,
    };

    var dataRoadFixed = google.visualization.arrayToDataTable([
      ['Is Fixed ?', 'jumlah'],
      <?php echo($chartDataRoadFixed); ?>
    ]);

    var optionsRoadFixed = {
      title: 'Statistik jalan diperbaiki',
      pieHole: 0.4,
    };

    var chartchartDataRoadCondition = new google.visualization.PieChart(document.getElementById('piechartDataRoadCondition'));
    var chartchartDataRoadFixed = new google.visualization.PieChart(document.getElementById('piechartDataRoadFixed'));

    chartchartDataRoadCondition.draw(dataRoadCondition, optionsRoadCondition);
    chartchartDataRoadFixed.draw(dataRoadFixed, optionsRoadFixed);
  }
</script>
@endpush
