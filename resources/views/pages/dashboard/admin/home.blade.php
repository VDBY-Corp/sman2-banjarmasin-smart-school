@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Dashboard" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
          <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                  <div class="inner">
                      <h3>{{ $student_count }}</h3>
                      <p>Total Siswa</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                  </div>
                  <a href="{{ route('dashboard.admin.master.student.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <!-- ./col -->
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection
