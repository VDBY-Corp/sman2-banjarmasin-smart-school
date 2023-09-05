@extends('layouts.app-dashboard')

@section('content-header')
  <x-layout-app-header title="Setting" :breadcrumbs="[['Lainnya'], ['Setting']]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="card card-info">
        <form class="form-horizontal">
          <div class="card-body">
            @foreach (Setting::getAll() as $key => $value)
                <div class="form-group row">
                  <label for="input{{ explode(".", $key)[1] }}" class="col-sm-2 col-form-label">{{ __('app.settings.'.$key) }}</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="input{{ explode(".", $key)[1] }}" placeholder="{{ $value }}" value="{{ $value }}">
                  </div>
                </div>
            @endforeach
            <button type="button" class="btn btn-info float-right" id="btn-save">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@push('body-js-bottom')
  @vite('resources/js/pages/dashboard_admin_masterdata_setting.js')
@endpush
