@extends('adminlte::page')

@section('css')
  @livewireStyles
@stop

@section('content')

  <section class="content-header" style="display: flex;justify-content:space-between">
    <h1>
      <i class="fa fa-chart-bar" aria-hidden="true"></i>
      {{ __('menu.reports') }}
    </h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Reportes</li>
      </ol>
    </nav>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        @foreach($submodulos as $submodule)
          @can($submodule->permission)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{ $submodule->color }}">
              <div class="inner">
                <h5 style="font-size:15px"><b>{{ strtoupper($submodule->name) }}</b></h5>
                <span>{{ ucwords($submodule->description) }}</span>
              </div>
              <div class="icon">
              <i class="fa {{ $submodule->icon }}"></i>
              </div>
              <a href="{{ route($submodule->link) }}" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
        @endforeach
      </div>
    </div>
  </section>

@endsection

@section('js')
  @livewireScripts
@stop
