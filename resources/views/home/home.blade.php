@extends('adminlte::page')

@section('content')

  <section class="content-header" style="display: flex;justify-content:space-between">
    <h1>
      <i class="fa fa-home" aria-hidden="true"></i>
      {{ __('menu.home') }}
    </h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Incio</li>
      </ol>
    </nav>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        @foreach($modules as $module)
          @can($module->permission)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{ $module->color }}">
              <div class="inner">
                <h5 style="font-size:15px"><b>{{ strtoupper($module->name) }}</b></h5>
                <span>{{ ucwords($module->description) }}</span>
              </div>
              <div class="icon">
              <i class="fa {{ $module->icon }}"></i>
              </div>
              @php
                $params = array();
                if($module->params){
                  $params = (array) json_decode($module->params);
                }
              @endphp
              <a href="{{ route($module->link, $params) }}" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
        @endforeach
      </div>
    </div>
  </section>

@endsection
