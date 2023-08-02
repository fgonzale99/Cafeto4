@extends('adminlte::page')
@section('content')

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

				<h2>Nuevo Proceso</h2>

				<form method="POST" action="{{ route('process.store') }}"  role="form">
					{{ csrf_field() }}

				<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Información Básica</h3>
            <div class="card-tools">
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                   <label for="name">Nombre del proceso</label>
                   <input type="text" name="nombreProceso" class="form-control" id="nombreProceso" placeholder="Nombre del Proceso">
                 </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="name">Descripción</label>
                   <input type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Descripción">
                 </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="name">Fecha Inicio</label>
                   <input type="text" name="fechaInicio" class="form-control" id="fechaInicio" placeholder="Fecha Inicio">
                 </div>

                 <div class="form-group">
                    <label for="name">Fecha Término</label>
                    <input type="text" name="fechaTermino" class="form-control" id="fechaTermino" placeholder="Fecha Termino">
                  </div>

                  <div class="form-group">
                     <label for="name">Cliente</label>
                     <select class="form-control select2" name="institucion" id="institucion" style="width: 100%;">
                     @foreach ($enums['customer'] as $customer)
                       <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                     <label for="name">Responsable</label>
                     <select class="form-control select2" name="responsable" id="responsable" style="width: 100%;">
                     @foreach ($enums['users'] as $user)
                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPDOMPakqqPqNCy5FZtG6E-2qjH4NF_bQ&callback=initMap"
async defer></script>

<script>
	 // This example creates a simple polygon representing the Bermuda Triangle.
		// When the user clicks on the polygon an info window opens, showing
		// information about the polygon's coordinates.

		var map;
		var infoWindow;

		function initMap() {
			map = new google.maps.Map(document.getElementById('mapa'), {
				zoom: 5,
				center: {lat: 4.886, lng: -74.268},
				mapTypeId: 'terrain'
			});

		}

				$( "#departamento" ).change(function() {
          var multipleDepartamentos = $( "#departamento" ).val() || [];
          for (i = 0; i < multipleDepartamentos.length; i++) {
              map.data.loadGeoJson('/territorio/departamentosjson/' + multipleDepartamentos[i]);
          }
        });

				$( "#municipio" ).change(function() {
		       var multipleMunicipios = $( "#municipio" ).val() || [];
		       for (i = 0; i < multipleMunicipios.length; i++) {
		          map.data.loadGeoJson('/territorio/municipiosjson/' + multipleMunicipios[i]);
		       }
		    });
</script>

<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('packages/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('packages/fontawesome-iconpicker-master/dist/js/fontawesome-iconpicker.min.js') }}"></script>


<script>
//Initialize Select2 Elements

		$('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

		$('#fechaInicio').datepicker({
		    autoclose: true,
				format: 'yyyy-mm-dd'
		})

		$('#fechaTermino').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		})

</script>
@stop
