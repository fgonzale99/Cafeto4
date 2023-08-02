@extends('adminlte::page')
@section('content')
<section class="content">
  <div class="container-fluid">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Procesos</h3>

            <div class="card-tools">
              <div class="btn-group">
              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="proyectosTable" class="table table-bordred table-striped">
             <thead>
               <th>Id</th>
               <th>Nombre</th>
               <th>Descripción</th>
               <th>Fecha de Inicio</th>
               <th>Fecha de Fin</th>
               <th>Accion</th>

             </thead>
             <tbody>
              @if($elements->count())
              @foreach($elements as $element)
              <tr>
                <td>{{$element->id}}</td>
                <td><a href="{{ route('process.show') }}" >{{ $element->nombreProceso }}</a></td>
                <td>{{$element->descripcion}}</td>
                <td>{{$element->fechaInicio}}</td>
                <td>{{$element->fechaTermino}}</td>
                <td><a class="btn btn-success btn-md" href="{{ route('customer.process.show') }}" ><span class="glyphicon glyphicon-pencil">Ver</span></a></td>
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
          <!-- /.card-body -->
          <div class="card-footer">
            {{ $elements->links() }}
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  </div>
</section class="content">

@endsection
