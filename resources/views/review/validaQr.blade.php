@extends('adminlte::page')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
				<h2>
					Bienvenido a Cafeto Avanciencia
				</h2>
				<p>
					El enlace sumistrado por el código QR es {{ $validezQr }}
				</p>
				<p>
					<a class="btn btn-primary btn-large" href="https://avanciencia.org">Ir Avanciencia</a>
				</p>
			</div>
			<div class="row">
				<div class="col-md-4">
                <img src="data:image/svg;base64,{{$imagenFirma}}" widht="80" height="80"/>
				</div>
				<div class="col-md-8">
                    <p>Evaluador(a): {{  $reviewerName }}</p>
                    <p>Fecha de firma: {{  $fechaFirma }}</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
