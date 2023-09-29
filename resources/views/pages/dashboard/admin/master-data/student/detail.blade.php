@extends('layouts.app-dashboard', [
  'title' => 'Data Master » Detail Siswa',
])

@section('content-header')
  <x-layout-app-header title='{{ $student->name }}' :breadcrumbs="[['Master Data'], ['Siswa'], [$student->name]]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-4">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <h3 class="profile-username text-center">{{ $student->name }} | {{ $student->nisn }}</h3>
              <p class="text-muted text-center">{{ $student->grade->name }} | {{ $student->generation->name }} </p>
              <p class="text-muted text-center">{{ $teacher[0]->name }} </p>
              <p class="text-muted text-center">{{ $student->gender }}</p>
              <p class="text-muted text-center">{{ $student->place_birth}}, {{ date('d-m-Y', strtotime($student->date_birth)) }}</p>
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Total Pelanggaran</b> <a class="float-right">{{ $violationData['count'] }}</a>
                </li>
                <li class="list-group-item">
                  <b>Point Pelanggaran</b>
                  <span class="float-right">
                    {{ $violationData['sum'] }}/<a href="{{ route('dashboard.admin.master.violation-setting.index') }}">{{ Setting::get('violation.initial_point') }}</a>
                  </span>
                </li>
                <li class="list-group-item">
                  <b>Total Prestasi</b> <a class="float-right">{{ $achievementData['count'] }}</a>
                </li>
                <li class="list-group-item">
                  <b>Point Prestasi</b> <a class="float-right">{{ $achievementData['sum'] }}</a>
                </li>
                <li class="list-group-item">
                  <b>Total Point</b> <a class="float-right">{{ $totalPoint }}</a>
                </li>
              </ul>
              <a href="?laporan" class="btn btn-primary btn-block" target="_blank">
                Print Laporan
              </a>
            </div>
          </div>
        </div>

        <div class="col-8">
          <div class="card">
            <div class="card-body">
              <div>
                <h2>Pelanggaran</h2>
                <div class="dropdown-divider"></div>
              </div>

              <table class="table table-bordered table-hover w-100 w-full" id="tableViolation">
                <thead>
                  <tr>
                    <th class="dpass">id</th>
                    <th width="5%">#</th>
                    <th>Pelanggaran</th>
                    <th>Point</th>
                    <th>Oleh</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div>
                <h2>Prestasi</h2>
                <div class="dropdown-divider"></div>
              </div>
              <table class="table table-bordered table-hover w-100 w-full" id="tableAchievement">
                <thead>
                  <tr>
                    <th class="dpass">id</th>
                    <th width="5%">#</th>
                    <th>Prestasi</th>
                    <th>Point</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_student_detail.js')
@endpush
