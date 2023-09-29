@extends('layouts.app-dashboard', [
  'title' => 'Pengaturan',
])

@section('content-header')
  <x-layout-app-header title="Pengaturan" :breadcrumbs="[['Lainnya'], ['Pengaturan']]" />
@endsection

@section('content')
  <section class="content">
    <div class="container">
      <div class="card card-info">
        <form class="form-horizontal" method="POST" action="{{ route('dashboard.admin.master.setting.update') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="category" value="{{ $category }}">
          <div class="card-body">
            @foreach (Setting::getAll($category) as $key => $value)
              <div class="form-group row">
                <label for="input{{ explode(".", $key)[1] }}" class="col-sm-2 col-form-label">{{ __('app.settings.'.$key) }}</label>
                <div class="col-sm-10">
                  @if (Setting::getType($key) === 'integer')
                    <input
                      type="number"
                      class="form-control"
                      id="input{{ explode(".", $key)[1] }}"
                      placeholder="{{ $value }}"
                      value="{{ $value }}"
                      name="{{ $key }}"
                    >
                  @elseif (Setting::getType($key) === 'options')
                    <select
                      class="form-control select2"
                      id="input{{ explode(".", $key)[1] }}"
                      placeholder="{{ $value }}"
                      value="{{ $value }}"
                      name="{{ $key }}"
                    >
                      @foreach (Setting::getMeta($key)->options as $option)
                        <option value="{{ $option }}" {{ $option === $value ? 'selected' : '' }}>{{ $option }}</option>
                      @endforeach
                    </select>
                  @else
                    <input
                      type="text"
                      class="form-control"
                      id="input{{ explode(".", $key)[1] }}"
                      placeholder="{{ $value }}"
                      value="{{ $value }}"
                      name="{{ $key }}"
                    >
                  @endif
                </div>
              </div>
            @endforeach
            <button type="submit" class="btn btn-info float-right" id="btn-save">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@push('body-js-bottom')
  <script>
    $('.select2').select2({})
  </script>
  {{-- @vite('resources/js/pages/dashboard_admin_masterdata_setting.js') --}}
@endpush
