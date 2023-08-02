@extends('adminlte::page')

@section('content_header')
    <h1>Ficha del Proceso</h1>
@stop

@section('content')

<div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">

              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Nombre:</strong> {{ $element->nombreProceso }}<br>
                    <strong>Descripción:</strong> {{ $element->descripcion }}<br>
                    <strong>Fecha de Inicio:</strong> {{ $element->fechaInicio }}<br>
                    <strong>Fecha de Fin:</strong> {{ $element->fechaInicio }}<br>
                  </address>
                </div>
                <!-- /.col -->

              </div>
              <!-- /.row -->

              <div class="row">
                <div class="col-10">
                  <h4>
                    <i class="fas fa-list"></i> Lista de Proyectos
                  </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">
                  <div class="btn-group">
                    <a href="{{ route('project.new') }}" class="btn btn-info">Crear Proyecto</a>
                  </div>
                </div>
              </div>
              <!-- Table row -->
              <div class="row">

                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Código</th>
                      <th>Programa</th>
                      <th>Estado</th>
                      <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($projects->count())
                      @foreach($projects as $element)
                      <tr>
                        <td>{{$element->id}}</td>
                          <td><a href="{{ route('project.show') }}" >{{ $element->nombreProyecto }}</a></td>
                          <td>{{$element->codigoProyecto}}</td>
                          <td>{{$element->programa}}</td>
                          <td>{{$element->estado}}</td>
                        <td><a class="btn btn-success btn-xs" href="{{ route('project.show') }}" ><span class="glyphicon glyphicon-pencil">Ver</span></a></td>
                       </tr>
                       @endforeach
                       @else
                        <tr>
                          <td colspan="8">No hay registro !!</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>

@endsection
