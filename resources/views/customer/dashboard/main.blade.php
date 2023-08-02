@extends('adminlte::page')
@section('content')

<div id="main-app"></div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection


@section('js')
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
@endsection
