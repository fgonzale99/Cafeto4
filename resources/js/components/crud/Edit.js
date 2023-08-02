import React, { useEffect, useState, useRef  } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Form from "../../components/forms/Form"
import Button from "../../components/general/Button"
import Header from "../../components/general/Header"

class Edit extends React.Component {

  constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        error: '',
        moduleData: {name: this.props.match.params.module, id: this.props.match.params.id},
        dataForm: {
          action: '',
          method: 'POST',
          enctype: 'multipart/form-data',
          id: 'formEdit',
          formRef: React.createRef(),
          fields: [],
          formValues: [],
        },
        modalIsOpen: false,
      }

      this.state.dataForm.fbsetup = {
        typeUserAttrs: {
          number: {
             min: { label: 'Min', value: 1,},
             max: { label: 'Max', value: 10,},
             list: { label: 'Listar', value: false, type: 'checkbox',},
             new: { label: 'Crear', value: true, type: 'checkbox',},
             edit: { label: 'Editar', value: true, type: 'checkbox',},
             filter: { label: 'Filtrar', value: false, type: 'checkbox',},
             show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
             order: { label: 'Orden', value: '0', type: 'number',},
             subtype: { label: 'Subtipo', type: 'select', options: {
                   'number': 'number',
                   'money': 'money',
                   'progress': 'progress',
                   'percent': 'percent'
               },
             },
           },

           text: {
               minlength: { label: 'Longitud Mínima', value: '20', type: 'number',},
               list: { label: 'Listar', value: false, type: 'checkbox',},
               new: { label: 'Crear', value: true, type: 'checkbox',},
               edit: { label: 'Editar', value: true, type: 'checkbox',},
               filter: { label: 'Filtrar', value: false, type: 'checkbox',},
               show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
               order: { label: 'Orden', value: '0', type: 'number',},
            },

            select: {
                list: { label: 'Listar', value: false, type: 'checkbox',},
                new: { label: 'Crear', value: true, type: 'checkbox',},
                edit: { label: 'Editar', value: true, type: 'checkbox',},
                filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                order: { label: 'Orden', value: '0', type: 'number',},
                origin: { label: 'Origen', type: 'select', options: {
                    'model': 'model',
                    'enum': 'enum',
                    'manual': 'manual',
                    'function': 'function'
                  },
                },
                modelOrigin: { label: 'Modelo', type: 'text', value: ''},
                fieldOrigin: { label: 'Campo', type: 'text', value: ''},
                alias: { label: 'Alias', type: 'text', value: ''},
             },

             "checkbox-group": {
                 list: { label: 'Listar', value: false, type: 'checkbox',},
                 new: { label: 'Crear', value: true, type: 'checkbox',},
                 edit: { label: 'Editar', value: true, type: 'checkbox',},
                 filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                 show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                 order: { label: 'Orden', value: '0', type: 'number',},
                 origin: { label: 'Origen', type: 'select', options: {
                       'model': 'model',
                       'enum': 'enum',
                       'manual': 'manual',
                       'function': 'function',
                   },
                 },
                 modelOrigin: { label: 'Modelo', type: 'text', value: ''},
                 fieldOrigin: { label: 'Campo', type: 'text', value: ''},
                 alias: { label: 'Alias', type: 'text', value: ''},
              },

              "radio-group": {
                  list: { label: 'Listar', value: false, type: 'checkbox',},
                  new: { label: 'Crear', value: true, type: 'checkbox',},
                  edit: { label: 'Editar', value: true, type: 'checkbox',},
                  filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                  show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                  order: { label: 'Orden', value: '0', type: 'number',},
                  origin: { label: 'Origen', type: 'select', options: {
                        'model': 'model',
                        'enum': 'enum',
                        'manual': 'manual',
                        'function': 'function',
                    },
                  },
                  modelOrigin: { label: 'Modelo', type: 'text', value: ''},
                  fieldOrigin: { label: 'Campo', type: 'text', value: ''},
                  alias: { label: 'Alias', type: 'text', value: ''},
               },

               file: {
                   list: { label: 'Listar', value: false, type: 'checkbox',},
                   new: { label: 'Crear', value: true, type: 'checkbox',},
                   edit: { label: 'Editar', value: true, type: 'checkbox',},
                   filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                   show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                   order: { label: 'Orden', value: '0', type: 'number',},
                   path: { label: 'Ruta', value: '', type: 'text',},
                },

                textarea: {
                    minlength: { label: 'Longitud Mínima', value: '20', type: 'number',},
                    list: { label: 'Listar', value: false, type: 'checkbox',},
                    new: { label: 'Crear', value: true, type: 'checkbox',},
                    edit: { label: 'Editar', value: true, type: 'checkbox',},
                    filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                    show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                    order: { label: 'Orden', value: '0', type: 'number',},
                 },

                 date: {
                     list: { label: 'Listar', value: false, type: 'checkbox',},
                     new: { label: 'Crear', value: true, type: 'checkbox',},
                     edit: { label: 'Editar', value: true, type: 'checkbox',},
                     filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                     show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                     order: { label: 'Orden', value: '0', type: 'number',},
                  },
                  paragraph: {
                        list: { label: 'Listar', value: false, type: 'checkbox',},
                        new: { label: 'Crear', value: true, type: 'checkbox',},
                        edit: { label: 'Editar', value: true, type: 'checkbox',},
                        filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                        show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                        order: { label: 'Orden', value: '0', type: 'number',},
                     },
                   header: {
                          list: { label: 'Listar', value: false, type: 'checkbox',},
                          new: { label: 'Crear', value: true, type: 'checkbox',},
                          edit: { label: 'Editar', value: true, type: 'checkbox',},
                          filter: { label: 'Filtrar', value: false, type: 'checkbox',},
                          show: { label: 'Mostrar en Ficha', value: true, type: 'checkbox',},
                          order: { label: 'Orden', value: '0', type: 'number',},
                       },

        },
        disableFields: ['button','hidden'],
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
         disabledActionButtons: ['save'],
         i18n: {
           locale: 'es-ES',
           location: '/js/formbuilder/',
           extension: '.lang',
           //override: {
           //    'en-US': {...}
           //}
         },
         fields : [{
            label: 'Firma',
            attrs: {
              type: 'textarea'
            },
            icon: '🖋'
          }],
          subtypes: {
             text: ['url']
          }
         /*onAddField: function(fieldId) {
           callApi.call();
          },
         onAddOption: (optionTemplate, optionIndex) => {
           callApi.call();
         },
         onAddOption: (optionTemplate, optionIndex) => {
           callApi.call();
         },
         onClearAll: function(formData) {
           callApi.call();
         },
         onCloseFieldEdit: function(editPanel) {
           callApi.call();
         },
         onOpenFieldEdit: function(editPanel) {
           callApi.call();
         },*/
      };

    }

    async componentDidMount(){
      try{
          const moduleData = await crudServices.getModule(this.state.moduleData);

          if(moduleData.success == true){
            this.state.moduleData.model = moduleData.data.model;
            const res = await crudServices.get(this.state.moduleData);

            this.state.moduleData.fields = moduleData.data.fields.filter(e => e.edit === true);
            this.state.moduleData.values = res.data;
            this.state.moduleData.actions = moduleData.data.actions;
            this.state.moduleData.props = moduleData.data.props;
            this.state.moduleData.name = this.props.match.params.module;

            if(res.success == true){
              this.setState({ isLoading: false });
            }
          }
      }
      catch (error){
            this.state.isLoading = false;
            this.state.error = error;
      }
    }

    async saveEdit(e) {
      e.preventDefault()
        const form = document.getElementById("formEdit");
        const data = new FormData(form);
        const res = await crudServices.update(data, this.state.moduleData);

        if (res.success) {
          var redirect = '/crud/'+ this.state.moduleData.name +'/list?message=updated';
          window.location.href = redirect;
        }
        else {
          alert(res.message)
        }
    }

    onCloseModal(e){
      this.setState({ modalIsOpen: false});
    }

    onOpenModal(e) {
      this.setState({ modalIsOpen: true});
    }

    render() {

      var header = [];
      var content = [];

      if (this.state.isLoading) {
        return <div className="App">Cargando...</div>;
      }

      const breadData = [
        {
          label: 'Inicio',
          active: '',
          link: '/',
        },
        {
          label: this.state.moduleData.props.label.plural,
          active: '',
          link: '/crud/' +  this.state.moduleData.name + '/list',
        },
        {
          label: 'Editar',
          active: 'active',
          link: '#',
        }
      ];

      const headerContent = {
        title: this.state.moduleData.props.label.plural,
        breadcrumb: breadData,
      };

      const headerElement = <Header data={ headerContent }/>;
      header.push(headerElement);

      this.state.dataForm.fields = this.state.moduleData.fields;
      this.state.dataForm.formValues = this.state.moduleData.values;

      const form = <Form data={ this.state.dataForm } onSubmit={ this.saveEdit.bind(this) } />;

      const footer = "";

      this.data = {
        header: {
          title: "Editar " + this.state.moduleData.props.label.singular,
        },
        body: form,
        footer: footer,
      };

      const card = <Card data={ this.data } />

      const columnData = {
          class: 'col-lg-8 col-8 offset-md-2',
          content: card,
        };

      const column = <Column data={ columnData } />
      content.push(column);

      return (
        <>
          <Row content={ header }/>
          <Row content={ content }/>
        </>
      )
    }
}

export default Edit;
