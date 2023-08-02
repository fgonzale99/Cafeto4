@extends('adminlte::page')
@section('content')

<div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Ficha del Proyecto
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Nombre:</strong> {{ $element->nombreProyecto }}<br>
                    <strong>Código:</strong> {{ $element->codigoProyecto }}<br>
                    <strong>Programa:</strong> {{ $element->programa }}<br>
                  </address>
                </div>
                <!-- /.col -->

              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-10">
                  <h4>
                    <i class="fas fa-list"></i> Formularios
                  </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">
                  <div class="btn-group">
                    <a href="{{ route('form.new') }}" class="btn btn-info">Crear Formulario</a>
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
                      <th>Fecha</th>
                      <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($forms->count())
                      @foreach($forms as $elementList)
                      <tr>
                        <td>{{ $elementList->id }}</td>
                          <td><a href="{{ route('form.show') }}" >{{ $elementList->descripcion }}</a></td>
                          <td>{{ $elementList->created_at }}</td>
                          <td><a class="btn btn-success btn-xs" href="{{ route('form.show') }}" ><span class="fa fa-eye"> Ver</span></a></td>
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
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-list"></i> Unidades de Evaluación
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- Table row -->
              <div class="row">

                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Fecha Asignación</th>
                      <th>Fecha Evaluación</th>
                      <th>Estado</th>
                      <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($units->count())
                      @foreach($units as $elementList)
                      <tr>
                        <td>{{ $elementList->id }}</td>
                          <td><a href="{{ route('project.show') }}" >{{ $elementList->reviewer->name }}</a></td>
                          <td>{{ $elementList->fechaAsignacion }}</td>
                          <td>{{ $elementList->fechaEvaluacion }}</td>
                          <td>{{ $elementList->estado }}</td>
                        <td><a class="btn btn-success btn-xs" href="{{ route('review.cronology') }}" ><span class="fa fa-history"> Cronología</span></a></td>
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
