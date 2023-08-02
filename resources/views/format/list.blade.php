@extends('adminlte::page')
@section('content')
<section class="content">
  <div class="container-fluid">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Formatos</h3>

            <div class="card-tools">
              <div class="btn-group">
                <a href="{{ route('form.new') }}" class="btn btn-info">Crear Formato</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="proyectosTable" class="table table-bordred table-striped">
             <thead>
               <th>Id</th>
               <th>Descripción</th>
               <th>Clase</th>
               <th>Accion</th>

             </thead>
             <tbody>
              @if($elements->count())
              @foreach($elements as $element)
              <tr>
                <td>{{$element->id}}</td>
                <td><a href="" >{{$element->descripcion}}</a></td>
                <td>{{$element->clase}}</td>
                <td><a class="btn btn-primary btn-xs" href="" ><span class="glyphicon glyphicon-pencil">Editar</span></a>
                <a class="btn btn-success btn-xs" href="{{ route('format.show') }}" ><span class="glyphicon glyphicon-pencil">Ver</span></a></td>
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
