@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Pelanggaran" :breadcrumbs="[['Pelanggaran']]" />
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
                    <i class="fas fa-plus mr-1"></i> Input Pelanggaran
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
                    <th>Nama</th>
                    <th>Pelanggaran</th>
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
          <h4 class="modal-title">Edit Data Kategori</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">
              <label for="inputStudent" class="col-sm-3 col-form-label mt-2">Nama Siswa</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputStudent" placeholder="Nama Siswa"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputViolation" class="col-sm-3 col-form-label mt-2">Pelanggaran</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputViolation" placeholder="Pelanggaran"></select>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('body-js-bottom')
  <!-- Select2 -->
  <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
  @vite('resources/js/pages/dashboard_admin_main_violation.js')
@endpush