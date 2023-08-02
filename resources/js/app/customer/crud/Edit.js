import React, { useEffect, useState, useRef  } from 'react';

import customerServices from "../services/Customer"
import moduleServices from "../../general/services/Module"

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Form from "../../../components/forms/Form"
import Button from "../../../components/general/Button"

class Edit extends React.Component {

  constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        dataForm: [],
      }

      this.updateCustomer = async e => {
          e.preventDefault()

          const form = document.getElementById("customerCreate");
          const data = new FormData(form);
          const res = await customerServices.update(data);

          if (res.success) {
            alert(res.message)
          }
          else {
            alert(res.message)
          }
      }

      this.state.dataForm = {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'customerCreate',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      };

    }

    async componentDidMount() {
      let id = this.props.match.params.id;
      const res = await customerServices.get(id);
      const moduleData = await moduleServices.getByName('customer');

      this.state.dataForm.formValues = res.data;
      this.state.dataForm.fields = moduleData.data;

      if(res.success == true && moduleData.success == true){
        this.setState({ isLoading: false });
      }
    }

    render() {

      if (this.state.isLoading) {
        return <div className="App">Cargando...</div>;
      }

      const form = <Form data={ this.state.dataForm } />;

      const footer = <Button data={ this.state.dataForm } onClick={ this.updateCustomer } type="submit" />;

      this.data = {
        header: {
          title: 'Editar Clientes',
        },
        body: form,
        footer: footer,
      };

      const card = <Card data={ this.data }/>

      const columnData = {
          class: 'col-lg-8 col-8 offset-md-2',
          content: card,
        };

      this.column = <Column data={ columnData }/>


      return (
        <Row content={ this.column }/>
      )
    }
}

export default Edit;
