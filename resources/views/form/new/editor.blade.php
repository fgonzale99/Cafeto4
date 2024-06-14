@extends('adminlte::page')
@section('content')
<main>
  <div class="row">
    <div class="col-lg-10 col-10 offset-md-1">
      <div class="bs-stepper">
        <div class="bs-stepper-header" role="tablist">
          <div class="step " data-target="#Crear"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="{{route('formreview.new_new',[$form_id])}}" id="Crearlogins-part-trigger"><span class="bs-stepper-circle">&lt;</span><span class="bs-stepper-label">Crear</span></a></div>
          <div class="line"></div>

            <!-- modules -->
          @foreach($formDataDecoded as $key => $module)
          <div class="step {{$key==$module_id ? 'active': ''}}" data-target="#Módulo I"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="/formreview/neweditor/{{$form_id}}/{{$key}}" id="Módulo Ilogins-part-trigger"><span class="bs-stepper-circle">{{$key}}</span><span class="bs-stepper-label">{{$module['pageName']}}</span></a></div>
          <div class="line"></div>
          @endforeach

          <div class="step " data-target="#Publicar"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="{{ route('formreview.publish',[$form_id])}}" id="Publicarlogins-part-trigger"><span class="bs-stepper-circle">&gt;</span><span class="bs-stepper-label">Publicar</span></a></div>
        </div>
      </div>
      <div class="card card-outline card-info undefined">
        <div class="card-header">
          <h3 class="card-title"> Nuevo Módulo Preguntas </h3>
          <div class="card-tools">
            <div class="btn-group"></div>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button><button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>

        </div>
        <div class="card-body">

          <div class="form-group undefined">
            <div><label for="pageName">Nombre del Módulo</label>*<a href="#" id="ttip_pageName" title="Nombre del Módulo" class="fa fa-question-circle" data-toggle="tooltip"></a></div>

            <input name="pageName" type="text" class="form-control input-sm" id="pageName" placeholder="Nombre del Módulo" value="{{$formDataDecoded[$module_id]['pageName']}}">
          </div>


          <div id="fb-editor"></div>

          <form method="POST" autocomplete="off" id="formGuardaModulo" action="{{route('formreview.guardaModulo')}}">
            @csrf
            <div class="form-group undefined">
              <div><label for="pageName">Estado</label>*<a href="#" id="ttip_pageName" title="Estado" class="fa fa-question-circle" data-toggle="tooltip"></a>

              </div>
              <select required name="state" class="form-control input-sm">

                <option value="active" {{(isset($formDataDecoded[$module_id]['state']) && ($formDataDecoded[$module_id]['state']=='active')) ? 'selected' : ''}}>Activo</option>
                <option value="inactive" {{(isset($formDataDecoded[$module_id]['state']) && ($formDataDecoded[$module_id]['state']=='inactive')) ? 'selected' : ''}}>Inactivo</option>
              </select>

            </div>


            <input type="hidden" name="module_name" id="module_name">
            <input type="hidden" name="form_id" value="{{$form_id}}">
            <input type="hidden" name="module_id" value="{{$module_id}}">
            <input type="hidden" name="json" id="json">
        </div>
        <div class="card-footer">
          <input type="submit" value="Guardar" class="btn btn-warning" id="guardaModulo">
          <a href="{{$new_module_id}}" value="Guardar" class="btn btn-info">Nuevo Módulo</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>



@endsection
@section('adminlte_js')
<script>


</script>
<script src="/js/form-builder-new/form-builder.min.js"></script>

<script>
  jQuery(function($) {
    var fbTemplate = document.getElementById('fb-editor'),
      options = {
        typeUserAttrs: {
          textarea: {
            minlength: {
              label: 'Longitud Mínima',
              value: 50,
              type: 'number'
            },
          },
          number: {
            min: {
              label: 'Min',
              value: 1,
            },
            max: {
              label: 'Max',
              value: 10,
            },
            ponderacion: {
              label: 'ponderación',
              value: '1',
            },
            dependencia: {
              label: 'Dependencia',
              value: '',
              placeholder: 'Indique el nombre del componente del que depende',
            },
            condicion: {
              label: 'Condición',
              value: '',
              placeholder: 'Indique el valor que habilita según dependencia  ej: 2 habilita',
            },

            //  label: 'Número'
          },
          text: {
            minlength: {
              label: 'Longitud Mínima',
              value: 0,
              type: 'number'
            },
            dependencia: {
              label: 'Dependencia',
              value: '',
              placeholder: 'Indique el nombre del componente del que depende',
            },
            condicion: {
              label: 'Condición',
              value: '',
              placeholder: 'Indique el valor que habilita según dependencia ej: 2 habilita',
            },
          },
          textarea: {
         
            dependencia: {
              label: 'Dependencia',
              value: '',
              placeholder: 'Indique el nombre del componente del que depende',
            },
            condicion: {
              label: 'Condición',
              value: '',
              placeholder: 'Indique el valor que habilita según dependencia ej: 2 habilita',
            },
          },




        },
        disabledAttrs: ["access"],
        controlOrder: [
          'header',
          'paragraph',
          'text',
          'textarea',
          'number',
          'select',
          'autocomplete',
        ],
        i18n: {
          locale: 'es-ES',
          location: '/js/form-builder-new/'
        },
        disableFields: ['button', 'file', 'hidden', 'data','autocomplete'],
        formData: '{!!  $encodedQuestions !!}',

      };
    var form = $(fbTemplate).formBuilder(options);



    $('#guardaModulo').click(function(e) {
      e.preventDefault();
      $('#json').val(form.actions.getData('json'));

      $('#module_name').val($('#pageName').val());

      $('#formGuardaModulo').submit();

    });



    //deshabilita todos los campos de nombre para edición
    waitForElm('.fld-name').then((elm) => {
      $(".fld-name").attr("disabled", true);
    });


    function waitForElm(selector) {
      return new Promise(resolve => {
        if (document.querySelector(selector)) {
          return resolve(document.querySelector(selector));
        }

        const observer = new MutationObserver(mutations => {
          if (document.querySelector(selector)) {
            resolve(document.querySelector(selector));
            observer.disconnect();
          }
        });

        observer.observe(document.body, {
          childList: true,
          subtree: true
        });
      });
    }

  });
</script>
@endsection