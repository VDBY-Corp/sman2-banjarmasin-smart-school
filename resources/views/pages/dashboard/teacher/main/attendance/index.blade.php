@extends('layouts.app-dashboard', [
  'title' => 'Utama » Presensi',
])

@section('content-header')
  <x-layout-app-header title="Presensi" :breadcrumbs="[['Presensi']]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-end mb-2">
                <div class="btn-group">
                  <button type="button" class="btn btn-default" id="btn-add">
                    <i class="fas fa-plus mr-1"></i> Presensi Baru
                  </button>
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a class="dropdown-item" href="#">
                      <i class="fas fa-file-excel mr-1"></i> Import Excel
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="fas fa-file-excel mr-1"></i> Download Template Excel
                    </a>
                    {{-- <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a> --}}
                  </div>
                </div>
              </div>
              <table class="table table-bordered table-hover w-100 w-full" id="table">
                <thead>
                  <tr>
                    <th class="dpass">id</th>
                    <th width="8%">#</th>
                    <th>Tanggal</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>Oleh</th>
                    <th width="15%">
                      ...
                    </th>
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
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">
              <label for="inputGeneration" class="col-sm-3 col-form-label">Angkatan</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputGeneration" placeholder="Angkatan"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputGrade" class="col-sm-3 col-form-label">Kelas</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputGrade" placeholder="Kelas"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputDate" class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-9">
                <div class="input-group date" id="inputDateWrapper" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#inputDateWrapper" id="inputDate" />
                  <div class="input-group-append" data-target="#inputDateWrapper" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
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
@endsection


@push('body-css-top')
@endpush

@push('body-js-bottom')
  <script>
    ROUTES['MASTER_DATA_STUDENT'] = '{{ route('dashboard.admin.master.student.index') }}'
  </script>
  @vite('resources/js/pages/dashboard_teacher_main_attendance.js')
@endpush
