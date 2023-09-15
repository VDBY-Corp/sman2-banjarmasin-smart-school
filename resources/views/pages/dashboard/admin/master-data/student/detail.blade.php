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

  {{-- modals --}}
  <div class="modal fade" id="modal" data-json="null">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Siswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">

              <label for="inputNISN" class="col-sm-3 col-form-label">NISN</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" id="inputNISN" placeholder="NISN">
              </div>

              <label for="inputName" class="col-sm-3 col-form-label mt-2">Nama</label>
              <div class="col-sm-9">
              <input type="text" class="form-control mt-2" id="inputName" placeholder="Nama">
              </div>

              <label for="inputGender" class="col-sm-3 col-form-label mt-2">Jenis Kelamin</label>
              <div class="col-sm-9">
                <select class="form-control mt-2" id="inputGender">
                  <option value="" disabled selected>Jenis Kelamin</option>
                  <option value="laki-laki">Laki-Laki</option>
                  <option value="perempuan">Perempuan</option>
                </select>
              </div>


              <label for="inputGrade" class="col-sm-3 col-form-label mt-2">Kelas</label>
              <div class="col-sm-9">
                <select class="form-control mt-2" id="inputGrade">
                  <option value="" disabled selected>Kelas</option>
                  {{-- @foreach ($grades as $grade)
                      <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach --}}
                </select>
              </div>

              <label for="inputGeneration" class="col-sm-3 col-form-label mt-2">Angkatan</label>
              <div class="col-sm-9">
                <select class="form-control mt-2" id="inputGeneration">
                  <option value="" disabled selected>Angkatan</option>
                  {{-- @foreach ($generations as $generation)
                      <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                  @endforeach --}}
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button id="modal-btn-save" type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modalImportExcel" data-json="null">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Excel</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data" action="{{ url()->full() }}?excel">
            @csrf
            <div class="form-group row w-full">
              <label for="inputModalImportExcelFile" class="col-sm-3 col-form-label">File Excel</label>
              <div class="col-sm-9">
                <input type="file" class="form-control w-full" id="inputModalImportExcelFile" placeholder="File Excel" accept=".xls,.xlsx">
              </div>
            </div>
            <button id="modal-btn-save" type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_student_detail.js')
@endpush
