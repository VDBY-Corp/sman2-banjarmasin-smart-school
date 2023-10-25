@extends('layouts.app-dashboard', [
  'title' => 'Dashboard',
])

@php
  $widgets_top = [
    [
      'type' => 'small-box',
      'class' => 'bg-info',
      'title' => 'Total Siswa',
      'icon' => 'fas fa-user-graduate',
      'value' => $student_count,
      'link' => route('dashboard.admin.master.student.index'),
    ],
    [
      'type' => 'small-box',
      'class' => 'bg-danger',
      'title' => 'Total Guru',
      'icon' => 'fas fa-chalkboard-teacher',
      'value' => $teacher_count,
      'link' => route('dashboard.admin.master.teacher.index'),
    ],
    [
      'type' => 'small-box',
      'class' => 'bg-warning',
      'title' => 'Total Kelas',
      'icon' => 'fas fa-user-school',
      'value' => $grade_count,
      'link' => route('dashboard.admin.master.grade.index'),
    ],
    [
      'type' => 'small-box',
      'class' => 'bg-success',
      'title' => 'Total Pelanggaran',
      'icon' => 'fas fa-user-school',
      'value' => $violation_count,
      'link' => route('dashboard.admin.main.violation.index'),
    ],
  ];
@endphp

@section('content-header')
  <x-layout-app-header title="Dashboard" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
        @foreach ($widgets_top as $item)
          <div class="col-lg-3 col-6">
            <div class="small-box {{ $item['class'] }}">
              <div class="inner">
                  <h3>{{ $item['value'] }}</h3>
                  <p>{{ $item['title'] }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-graduate"></i>
              </div>
              {{-- <a href="{{ route('dashboard.admin.master.student.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
              <a href="{{ $item['link'] }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Top 5 Siswa Melanggar</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0 w-full">
              <div class="table-responsive w-full">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kelas/Angkatan</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($top5_violation as $item)
                      <tr>
                        <td><a href="{{ route('dashboard.admin.master.student.show', [@$item->student->id]) }}">{{ @$item->student->name }}</a></td>
                        <td>{{ @$item->student->grade->name }}/{{ @$item->student->generation->name }}</td>
                        <td><span class="badge badge-danger">{{ @$item->violation_count }} Pelanggaran</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Top 5 Siswa Berprestasi</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0 w-full">
              <div class="table-responsive w-full">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kelas/Angkatan</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($top5_achievement as $item)
                      <tr>
                        <td><a href="{{ route('dashboard.admin.master.student.show', [@$item->student->id]) }}">{{ @$item->student->name }}</a></td>
                        <td>{{ @$item->student->grade->name }}/{{ @$item->student->generation->name }}</td>
                        <td><span class="badge badge-success">{{ @$item->achievement_count }} Prestasi</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="card bg-gradient-info">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Perkembangan
              </h3>
              <div class="card-tools">
                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@push('body-js-bottom')
  <script>
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    var salesGraphChartData = {
      labels:  {!! json_encode($chart_violation->labels) !!},//['2011 Q1','2011 Q2','2011 Q3','2011 Q4','2012 Q1','2012 Q2','2012 Q3','2012 Q4','2013 Q1','2013 Q2'],
      datasets:[
        {
          label: 'Total Pelanggaran',
          data: {!! json_encode($chart_violation->data) !!},
          fill:false,
          borderWidth:2,
          lineTension:0,
          spanGaps:true,
          borderColor:'red',
          pointRadius:3,
          pointHoverRadius:7,
          pointColor:'red',
          pointBackgroundColor:'red',
        },
        {
          label: 'Total Prestasi',
          data: {!! json_encode($chart_achievement->data) !!},
          fill:false,
          borderWidth:2,
          lineTension:0,
          spanGaps:true,
          borderColor:'#efefef',
          pointRadius:3,
          pointHoverRadius:7,
          pointColor:'#efefef',
          pointBackgroundColor:'#efefef',
        }
      ]
    }
    var salesGraphChartOptions = {maintainAspectRatio:false,responsive:true,legend:{display:true,color: 'black'},scales:{xAxes:[{ticks:{fontColor:'#efefef'},gridLines:{display:false,color:'#efefef',drawBorder:false}}],yAxes:[{ticks:{stepSize:5000,fontColor:'#efefef'},gridLines:{display:true,color:'#efefef',drawBorder:false}}]}}
    var salesGraphChart = new Chart(salesGraphChartCanvas,{type:'line',data:salesGraphChartData,options:salesGraphChartOptions})
  </script>
@endpush
