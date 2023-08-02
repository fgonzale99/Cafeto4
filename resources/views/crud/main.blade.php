@extends('adminlte::page')

@section('content_header')
<div id="content-header"></div>
@endsection

@section('content')
<div id="main-app"></div>
<div id="modal-app"></div>

<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@stop
