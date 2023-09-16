@extends('layouts.app-dashboard', [
  'title' => 'Utama » Presensi » Data',
])

@php
  $summary = $attendance->grade->name . ' - ' . $attendance->date->format('d M Y');
  $title = 'Data > ' . $summary;
  $breadcrumbs = [
    ['Utama'],
    ['Presensi', route('dashboard.teacher.main.attendance.index')],
    // truncate the name if too long
    [$summary],
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
              </div>
              <form method="POST">
                @csrf
                <table class="table table-bordered table-hover w-100 w-full" id="table">
                  <thead>
                    <tr>
                      {{-- <th class="dpass">id</th> --}}
                      <th width="6%">#</th>
                      <th width="40%">Siswa</th>
                      <th width="16%">Status</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <input type="hidden" name="student[]" value="{{ $item->student->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->student->name }}</td>
                        <td>
                          <select class="form-control" name="status[]">
                            <option value="" {{ $item->status == null ? 'selected' : '' }}>Belum diset</option>
                            @foreach ($statuses as $status)
                              <option value="{{ $status }}" {{ $item->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <textarea class="form-control" name="description[]" rows="1">{{ $item->description }}</textarea>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="d-flex justify-content-end mt-2">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


@push('body-css-top')
@endpush

@push('body-js-bottom')
  {{-- @vite('resources/js/pages/dashboard_teacher_main_attendance.js') --}}
@endpush
