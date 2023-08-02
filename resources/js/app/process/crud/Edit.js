import React, { useEffect, useState, useRef  } from 'react';

import customerServices from "../services/Process"
import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Form from "../../../components/forms/Form"
import Button from "../../../components/general/Button"

function Edit(props) {

    const [formValues, setFormValues] = useState();

    useEffect(()=>{

      async function fetchDataCustomer(){

        let id = props.match.params.id;
        const res = await customerServices.get(id);

        if (res.success) {
          setFormValues(res.data);
        }
        else {
          alert(res.message)
        }

      }
      fetchDataCustomer();
    },[]);

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
        { type: 'text', name: 'name', label: 'Nombre', placeholder: 'cc', value: 'test' },
        { type: 'text', name: 'document', label: 'Documento', placeholder: '' , value: ''},
        { type: 'select', name: 'documentType', label: 'Tipo de Documento', placeholder: '', options: [{ name: 'CC', value: 'CC' }, { name: 'CE', value: 'CE' }, { name: 'NIT', value: 'NIT' }], value: '' },
        { type: 'textarea', name: 'description', label: 'Descipción', placeholder: '', value: '' },
        { type: 'text', name: 'contact', label: 'Contacto', placeholder: 'Nombre del contacto', value: '' },
        { type: 'email', name: 'contactEmail', label: 'Correo del Contacto', placeholder: 'Correo del contacto', value: '' },
        { type: 'text', name: 'contactPhone', label: 'Teléfono Contacto', placeholder: 'Teléfono Contacto', value: '' },
      ],
      values: formValues,
    };

    const form = <Form data={ dataForm } />;

    const footer = <Button data={ dataForm } onClick={ saveCustomer } type="submit" />;

    const data = {
      header: {
        title: 'Editar Clientes',
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ data }/>

    const columnData = {
        class: 'col-lg-8 col-8 offset-md-2',
        content: card,
      };

    const column = <Column data={ columnData }/>

    return (
      <Row content={ column }/>
    )
}

export default Edit;
