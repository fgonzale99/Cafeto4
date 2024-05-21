@extends('adminlte::page')

@section('content')
<script src="{{ asset('js/app.js') }}"></script>

	<section class="content">
		<div class="row">

			<div class="col-md-8 offset-md-2">
				@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Error!</strong> Revise los campos obligatorios.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if(Session::has('success'))
				<div class="alert alert-info">
					{{Session::get('success')}}
				</div>
				@endif

				<h2>Editar Proceso</h2>

				<form method="POST" action=""  role="form">
					{{ csrf_field() }}

				<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Ingrese el presupuesto máximo para asignación de evaluaciones</h3>
            <div class="card-tools">
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                   <label for="name">Nombre del proceso</label>
                   <input type="text" readonly name="nombreProceso" value="{{$process->name}}" class="form-control" id="nombreProceso" placeholder="Nombre del Proceso">

                 </div>
				</div>
                <!-- /.form-group -->
				<div class="col-md-3">
                <div class="form-group">
                   <label for="name">Valor presupuesto</label>
                   <input type="currency" required name="descripcion" class="form-control" id="descripcion" placeholder="100000" >
                 </div>
				</div>
                <!-- /.form-group -->




				
                <div class="form-group">
                   <label for="name">Fecha Inicio</label>
                   <input type="text" readonly name="maxBudgetDate" class="form-control" id="maxBudgetDate" value="{{date('Y-m-d')}}" placeholder="Fecha asignación">
                 </div>

                


            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
            </div>
            <div class="card-footer">
						<div class="col-md-4 offset-md-4">
							<input type="submit"  value="Guardar" class="btn btn-success btn-block">
						</div>
					</div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>

	</form>
		</div>

		</div>

	</section>
	@endsection

@section('css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('packages/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.min.css') }}">
<!-- Bootstrap Color Picker -->
 <link rel="stylesheet" href="{{ asset('packages/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
 <link rel="stylesheet" href="{{ asset('packages/fontawesome-iconpicker-master/dist/css/fontawesome-iconpicker.css') }}">

<style>
	/* Always set the map height explicitly to define the size of the div
	 * element that contains the map. */
	#mapa {
		height: 600px;
	}
	/* Optional: Makes the sample page fill the window. */
	html, body {
		height: 100%;
		margin: 0;
		padding: 0;
	}
</style>
@stop

@section('js')


<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('packages/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('packages/fontawesome-iconpicker-master/dist/js/fontawesome-iconpicker.min.js') }}"></script>


<script>
//Initialize Select2 Elements



		$('#fechaInicio').datepicker({
		    autoclose: true,
				format: 'yyyy-mm-dd'
		})

	
</script>
@stop
