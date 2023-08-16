@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Guru" :breadcrumbs="[['Master Data'], ['Siswa']]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
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
@endsection

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_guru.js')
@endpush
