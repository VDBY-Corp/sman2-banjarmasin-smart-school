@php
  $breadcrumbs_defaults = [
    [ 'Dashboard', getDashboardGuardByCurrentRoute() ],
  ];
  $breadcrumbs = @$breadcrumbs ? array_merge($breadcrumbs_defaults, $breadcrumbs) : $breadcrumbs_defaults;
@endphp

<div class="content-header">
  <div class="container">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">{{ $title }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard v1</li> --}}
                  @for ($i = 0; $i < count($breadcrumbs); $i++)
                    <li class="breadcrumb-item {{ $i == count($breadcrumbs) - 1 ? 'active' : '' }}">
                      @if (@$breadcrumbs[$i][1])
                        <a href="{{ @$breadcrumbs[$i][1] }}">
                          {{ $breadcrumbs[$i][0] }}
                        </a>
                      @else
                        {{ $breadcrumbs[$i][0] }}
                      @endif
                    </li>
                  @endfor
              </ol>
          </div><!-- /.col -->
      </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
