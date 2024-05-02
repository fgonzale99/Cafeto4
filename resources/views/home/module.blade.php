@extends('adminlte::page')
@section('content')

<section class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inicio</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div id="notification-bubble"></div>
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          @foreach($modules as $module)
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box {{ $module->color }}">
                <div class="inner">
                  <h4><b>{{ strtoupper($module->name) }}</b></h4>

                  <p>{{ strtoupper($module->description) }}</p>
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
          @endforeach
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
