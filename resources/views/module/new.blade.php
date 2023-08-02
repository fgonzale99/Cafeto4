@extends('adminlte::page')

@section('content')
  <div id="fb-editor"></div>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  <script>
    jQuery(function($) {
      var fbEditor = document.getElementById('fb-editor'),
        options = {
          typeUserAttrs: {
            number: {
               min: {label: 'Min',value: 1,},
               max: {label: 'Max',value: 10,},
               list: {label: 'Listar',value: false,type: 'checkbox',},
               new: {label: 'Crear',value: true,type: 'checkbox',},
               edit: {label: 'Editar',value: true,type: 'checkbox',},
               filter: {label: 'Filtrar',value: false,type: 'checkbox',},
               show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
               order: {label: 'Orden',value: '0',type: 'number',},
             },

             text: {
                 list: {label: 'Listar',value: false,type: 'checkbox',},
                 new: {label: 'Crear',value: true,type: 'checkbox',},
                 edit: {label: 'Editar',value: true,type: 'checkbox',},
                 filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                 show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                 order: {label: 'Orden',value: '0',type: 'number',},
              },

              select: {
                  list: {label: 'Listar',value: false,type: 'checkbox',},
                  new: {label: 'Crear',value: true,type: 'checkbox',},
                  edit: {label: 'Editar',value: true,type: 'checkbox',},
                  filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                  show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                  order: {label: 'Orden',value: '0',type: 'number',},
               },

               "checkbox-group": {
                   list: {label: 'Listar',value: false,type: 'checkbox',},
                   new: {label: 'Crear',value: true,type: 'checkbox',},
                   edit: {label: 'Editar',value: true,type: 'checkbox',},
                   filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                   show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                   order: {label: 'Orden',value: '0',type: 'number',},
                },

                "radio-group": {
                    list: {label: 'Listar',value: false,type: 'checkbox',},
                    new: {label: 'Crear',value: true,type: 'checkbox',},
                    edit: {label: 'Editar',value: true,type: 'checkbox',},
                    filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                    show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                    order: {label: 'Orden',value: '0',type: 'number',},
                 },

                 file: {
                     list: {label: 'Listar',value: false,type: 'checkbox',},
                     new: {label: 'Crear',value: true,type: 'checkbox',},
                     edit: {label: 'Editar',value: true,type: 'checkbox',},
                     filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                     show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                     order: {label: 'Orden',value: '0',type: 'number',},
                  },

                  textarea: {
                      list: {label: 'Listar',value: false,type: 'checkbox',},
                      new: {label: 'Crear',value: true,type: 'checkbox',},
                      edit: {label: 'Editar',value: true,type: 'checkbox',},
                      filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                      show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                      order: {label: 'Orden',value: '0',type: 'number',},
                   },

                   date: {
                       list: {label: 'Listar',value: false,type: 'checkbox',},
                       new: {label: 'Crear',value: true,type: 'checkbox',},
                       edit: {label: 'Editar',value: true,type: 'checkbox',},
                       filter: {label: 'Filtrar',value: false,type: 'checkbox',},
                       show: {label: 'Mostrar en Ficha',value: true,type: 'checkbox',},
                       order: {label: 'Orden',value: '0',type: 'number',},
                    },

          },

          onSave: function(evt, formData) {
            post('/form/save', {json: formData, _token: "{{ csrf_token() }}" });
            console.log(formData);
          },
          disableFields: ['button','hidden','paragraph','header'],
          controlOrder: [
             'text',
             'textarea',
             'number',
             'select',
             'date',
             'autocomplete',
           ],
           controlPosition: 'left',
           editOnAdd: true,
           scrollToFieldOnAdd: true,
        };
      $(fbEditor).formBuilder(options);
    });

    /**
     * sends a request to the specified url from a form. this will change the window location.
     * @param {string} path the path to send the post request to
     * @param {object} params the parameters to add to the url
     * @param {string} [method=post] the method to use on the form
     */

    function post(path, params, method='post') {

      // The rest of this code assumes you are not using a library.
      // It can be made less verbose if you use one.
      const form = document.createElement('form');
      form.method = method;
      form.action = path;

      for (const key in params) {
        if (params.hasOwnProperty(key)) {
          const hiddenField = document.createElement('input');
          hiddenField.type = 'hidden';
          hiddenField.name = key;
          hiddenField.value = params[key];

          form.appendChild(hiddenField);
        }
      }

      document.body.appendChild(form);
      form.submit();
    }

  </script>

@endsection
