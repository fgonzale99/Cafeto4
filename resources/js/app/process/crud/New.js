import React, { useEffect, useState, useRef  } from 'react';

import customerServices from "../services/Process"
import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Form from "../../../components/forms/Form"
import Button from "../../../components/general/Button"

class New extends React.Component {

  constructor(props) {
    super(props);

    const saveCustomer = async e => {
      e.preventDefault()

        const form = document.getElementById("customerCreate");
        const data = new FormData(form);
        const res = await customerServices.save(data);

        if (res.success) {
          alert(res.message)
        }
        else {
          alert(res.message)
        }
    }

    const dataForm = {
      action: '',
      method: 'POST',
      enctype: 'multipart/form-data',
      id: 'customerCreate',
      formRef: React.createRef(),
      inputs: [
        { type: 'text', name: 'nombreProceso', label: 'Nombre del Proceso', placeholder: 'Nombre del Proceso', value: '', tooltip: 'Nombre del Proceso' },
        { type: 'text', name: 'descripcion', label: 'Documento', placeholder: '', value: '', tooltip: 'Documento del cliente'  },
        { type: 'date', name: 'fechaInicio', label: 'Fecha de Inicio', placeholder: '', value: '', tooltip: 'Tipo de documento del cliente' },
        { type: 'date', name: 'fechaTermino', label: 'Fecha de Terminación', placeholder: '', value: '', tooltip: 'Descripción' },
        { type: 'select', name: 'institucion', label: 'Cliente', placeholder: 'Nombre del contacto', value: '', tooltip: 'Nombre del contacto', options: [{ name: 'CC', value: 'CC' }, { name: 'CE', value: 'CE' }, { name: 'NIT', value: 'NIT' }] },
        { type: 'select', name: 'responsable', label: 'Responsable', placeholder: 'Correo del contacto', value: '', tooltip: 'Correo del contacto', options: [{ name: 'CC', value: 'CC' }, { name: 'CE', value: 'CE' }, { name: 'NIT', value: 'NIT' }] },
      ],
    };

    const form = <Form data={ dataForm } />;

    const footer = <Button data={ dataForm } onClick={ saveCustomer } type="submit" />;

    const data = {
      header: {
        title: 'Proceso',
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ data }/>

    const columnData = {
        class: 'col-lg-8 col-8 offset-md-2',
        content: card,
      };

    this.column = <Column data={ columnData }/>

  }

  render() {
    return (
      <Row content={ this.column }/>
    )
  }
}

export default New;
