@extends('layouts.app-dashboard', [
  'title' => 'Data Master » Siswa',
])

@section('content-header')
  <x-layout-app-header title="Siswa" :breadcrumbs="[['Master Data'], ['Siswa']]" />
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
                    <i class="fas fa-plus mr-1"></i> Tambah Siswa
                  </button>
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <button class="dropdown-item" id="btnModalImportExcel">
                      <i class="fas fa-file-excel mr-1"></i> Impor Excel
                    </button>
                    <a class="dropdown-item" href="{{ asset('assets/files/templates/student.xlsx') }}" target="_blank">
                      <i class="fas fa-file-excel mr-1"></i> Unduh Impor Template
                    </a>
                    {{-- <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a> --}}
                  </div>
                </div>
              </div>
              <table class="table table-bordered table-hover w-100 w-full" id="table">
                <thead>
                  <tr>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th width="15%">...</th>
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
            </div>
            <div class="form-group row">
              <label for="inputName" class="col-sm-3 col-form-label mt-2">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control mt-2" id="inputName" placeholder="Nama">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputGender" class="col-sm-3 col-form-label mt-2">Jenis Kelamin</label>
              <div class="col-sm-9">
                <select class="form-control mt-2" id="inputGender">
                  <option value="" disabled selected>Jenis Kelamin</option>
                  <option value="laki-laki">Laki-Laki</option>
                  <option value="perempuan">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputGrade" class="col-sm-3 col-form-label mt-2">Kelas</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputGrade" placeholder="Kelas"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputGeneration" class="col-sm-3 col-form-label mt-2">Angkatan</label>
              <div class="col-sm-9">
                <select class="form-control select2 mt-2" id="inputGeneration" placeholder="Angkatan"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPlace" class="col-sm-3 col-form-label mt-2">Tempat Lahir</label>
              <div class="col-sm-9">
                <input type="text" class="form-control mt-2" id="inputPlace" placeholder="Tempat Lahir">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputDate" class="col-sm-3 col-form-label">Tanggal Lahir</label>
              <div class="input-group date col-sm-9" id="reservationdatetime" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" id="inputDate">
                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
                <input type="file" name="file" class="form-control w-full" id="inputModalImportExcelFile" placeholder="File Excel" accept=".xls,.xlsx">
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary">Impor File</button>
            </div>
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
  @vite('resources/js/pages/dashboard_admin_masterdata_student.js')
@endpush
