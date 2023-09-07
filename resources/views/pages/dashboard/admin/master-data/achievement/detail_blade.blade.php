@extends('layouts.app-dashboard', [
  'title' => 'Data Master » Detail Prestasi',
])

@php
  $title = 'Detail > ' . $achievement_category->name;
  $breadcrumbs = [
    ['Master Data'],
    ['Prestasi'],
    ['Kategori', route('dashboard.admin.master.achievement-category.index')],
    // truncate the name if too long
    [Str::limit($achievement_category->name, 10)],
  ];
@endphp

@section('content-header')
  <x-layout-app-header :title="$title" :breadcrumbs="$breadcrumbs" />
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
                    <i class="fas fa-plus mr-1"></i> Prestasi Baru
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
                    <th width="10%">Poin</th>
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
          <h4 class="modal-title">Edit Data Kategori</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">
              <label for="inputName" class="col-sm-3 col-form-label mt-2">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control mt-2" id="inputName" placeholder="Nama">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPoint" class="col-sm-3 col-form-label mt-2">Poin</label>
              <div class="col-sm-9">
                <input type="number" class="form-control mt-2" id="inputPoint" placeholder="Poin">
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
  @vite('resources/js/pages/dashboard_admin_masterdata_achievement.js')
@endpush
