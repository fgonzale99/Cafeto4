@extends('adminlte::master')

<div class="row d-flex align-content-center flex-wrap" style="background-color: rgb(244, 246, 249); height: 100%;">
  <div class="col-md-4 offset-4">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          Validación de Certificación
        </div>
        <div class="card-body">

          Validación de Certificación
          El certificado del QR emitido corresponde a:

          {!! $content !!}

          <b class="text-success">  Estado: VALIDO</b>

          <div class="social-auth-links text-center mt-2 mb-3">
            <a href="http://avanciencia.org" target="_blank" class="text-center">Asociación Colombiana para el Avance de la Ciencia</a>

          </div>
          <!-- /.social-auth-links -->

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>
</div>
