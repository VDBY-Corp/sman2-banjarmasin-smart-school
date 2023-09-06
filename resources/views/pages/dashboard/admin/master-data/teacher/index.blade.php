@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Guru" :breadcrumbs="[['Master Data'], ['Guru']]" />
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
                    <i class="fas fa-plus mr-1"></i> Tambah Guru
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
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>Email</th>
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
          <h4 class="modal-title">Edit Data Guru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">

              <label for="inputNip" class="col-sm-3 col-form-label">NIP</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" id="inputNip" placeholder="NIP">
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

              <label for="inputEmail" class="col-sm-3 col-form-label mt-2">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control mt-2" id="inputEmail" placeholder="Email">
              </div>

              <label for="inputPassword" class="col-sm-3 col-form-label mt-2">Password</label>
              <div class="col-sm-9">
                <input type="text" class="form-control mt-2" id="inputPassword" placeholder="Password">
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

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_guru.js')
@endpush
