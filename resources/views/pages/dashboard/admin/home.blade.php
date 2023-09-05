@extends('layouts.app-dashboard')

@php
  $widgets_top = [
    [
      'type' => 'small-box',
      'class' => 'bg-info',
      'title' => 'Total Siswa',
      'icon' => 'fas fa-user-graduate',
      'value' => $student_count,
      'link' => route('dashboard.admin.master.student.index'),
    ],
    [
      'type' => 'small-box',
      'class' => 'bg-danger',
      'title' => 'Total Guru',
      'icon' => 'fas fa-chalkboard-teacher',
      'value' => $teacher_count,
      'link' => route('dashboard.admin.master.teacher.index'),
    ],
    [
      'type' => 'small-box',
      'class' => 'bg-warning',
      'title' => 'Total Kelas',
      'icon' => 'fas fa-user-school',
      'value' => $grade_count,
      'link' => route('dashboard.admin.master.grade.index'),
    ],
  ];
@endphp

@section('content-header')
  <x-layout-app-header title="Dashboard" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="row">
        @foreach ($widgets_top as $item)
          <div class="col-lg-3 col-6">
            <div class="small-box {{ $item['class'] }}">
              <div class="inner">
                  <h3>{{ $item['value'] }}</h3>
                  <p>{{ $item['title'] }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-graduate"></i>
              </div>
              {{-- <a href="{{ route('dashboard.admin.master.student.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
              <a href="{{ $item['link'] }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        @endforeach
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection
