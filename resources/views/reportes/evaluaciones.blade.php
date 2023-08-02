@extends('adminlte::page')

@section('css')
  <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css')}}"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.5.3/css/autoFill.dataTables.min.css" />
  <link rel="stylesheet" href="{{asset('css/avanciencia.css')}}">

@stop

@section('content')

  <section class="content-header" style="display: flex;justify-content:space-between">
    <h2 style="font-size: 20px">
      <i class="fa fa-clipboard-check" aria-hidden="true"></i>
      {{ __('menu.reportsAssmt') }}
    </h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('submodulos', 21) }}">Reportes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Evaluaciones</li>
      </ol>
    </nav>
  </section>

  <div class="card">
    <div class="card-body">
      <form id="form-revisiones">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <select class="form-control form-control-sm customersList" name="customer_id" id="customersList">

            </select>
          </div>

          <div class="form-group col-md-6" id="selectProcesses">
            <select class="form-control form-control-sm processesList" name="process_id" id="processesList">

            </select>
          </div>

        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <select class="form-control form-control-sm projectsList" name="project_id" id="projectsList">

            </select>
          </div>
        </div>

        <div class="form-row">

          <div class="form-group col-sm-2 input-group mb-2">
            <div class="input-group-prepend">
              <div class="form-control-sm input-group-text" style="font-size: 12px">Asignado</div>
            </div>
            <input type="date" class="fechaAsignado form-control form-control-sm" name="assignedDate" value="" id="assignedDate">
          </div>

          <div class="form-group col-sm-2 input-group mb-2">
            --
            <input type="date" class="form-control form-control-sm ml-1" name="assignedDateEnd" value="" id="assignedDateEnd">
          </div>

          <div class="form-group col-sm-2 input-group ml-5 mb-2">
            <div class="input-group-prepend">
              <div class="form-control-sm input-group-text" style="font-size: 12px">Evaluado</div>
            </div>
            <input type="date" class="fechaEvaluado form-control form-control-sm" name="reviewDate" value="" id="reviewDate">
          </div>

          <div class="form-group col-sm-2 input-group mb-2">
            --
            <input type="date" class="form-control form-control-sm ml-1" name="reviewDateEnd" value="" id="reviewDateEnd">
          </div>

          <div class="form-group col-md-1">
            <button type="submit" class="btn btn-primary btn-sm mr-1">Consultar</button>
          </div>

          <div class="form-group col-md-1">
            <button type="button" class="btn btn-danger btn-sm btnLimpiar ml-1">Limpiar</button>
          </div>

        </div>

      </form>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
        <div class="col" id="resultados-Consulta">

        </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="textModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body" id="body-textModal">
          ...
        </div>
      </div>
    </div>
  </div>


@endsection

@section('js')
  <!-- JQuery Select2 -->
  <script src="{{ asset('vendor/select2/dist/js/select2.min.js')}}"></script>
  <!-- DataTables con Bootstrap -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <!-- DataTables Buttons -->
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
  <!-- Estilos y configuracion Excel -->
  <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>
  <!-- SweetAlert2 -->
  {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script> --}}
  <script src="{{ asset('js/reportes/evaluaciones.js')}}"></script>
  <script type="text/javascript">
    const URL = "{{ $url}}";
  </script>

@stop
