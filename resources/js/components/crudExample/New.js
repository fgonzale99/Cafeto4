import React, { useEffect, useState  } from 'react';

import customerServices from "../services/Customer"
import Column from "../general/Column"
import Row from "../general/Row"
import Card from "../general/Card"
import Form from "../general/Form"
import Button from "../general/Button"

function New(){

  const saveCustomer = async () => {

      const res = await customerServices.save();

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
    inputs: [
      { type: 'text', name: 'name', label: 'Nombre', placeholder: 'cc' },
      { type: 'number', name: 'numero', label: 'Numero', placeholder: '' },
      { type: 'date', name: 'date', label: 'Fecha', placeholder: '' },
      { type: 'email', name: 'email', label: 'Email', placeholder: '' },
      { type: 'password', name: 'password', label: 'Password', placeholder: '' },
      { type: 'file', name: 'file', label: 'Archivo', placeholder: '' },
      { type: 'textarea', name: 'area', label: 'Area', placeholder: '' },
      { type: 'areaeditor', name: 'editor', label: 'Editor', placeholder: '' },
      { type: 'select', name: 'select', label: 'Select', placeholder: '', options: [{ name: 'opcion 1', value: 'valor 1' }, { name: 'opcion 2', value: 'valor 2' }] },
      { type: 'radio', name: 'Radio', label: 'Radio', placeholder: '', options: [{ name: 'opcion 1', value: 'valor 1' }, { name: 'opcion 2', value: 'valor 2' }]  },
      { type: 'checkbox', name: 'checkbox', label: 'Checkbox', placeholder: '', options: [{ name: 'opcion 1', value: 'valor 1' }, { name: 'opcion 2', value: 'valor 2' }]   },
    ],
  };

  const form = <Form data={ dataForm } />;

  const footer = <Button data={ dataForm } onClick={ saveCustomer } />;

  const data = {
    header: {
      title: 'Clientes',
    },
    body: form,
    footer: footer,
  };

  const card = <Card data={ data }/>

  const columnData = {
      class: 'col-lg-12 col-12',
      content: card,
    };

  const column = <Column data={ columnData }/>

  return (
    <Row content={ column }/>
  )
}

export default New;
