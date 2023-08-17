@extends('layouts.app-dashboard')

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
  <div class="modal fade" id="modal-edit" data-json="null">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Default Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="POST">
            <div class="form-group row">

              <label for="inputNISN" class="col-sm-2 col-form-label">NISN</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="inputNISN" placeholder="NISN">
              </div>

              <label for="inputName" class="col-sm-2 col-form-label mt-2">Name</label>
              <div class="col-sm-10">
              <input type="text" class="form-control mt-2" id="inputName" placeholder="Name">
              </div>

              <label for="inputGender" class="col-sm-2 col-form-label mt-2">Gender</label>
              <div class="col-sm-10">
                <select class="form-control mt-2" id="inputGender">
                  <option value="" disabled selected>Gender</option>
                  <option value="laki-laki">Laki-Laki</option>
                  <option value="perempuan">Perempuan</option>
                </select>
              </div>


              <label for="inputGrade" class="col-sm-2 col-form-label mt-2">Grade</label>
              <div class="col-sm-10">
                <select class="form-control mt-2" id="inputGrade">
                  <option value="" disabled selected>Grade</option>
                  @foreach ($grades as $grade)
                      <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach
                </select>
              </div>

              <label for="inputGeneration" class="col-sm-2 col-form-label mt-2">Generation</label>
              <div class="col-sm-10">
                <select class="form-control mt-2" id="inputGeneration">
                  <option value="" disabled selected>Generation</option>
                  @foreach ($generations as $generation)
                      <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="modal-edit-btn-save" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_student.js')
@endpush
