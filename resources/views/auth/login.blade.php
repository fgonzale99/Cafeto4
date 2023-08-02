@extends('layouts.avanciencia')
@section('content')

  <div class="container-fluid bg">
  	<div class="row">
      <img alt="Logo Avanciencia" class="logo-avanciencia" src="/img/avanciencia.png">
  		<div class="col-md-12">
  			<div class="row">
  				<div class="col-md-4">

  					<ul class="nav navbar-nav navbar-login">
  						<li class="nav-item">
  							<a class="nav-link-unisono" href="#"><b>Home</b></a>
  						</li>
  						<li class="nav-item">
  							<a class="nav-link-unisono" href="/pages/about-us"><b>Acerca de</b></a>
  						</li>
              <li class="nav-item">
  							<a class="nav-link-unisono" href="#"><b>Contacto</b></a>
  						</li>
  					</ul>
            <br><br>
  					<h2 style="color:#132e4e">
  					<b>Cafeto</b>
          </h2>
          <h3>
          Valoración por pares
        </h3>
  					<p>
              Es la herramienta tecnológica desarrollada e
              implementada por la Asociación Colombiana para el
              Avance de la Ciencia para la gestión de los procesos de
              evaluación de propuestas por pares. Permite consolidar
              y realizar el proceso de evaluación con eficiencia,
              seguridad y transparencia a través de la conexión del par
              con los documentos a estudiar.</p>
  				  <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group">
                <input id="email" type="email" placeholder="Correo electrónico" class="form-control " name="email" value="" required="" autocomplete="email" autofocus="">
              </div>

              <div class="form-group">
                <input id="password" type="password" placeholder="Contraseña" class="form-control " name="password" required="" autocomplete="current-password">
              </div>

  						<button type="submit" class="btn btn-social">
  							Ingresar
  						</button>
  					</form>
            <br>
            <p class="mb-1">
              <a class="social-link" href="{{ route('password.request') }}">
                  Establecer / Recuperar Contraseña
              </a>
            </p>

  				</div>
  				<div class="col-md-4 text-center  align-self-center">
  					<img alt="Cafeto logo" class="img-fluid logo-cafeto" src="/img/cafeto_logo.jpg">
  				</div>
  				<div class="col-md-4">
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
@endsection
