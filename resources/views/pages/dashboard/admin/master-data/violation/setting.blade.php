@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Pengaturan" :breadcrumbs="[['Master Data'], ['Pelanggaran'], ['Pengaturan']]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="card card-info">
        <form class="form-horizontal" method="POST" action="{{ route('dashboard.admin.master.violation-setting.update') }}">
          @csrf
          @method('PUT')
          <div class="card-body">
            @foreach ($settings as $key => $value)
              {{-- if $key not includes word "violation.", continue or break --}}
              @php
                if (!Str::contains($key, 'violation.')) {
                  continue;
                }
              @endphp
              <div class="form-group row">
                <label for="input{{ explode(".", $key)[1] }}" class="col-sm-2 col-form-label">{{ __('app.settings.'.$key) }}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="input{{ explode(".", $key)[1] }}" placeholder="{{ $value }}" value="{{ $value }}" name="{{ $key }}">
                </div>
              </div>
            @endforeach
            <div class="float-right">
              <button type="submit" class="btn btn-info" id="btn-save">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
