@extends('adminlte::page')

@section('content')
<div class="row">
  <div class="col-md-10 offset-md-1">
<!-- SELECT2 EXAMPLE -->
       <div class="card card-default">
         <div class="card-header">
           <h3 class="card-title">Formulario de Evaluación</h3>

           <div class="card-tools">
             <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
             <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
           </div>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
           <div class="row">
             <form id="my-form" >
               <div id="form-render-wrap"></div>
              </form>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
             <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
        <!-- /.card -->
    </div>
 </div>

@endsection

@section('js')
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script>
// using jQuery
var test = '[{"type":"header","subtype":"h1","label":"T\u00edtulo"},{"type":"number","required":false,"label":"Valor","className":"form-control","name":"number-1620327203383","min":1,"max":10,"puntaje":"0","ponderacion":"1"}]';
console.log(test);
$('#form-render-wrap').formRender(
    {
      formData: test, // This is data you stored in database when you build the form
      dataType: 'json'
    }
);
</script>
@endsection
