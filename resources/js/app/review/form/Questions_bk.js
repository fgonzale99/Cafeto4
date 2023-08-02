import React, { Component, useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

import FormBuilder from "../../../components/forms/FormBuilder"

class Questions extends React.Component {


  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'cuestionarios'},
      dataForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formNew',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      },
      modalIsOpen: false,
    }

    this.state.dataForm.fbsetup = {
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
         }
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
          label: 'Grupo Predefinido',
          name: 'user-details', // optional - one will be generated from the label if name not supplied
          showHeader: true, // optional - Use the label as the header for this set of inputs
          icon: '📝',
          fields: [
              {
                type: 'header',
                subtype: 'h1',
                label: 'Título',
              },
              {
                type: 'paragraph',
                subtype: 'p',
                label: 'Descripcion',
              },
              {
                type: 'text',
                label: 'Pregunta',
              },
              {
                type: 'number',
                label: 'Calificación',
              },
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
    }],
    i18n: {
      locale: 'es-ES',
      location: '/js/formbuilder/',
      extension: '.lang',
      //override: {
      //    'en-US': {...}
      //}
    }
    };
  }

  render() {

    var item = [];
    const value="";

    item.name = "Página Cuestionario";
    item.label = "Página Cuestionario";
    item.description = "Seleccione los campos que desea incluir en el formulario de evaluación.";

    return (
      <FormBuilder data={ item } fbsetup={ this.state.dataForm.fbsetup } value={ value } />
    )
  }
}
export default Questions;
