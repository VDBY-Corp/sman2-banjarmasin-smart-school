@extends('layouts.app', [
  'title' => 'Masuk',
])

@push('body-class') login-page @endpush

@section('body')
  <div style="position: absolute;z-index: -1;left: 0; top: 0; width: 100%; height: 100%;">
    <img src="{{ asset('0w9x01600842168.png') }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; filter: contrast(0.5);" />
  </div>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1">{{ Setting::get('school.name') }}</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk untuk memulai sesi anda</p>

        <form action="{{ route('login') }}" method="post">
          @csrf
          @method('POST')
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" id="email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="role">
              <option value="admin">Admin</option>
              <option value="teacher">Guru</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Ingat saya
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
@endsection
