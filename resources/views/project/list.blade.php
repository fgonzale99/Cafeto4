@extends('adminlte::page')
@section('content')
<section class="content">
  <div class="container-fluid">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Proyectos</h3>

            <div class="card-tools">
              <div class="btn-group">
                <a href="{{ route('project.new') }}" class="btn btn-info">Crear Proyecto</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="proyectosTable" class="table table-bordred table-striped">
             <thead>
               <th>Id</th>
               <th>Nombre</th>
               <th>Código</th>
               <th>Programa</th>
               <th>Estado</th>
               <th>Accion</th>
             </thead>
             <tbody>
              @if($elements->count())
              @foreach($elements as $element)
              <tr>
                <td>{{$element->id}}</td>
                <td><a href="{{ route('project.show') }}" >{{ $element->nombreProyecto }}</a></td>
                <td>{{$element->codigoProyecto}}</td>
                <td>{{$element->programa}}</td>
                <td>{{$element->estado}}</td>
                <td><a class="btn btn-primary btn-xs" href="" ><span class="glyphicon glyphicon-pencil">Editar</span></a>
                <a class="btn btn-success btn-xs" href="{{ route('project.show') }}" ><span class="glyphicon glyphicon-pencil">Ver</span></a></td>
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

@section('js')
<script>
  $(function () {
    $('#proyectosTable').DataTable();
  });
</script>
@stop
