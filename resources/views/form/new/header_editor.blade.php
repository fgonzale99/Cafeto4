@extends('adminlte::page')
@section('content')
<div class="row">
   <div class="col-lg-10 col-10 offset-md-1">
      <div class="bs-stepper">
         <div class="bs-stepper-header" role="tablist">
            <div class="step active" data-target="#Crear"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="#" id="Crearlogins-part-trigger"><span class="bs-stepper-circle">&lt;</span><span class="bs-stepper-label">Crear</span></a></div>
            <div class="line"></div>
            <div class="step " data-target="#Definir Preguntas">
              @if($form->id!=null)
              <a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="{{route('formreview.neweditor',[$form->id,1])}}" id="Definir Preguntaslogins-part-trigger">

            <span class="bs-stepper-circle"></span><span class="bs-stepper-label">Definir Preguntas</span></a>

            </div>
            <div class="line"></div>
            <div class="step " data-target="#Publicar"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part"
               href="{{route('formreview.new_publish',[$form->id])}}" id="Publicarlogins-part-trigger"><span class="bs-stepper-circle">&gt;</span><span class="bs-stepper-label">Publicar</span></a></div>
              @endif
         </div>
      </div>
      <div class="card card-outline card-info undefined">
         <div class="card-header">
            <h3 class="card-title"> Editar Cuestionario </h3>
            <div class="card-tools">
               <div class="btn-group"></div>
               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button><button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
         </div>
         <div class="card-body">
            <form role="form" id="guarda_header" action="{{route('formreview.guarda_header')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="form_id" id="form_id" value="{{$form->id}}">
               <div class="form-group undefined">
                  <div><label for="name">Nombre</label>*<a href="#" id="ttip_name" title="Nombre" class="fa fa-question-circle" data-toggle="tooltip"></a></div>
                  <input name="name" type="text" class="form-control input-sm" id="name" placeholder="Nombre" value="{{$form->name}}">
               </div>
               <div class="form-group">
                  <div><label for="description">Descripción</label>*<a href="#" id="ttip_description" title="Descripción" class="fa fa-question-circle" data-toggle="tooltip"></a></div>
                  <textarea name="description" class="form-control" id="description" rows="3" placeholder="Descripción">{{$form->description}}</textarea>
               </div>
               <div class="form-group">
                  <div><label for="instructions">Instrucciones</label>*<a href="#" id="ttip_instructions" title="Instrucciones" class="fa fa-question-circle" data-toggle="tooltip"></a></div>
                  <textarea name="instructions" class="form-control" id="instructions" rows="3" placeholder="Instrucciones">{{$form->instructions}}</textarea>

               </div>
               <div class="d-flex justify-content-center"><button type="submit" class="btn btn-success">Enviar</button></div>
            </form>
         </div>
         <div class="card-footer"></div>
      </div>
   </div>
</div>
@endsection
@section('adminlte_js')
<script>
CKEDITOR.replace( 'instructions',
    {
        toolbar : 'Basic',

    });
</script>
@endsection
