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
               min: {
                 label: 'Min',
                 value: 1,
               },
               max: {
                 label: 'Max',
                 value: 10,
               },
               puntaje: {
                  label: 'puntaje',
                  value: '0',
                },
               ponderacion: {
                  label: 'ponderacion',
                  value: '1',
                },
                label: 'Número'
             }
          },

          onSave: function(evt, formData) {
            post('/form/save', {json: formData, _token: "{{ csrf_token() }}" });
            console.log(formData);
          },
          disabledAttrs: ["class", "name", "access"],
          controlOrder: [
           'header',
           'paragraph',
           'text',
           'textarea',
           'number',
           'select',
           'autocomplete',
         ],
         inputSets: [
            {
              label: 'Ejemplo Grupo',
              name: 'user-details', // optional - one will be generated from the label if name not supplied
              showHeader: true, // optional - Use the label as the header for this set of inputs
              fields: [
                  {
                    type: 'text',
                    label: 'First Name',
                    className: 'form-control'
                  },
                  {
                    type: 'select',
                    label: 'Profession',
                    className: 'form-control',
                    values: [
                      {
                        label: 'Street Sweeper',
                        value: 'option-2',
                        selected: false
                      },
                      {
                        label: 'Brain Surgeon',
                        value: 'option-3',
                        selected: false
                      }
                    ]
                  },
                  {
                    type: 'textarea',
                    label: 'Short Bio:',
                    className: 'form-control'
                  }
                ]
            },
         ],
         disabledActionButtons: ['data'],
         actionButtons: [{
            id: 'public',
            className: 'btn btn-success',
            label: 'Publicar',
            type: 'button',
            events: {
            click: function() {

            }
          }
          }]
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
